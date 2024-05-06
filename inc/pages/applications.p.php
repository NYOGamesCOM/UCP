<?php
error_reporting(1);

$j = Config::$g_con->prepare('SELECT * FROM FactionInfo');
$j->execute();

$c = Config::$g_con->prepare('SELECT * FROM FactionInfo');
$c->execute();
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Applications
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
					Applications
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row profile">
	<div class="col-md-12">
		<!--BEGIN TABS-->
		<div class="tabbable tabbable-custom tabbable-full-width">
			<ul class="nav nav-tabs">
				<?php while($row = $j->fetch(PDO::FETCH_OBJ)) { ?>
				<li <?php if($row->groupID == 1) { echo 'class=active'; }?>>
					<a href="#tab_1_<?php echo $row->ID;?>" data-toggle="tab">
						 <?php echo Config::$factions[$row->ID]['lname'];?>
					</a>
				</li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<?php while($data = $c->fetch(PDO::FETCH_OBJ)) { ?>
				<div class="tab-pane <?php if($data->ID == 1) { echo 'active'; }?>" id="tab_1_<?php echo $data->ID;?>">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>ID</th>
											<th>Player</th>
											<th>Date</th>
											<th>Status</th>
											<th>View</th>
										</tr>
									</thead>
									<tbody>
										<?php $xoxo = Config::$g_con->prepare('SELECT * FROM FactionInfo WHERE ID = ? ORDER BY `Status` ASC');
												  $xoxo->execute(array($data->ID));
												  while($x0 = $xoxo->fetch(PDO::FETCH_OBJ)) { ?>
												  <tr><td><?php echo $x0->id;?></td>
												  <td><a href='<?php echo Config::$_PAGE_URL; ?>profile/<?php echo $x0->pID;?>'><?php echo Config::getPlayerData($x0->pID,'PlayerName');?></a></td>
												  <td><?php echo $x0->Date;?></td>
												  <td><?php if($x0->Status == 0) { echo "<b><font color='gold'>Pending</font></b>"; } if($x0->Status == 1) { echo "<b><font color='darkred'>Rejected</font></b>"; } if($x0->Status == 2) { echo "<b><font color='green'>Accepted</font></b>"; }?></td>
												  <td><a href='<?php echo Config::$_PAGE_URL; ?>application/<?php echo $x0->id;?>'><i class='fa fa-search'></i></a></td></tr>
												  <?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<?php }?>
			</div>
		</div>
	</div>
</div>