<?php
if(!defined('AWM'))
	die('Nope.');


$d = Config::$g_con->prepare('SELECT SQLID, PlayerName, AdminLevel, Online, LastOnline FROM PlayerInfo WHERE AdminLevel > 0 ORDER BY AdminLevel DESC');
$d->execute();
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Staff
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
					Staff
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="col-md-12">
	<!-- BEGIN PORTLET-->
	<div class="portlet paddingless">
		<div class="portlet-body">
			<!--BEGIN TABS-->
			<div class="tabbable tabbable-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_1_1" data-toggle="tab">
							 Admins
						</a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab">
							 Helpers
						</a>
					</li>
					<li>
						<a href="#tab_1_3" data-toggle="tab">
							 VIP
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1_1">
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-advance table-hover">
								<thead>
								<tr>
									<th>
										<i class="fa fa-user"></i> Name
									</th>
									<th class="hidden-xs">
										<i class="fa fa-sort-numeric-asc"></i> Admin Level
									</th>
									<th>
										<i class="fa fa-clock-o"></i> Last Login
									</th>
									
								</tr>
								</thead>
								<tbody>
								<?php 
                                    while($row = $d->fetch(PDO::FETCH_OBJ)) {
									echo"<tr>
                                        <td class='highlight'>
										".($row->Online ? '<div class="success"></div>' : '<div class="important"></div>')."
										<a href=".Config::$_PAGE_URL.'profile/'.$row->SQLID.">".$row->PlayerName."</td>
                                        <td>{$row->AdminLevel}</td>
										<td>{$row->LastOnline}</td>
                                    </tr>";} ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab_1_2">
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-advance table-hover">
								<thead>
								<tr>
									<th>
										<i class="fa fa-user"></i> Name
									</th>
									<th class="hidden-xs">
										<i class="fa fa-sort-numeric-asc"></i> Helper Level
									</th>
									<th>
										<i class="fa fa-clock-o"></i> Last Login
									</th>
									<th>
									</th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$q = Config::$g_con->prepare('SELECT SQLID,PlayerName,Helper,Online,LastOnline FROM PlayerInfo WHERE Helper > 0 ORDER BY Helper DESC');
								$q->execute();
                                    while($row = $q->fetch(PDO::FETCH_OBJ)) {
									echo"<tr>
                                        <td class='highlight'>
										".($row->Online ? '<div class="success"></div>' : '<div class="important"></div>')."
										<a href=".Config::$_PAGE_URL.'profile/'.$row->SQLID.">".$row->PlayerName."</td>
                                        <td>{$row->Helper}</td>
										<td>{$row->LastOnline}</td>
                                    </tr>";} ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="tab_1_3">
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-advance table-hover">
								<thead>
								<tr>
									<th>
										<i class="fa fa-user"></i> Name
									</th>
									<th class="hidden-xs">
										<i class="fa fa-sort-numeric-asc"></i> VIP Level
									</th>
									<th>
										<i class="fa fa-clock-o"></i> Last Login
									</th>
									<th>
									</th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$q = Config::$g_con->prepare('SELECT SQLID,PlayerName,PremiumLevel,Online,LastOnline FROM PlayerInfo WHERE PremiumLevel > 0 ORDER BY PremiumLevel DESC');
								$q->execute();
                                    while($row = $q->fetch(PDO::FETCH_OBJ)) {
									echo"<tr>
                                        <td class='highlight'>
										".($row->Online ? '<div class="success"></div>' : '<div class="important"></div>')."
										<a href=".Config::$_PAGE_URL.'profile/'.$row->SQLID.">".$row->PlayerName."</td>
                                        <td>{$row->PremiumLevel}</td>
										<td>{$row->LastOnline}</td>
                                    </tr>";} ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--END TABS-->
		</div>
	</div>
	<!-- END PORTLET-->
</div>