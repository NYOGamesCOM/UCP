<?php
if(!defined('AWM'))
	die('Nope.');

include_once 'inc/samp.inc.php';
$server = new Server(Config::$_IP);
if($server->isOnline()) $sData = $server->getInfo();
else $sData = array('players' => 0,'maxplayers' => 0);	

$w = Config::$g_con->prepare('SELECT SQLID, PlayerName,level,FactionID FROM PlayerInfo WHERE Online > 0 ORDER BY PlayerName DESC');
$w->execute();
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		<?php echo $sData['players']?> players are online
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
				<a href="#">
					Online
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-advance table-hover">
		<thead>
		<tr>
			<th>
				<i class="fa fa-user"></i> Name
			</th>
			<th class="hidden-xs">
				<i class="fa fa-sort-numeric-asc"></i> Level
			</th>
			<th>
				<i class="fa fa-group"></i> Faction
			</th>
			<th>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php 
			while($row = $w->fetch(PDO::FETCH_OBJ)) {
			echo'<tr>
				<td><center><a href='.Config::$_PAGE_URL.'profile/'.$row->SQLID.'>'.$row->PlayerName.'</a></center></td>
				<td><center>'.$row->level.'</center></td>
				<td><center>'. Config::$factions[$row->ID]['name'] .'</center></td>
				</tr>';} ?>
		</tbody>
		</table>
	</div>
</div>