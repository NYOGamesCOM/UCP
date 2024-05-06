<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');

$user = $_SESSION['awm_user'];

$q = Config::$g_con->prepare('SELECT * FROM dtickets WHERE pID = ? ORDER BY date DESC');
$q->execute(array($user));
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		<?php echo Config::getPlayerData($user,'playerName');?>'s tickets
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
					Tickets
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-advance table-hover">
			<thead>
			<tr>
				<th>
					<i class="fa fa-sort-numeric-asc"></i> ID
				</th>
				<th class="hidden-xs">
					<i class="fa fa-gear"></i> Status
				</th>
				<th>
					<i class="fa fa-clock-o"></i> Data
				</th>
				<th>
					<i class="fa fa-tags"></i> Metoda
				</th>
				<th>
					<i class="fa fa-usd"></i> Suma
				</th>
				<th>
					<i class="fa fa-car"></i> Item
				</th>
			</tr>
			</thead>
			<tbody>
			<?php while($row = $q->fetch(PDO::FETCH_OBJ)) {?>
			<tr class='ban_<?php echo $row->id;?>'>
				<td><?php echo $row->id;?></td>
				<td>
					<?php if($row->status == 1) { ?> <div id="clos" style="background-color: red"><b><font color="white">Rejected</font></b></div> <?php } ?>
					<?php if($row->status == 2) { ?> <div id="clos" style="background-color: green"><b><font color="white">Completed</font></b></div> <?php } ?>
					<?php if($row->status == 3) { ?> <div id="clos" style="background-color: #C7A444"><b><font color="white">Pending...</font></b></div> <?php } ?> 
				</td>
				<td><?php echo $row->date;?></td>
				<td><?php echo $row->met;?></td>
				<td><?php echo $row->suma;?></td>
				<td><?php echo $row->pentru;?></td>
			</tbody>
			<?php }?>
			</table>
		</div>
	</div>
</div>