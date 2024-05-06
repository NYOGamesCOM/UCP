<?php
if(!defined('AWM'))
	die('Nope.');
if(!isset(Config::$_url[1]) || !is_numeric(Config::$_url[1])) header('Location: ' . Config::$_PAGE_URL . 'clans');
$q = Config::$g_con->prepare('SELECT a.playerClan,a.playerClanRank,a.playerName,a.playerID,g.* FROM clans g LEFT JOIN playeraccounts a ON ( a.playerClan = g.clanID ) WHERE g.clanID = ? ');
$q->execute(array((int)Config::$_url[1]));

if(!$q->rowCount()) header('Location: ' . Config::$_PAGE_URL . 'clans');


if(Config::isLogged()) {
	$pq = Config::$g_con->prepare('SELECT clanName,clanTag FROM clans WHERE clanID = ?');
	$pq->execute(array((int)Config::$_url[1]));

	$data = $pq->fetch(PDO::FETCH_OBJ);
}
$rank = 0;

$i = Config::$g_con->prepare('SELECT playerID FROM playeraccounts WHERE playerClan = ?');
$i->execute(array((int)Config::$_url[1]));
$nu = $i->rowCount();
echo '</table>';
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		<?php echo $data->clanName;?>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="<?php echo Config::$_PAGE_URL; ?>">
					Home
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="<?php echo Config::$_PAGE_URL; ?>clans">
					Clans
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">
					<?php echo $data->clanName;?>
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>


	<div class="col-sm-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Clan Details</h3>
			</div>
			<div class="panel-body">       
				<ul class="list-group">
					<li class="list-group-item"><b>Clan Name:</b> <?php echo $data->clanName?></li>
					<li class="list-group-item"><b>Clan Tag:</b> <?php echo $data->clanTag?></li>
					<li class="list-group-item"><b>Members:</b> <?php echo $nu?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
	<div class="panel-heading">
				<h3 class="panel-title"><b>Clan Members</b></h3>
			</div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Rank</th>
					
					</tr>
				</thead>
				<?php echo 
					'
					<tbody>';
						while($row = $q->fetch(PDO::FETCH_OBJ)) {
						$rank ++;
						echo"<tr>
							<td>$rank</td>
							<td><a href=".Config::$_PAGE_URL.'profile/'.$row->playerID.">".$row->playerName."</td>
							<td>{$row->playerClanRank}</td>
						</tr>";}
					echo"</tbody>";?>
				</table>
			</div>
	</div>
