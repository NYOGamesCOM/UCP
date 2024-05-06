<?php
if(!defined('AWM'))
	die('Nope.');

$d = Config::$g_con->prepare('SELECT ID, Owner, Rentprice FROM HouseInfo WHERE ID > 0 ORDER BY ID DESC');
$d->execute();
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Stuff
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
					Stuff
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
						<a href="#tab_1_2" data-toggle="tab">
							 Houses
						</a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab">
							 Businesses
						</a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab">
							 Vehicles
						</a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab">
							 Factions
						</a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab">
							 Whitelist
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
										<i class="fa fa-numeric-asc"></i> Name
									</th>
									<th class="hidden-xs">
										<i class="fa fa-sort-user"></i> Owner
									</th>
									<th>
										<i class="fa fa-clock-o"></i> Rent Price
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
                                        <td>{$row->ID}</td>
										<td>{$row->Rentprice}</td>
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