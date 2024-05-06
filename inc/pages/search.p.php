<?php
if(!defined('AWM'))
	die('Nope.');
	
if(!$_POST['search']) header('Location: ' . Config::$_PAGE_URL . '');
if(isset($_POST['sname']) || isset(Config::$_url[2]) != 0) {
	if(isset($_POST['sname'])) $_SESSION['sname'] = $_POST['sname'];
	if(Config::isLogged()) $admin = Config::getPlayerData($_SESSION['awm_user'],'AdminLevel');
	else $admin = 0;
	echo '
	<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="<?php echo Config::$_PAGE_URL; ?>">
					Home
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">
					Search
				</a>
			</li>
		</ul>

		<table class="table table-striped table-bordered table-advance table-hover">
			<tbody>
				<tr class="data">
					<th class="data">Name</th>
					<th class="data">Level</th>
					' . ($admin != 0 ? '<th class="data"><center>Actions</center></th></tr>' : '') . '
			';
	$q = Config::$g_con->prepare("SELECT PlayerName,level,SQLID FROM PlayerInfo WHERE PlayerName LIKE ? ".Config::_pagLimit());
	$q->execute(array('%'.$_SESSION['sname'].'%'));
	echo '';
	while($row = $q->fetch(PDO::FETCH_OBJ)) {
		echo 
			"<tr>
				<td><center><a href='".Config::$_PAGE_URL."profile/{$row->SQLID}'>{$row->PlayerName}</a></td>
				<td><center>{$row->level}</center></td>
				
			</tr>";
	}
	echo '<tbody></table>';
	$q = Config::$g_con->prepare("SELECT SQLID FROM PlayerInfo WHERE PlayerName LIKE ?");
	$q->execute(array('%'.$_SESSION['sname'].'%'));
	echo Config::_pagLinks($q->rowCount());
	
}
?>

<?php include_once("inc/theme.inc.php");?><br>
<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="<?php echo Config::$_PAGE_URL; ?>">
					Home
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">
					Search
				</a>
			</li>
		</ul>
<center>
<form method="POST" action="" align>
	<br>
	<input type="text" name="sname" placeholder="Name" class="form-control" id="exampleInputEmail1" style="width: 170px;"></br>
	<input class="btn btn-info" type="submit" name="submit" value="Search">
</form>
</center>

