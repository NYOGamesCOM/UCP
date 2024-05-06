<?php
class Config {
	private static $instance;
	public static $g_con;
	public static $_url = array();
	private static $_pages = array(
		'login','online','profile','profile2','logout','factions','faction','banlist','staff','changepass','changeemail','recover','signature','sig','search','forum' , 'stats', 'top', 'refe', 'logs', 'referral', 'htop', 'unban', 'clans', 'map', 'ureq', 'unbanpg', 'clan', 'warlog', 'map', 'seemap', 
		'apply', 'applications', 'application', 'lcp', 'shop', 'methods', 'buy', 'mytickets', 'donations', 'donation', 'asd'
	);
	public static $factions = array();
	public static $jobs = array();
	public static $clans = array();
	public static $tag = array();
	public static $_PAGE_URL = 'http://ap-rp.com/';
	private static $_perPage = 18;
	public static $_IP = '144.76.68.79:9665';

 	private function __construct() {
		$db['mysql'] = array(
			'host' 		=> 	'localhost',
			'username' 	=> 	'nyogamesdb',
			'password' 	=> 	'REkkBZxutrpR',
			'dbname' 	=> 	'aprpdb'
		);
		
		try {
			self::$g_con = new PDO('mysql:host='.$db['mysql']['host'].';dbname='.$db['mysql']['dbname'].';charset=utf8',$db['mysql']['username'],$db['mysql']['password']);
			self::$g_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			self::$g_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			error_log($e->getMessage());
		}
		self::_getUrl();
		self::arrays();
	}
	
	public static function init()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public static function isLogged() {
		return isset($_SESSION['awm_user']) ? true : false;
	}

	private static function _getUrl() {
		$url = isset($_GET['page']) ? $_GET['page'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        self::$_url = explode('/', $url);
	}
	
	public static function mapx() {
		
		$name = getPlayerData(isset($_SESSION['awm_user']),'PlayerName') ;
		
		$b = self::$g_con->prepare('SELECT posX FROM VehicleInfo WHERE Owner LIKE ?');
		$b->execute(array($name));

		return $b;
	}
	public static function mapy() {
		
		$name = getPlayerData(isset($_SESSION['awm_user']),'PlayerName') ;

		$c = self::$g_con->prepare('SELECT posY FROM VehicleInfo WHERE Owner LIKE ?');
		$c->execute(array($name));

		return $c;
	}
	
	public static function getContent() {
		if(self::$_url[0] === 'action' && file_exists('inc/actions/' . self::$_url[1] . '.a.php')) { include 'inc/actions/' . self::$_url[1] . '.a.php'; return; }
	
		if(isset(self::$_url[0]) && self::$_url[0] === 'signature') include_once 'inc/pages/signature.p.php'; ;
		if(isset(self::$_url[0]) && self::$_url[0] === 'map') include_once 'inc/pages/map.p.php'; ;
		include_once 'inc/header.inc.php';

			if(in_array(self::$_url[0],self::$_pages)) 
				include 'inc/pages/' . self::$_url[0] . '.p.php';
			else 
				include_once 'inc/pages/index.p.php'; 

		include_once 'inc/footer.inc.php';
		
	
/* 	include_once 'inc/header.inc.php';
	include_once 'inc/footer.inc.php'; */
	}
	
	
	
	public static function rows($table,$id = '*') {
		if(is_array($table)) {
			$rows = 0;
			foreach($table as $val) {
				$q = self::$g_con->prepare("SELECT ".$id." FROM `".$val."`");
				$q->execute();
				$rows += $q->rowCount();
			}
			return $rows;
		}
		$q = self::$g_con->prepare("SELECT ".$id." FROM `".$table."`");
		$q->execute();
		return $q->rowCount();
	}

	public static function getPlayerData($id,$data) {
		$q = self::$g_con->prepare("SELECT `".$data."` FROM `PlayerInfo` WHERE `SQLID` = '$id'");
		$q->execute();
		if($q) {
			$udata = $q->fetch();
			return $udata[$data];
		}	
		else return 0;
	}
	
	public static function getFactionData($id,$data) {
		$q = self::$g_con->prepare("SELECT `".$data."` FROM `FactionInfo` WHERE `ID` = '$id'");
		$q->execute();
		if($q) {
			$udata = $q->fetch();
			return $udata[$data];
		}	
		else return 0;
	}
	
	public static function isActive($active) {
		if(is_array($active)) {
			foreach($active as $ac) {
				if($ac === self::$_url[0]) return ' class="active"';
			}
			return;
		} else return self::$_url[0] === $active ? ' class="active"' : false;
	}

	public static function isAjax() {
		if(!self::isLogged()) return false;
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			return true;
		}
		return false;
	}
	
	public static function _pagLimit() {
		if(!isset(self::$_url[2]))
			self::$_url[2] = 1;
		return "LIMIT ".((self::$_url[2] * self::$_perPage) - self::$_perPage).",".self::$_perPage;
	}

	public static function _pagLinks($rows) {
		if(!isset(self::$_url[2]))
			self::$_url[2] = 1;
		$adjacents = "2";
		$prev = self::$_url[2] - 1;
		$next = self::$_url[2] + 1;
		$lastpage = ceil($rows/self::$_perPage);
		$lpm1 = $lastpage - 1;

		$pagination = "<div class='pagination dark'>";
		if($lastpage > 1)
		{   
			if ($lastpage < 7 + ($adjacents * 2))
			{   
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == self::$_url[2])
						$pagination.= "<a class='page gradient active' href='#'>$counter</a>";
					else
						$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$counter'>$counter</a>";                   
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))
			{
				if(self::$_url[2] < 1 + ($adjacents * 2))       
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == self::$_url[2])
							$pagination.= "<a class='page gradient active' href='#'>$counter</a>";
						else
							$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$counter'>$counter</a>";                   
					}
					$pagination.= "<a class='page gradient active' href='#'>...</a>";
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$lpm1'>$lpm1</a>";
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$lastpage'>$lastpage</a>";       
				}
				elseif($lastpage - ($adjacents * 2) > self::$_url[2] && self::$_url[2] > ($adjacents * 2))
				{
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/1'>1</a>";
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/2'>2</a>";
					$pagination.= "<a class='page gradient active' href='#'>...</a>";
					for ($counter = self::$_url[2] - $adjacents; $counter <= self::$_url[2] + $adjacents; $counter++)
					{
						if ($counter == self::$_url[2])
							$pagination.= "<a class='page gradient active' href='#'>$counter</a>";
						else
							$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$counter'>$counter</a>";                   
					}
					$pagination.= "<a class='page gradient active' href='#'>...</a>";
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$lpm1'>$lpm1</a>";
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$lastpage'>$lastpage</a>";      
				}
				else
				{
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/1'>1</a>";
					$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/2'>2</a>";
					$pagination.= "<a class='page gradient active' href='#'>...</a>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == self::$_url[2])
							$pagination.= "<a class='page gradient active' href='#'>$counter</a>";
						else
							$pagination.= "<a class='page gradient' href='".self::$_PAGE_URL.self::$_url[0]."/page/$counter'>$counter</a>";                   
					}
				}
			}
		}
		return $pagination .= '</div>';
	}
	
	private static function arrays() {
		$q = self::$g_con->prepare('SELECT FactionName,ID, MaxMembers FROM FactionInfo');
		$q->execute();
		self::$factions[0]['name'] = 'Civil';

		while($row = $q->fetch(PDO::FETCH_OBJ)) {
			self::$factions[$row->ID]['name'] = $row->FactionName;		
		}
	}
	
	public static function getHouseData($table,$data,$id) {
		$q = Config::$g_con->prepare('SELECT `'.$data.'` FROM `'.$table.'` WHERE `ID` = ?');
		$q->execute(array($id));
		$r_data = $q->fetch();
		return $r_data[$data];
	}
	public static function getBizData($table,$data,$id) {
		$q = Config::$g_con->prepare('SELECT `'.$data.'` FROM `'.$table.'` WHERE `Name` = ?');
		$q->execute(array($id));
		$r_data = $q->fetch();
		return $r_data[$data];
	}

}
?>