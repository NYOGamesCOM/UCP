<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');
if(isset(Config::$_url[1])) $user = (int)Config::$_url[1];
else $user = $_SESSION['awm_user'];

$q = Config::$g_con->prepare('SELECT a.*,b.Name,h.ID FROM PlayerInfo a LEFT JOIN BusinessInfo b ON (b.Owner = a.PlayerName) LEFT JOIN HouseInfo h ON (h.Owner = a.PlayerName) WHERE a.SQLID = ?');
$q->execute(array($user));
if(!$q->rowCount()) {
	echo '<div class="alert alert-danger">This user does not exist.</div>';
	return;
}
$data = $q->fetch(PDO::FETCH_OBJ);


$c = Config::$g_con->prepare('SELECT * FROM `VehicleInfo` WHERE `Owner` LIKE ?');
$c->execute(array($data->PlayerName));

include("inc/carvalue.php");

?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		<?php echo $data->PlayerName; ?>'s Profile
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
					Profile
				</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<?php echo $data->PlayerName; ?>
			</li>
		</ul>
		
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<div class="pskin">
			<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/bskin/<?php echo $data->Skin; ?>.png" height="400px" style="padding:10px;"/>
		</div>
	</div>
	<div class="col-md-4">
		<h4><b><?php echo $data->PlayerName; ?></b> 
		<?php if($data->AdminLevel > 0) {?>
			<button class="btn tooltips" data-placement="top" data-original-title="This user is admin."><i class="fa fa-shield"></i></button>
		<?php } ?>
		<?php if($data->Helper > 0) {?>
			<button class="btn tooltips" data-placement="top" data-original-title="This user is helper."><i class="fa fa-mortar-board"></i></button>
		<?php } ?>
		<?php if($data->PremiumLevel > 0) {?>
			<button class="btn tooltips" data-placement="top" data-original-title="This user have premium account."><i class="fa fa-star"></i></button>
		<?php } ?>
		
		</h4> 
		<div class="portlet-body">
			<div class="table-responsive">
				<table class="table">
				<tbody>
					<tr>
						<td style="font-size: 13px;">
							 <b>Status:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo ($data->Online ? '<font color="green">ONLINE</font>' : '<font color="red">OFFLINE</font>'); ?>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Level:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo $data->level; ?>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Money:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo number_format($data->Money,0,'.','.'); ?> <font color="green">$</font>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Bank Money:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo number_format($data->Bank,0,'.','.'); ?> <font color="green">$</font>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Played hours:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo number_format($data->TotalPlayTime,0,'.','.'); ?>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Respect points:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo $data->RPoints . ' / ' . ($data->level == 1 ? '6' : ($data->level+1)*4); ?>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Age:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo $data->Age; ?>
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Warns:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo $data->Warns; ?>/5
						</td>
					</tr>
					<tr>
						<td style="font-size: 13px;">
							 <b>Last login:</b>
						</td>
						<td style="font-size: 13px;">
							 <?php echo $data->LastOnline; ?>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<!-- BEGIN PORTLET-->
		<div class="portlet paddingless">
			<div class="portlet-body">
				<!--BEGIN TABS-->
				<div class="tabbable tabbable-custom">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">
								 Vehicles
							</a>
						</li>
						<li>
							<a href="#tab_1_2" data-toggle="tab">
								 House
							</a>
						</li>
						<li>
							<a href="#tab_1_3" data-toggle="tab">
								 Business
							</a>
						</li>
						<li>
							<a href="#tab_1_4" data-toggle="tab">
								 Licenses
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1_1">
							<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible="0">
								<ul class="feeds">
									<div class="portlet-body">
										<div class="table-responsive">
											<table class="table">
												<tbody>
													<tr>
														<?php while($dac = $c->fetch(PDO::FETCH_OBJ)) { ?>
														<td align="center" style="font-size: 13px;"><img src="http://weedarr.wdfiles.com/local--files/veh/<?php echo $dac->Model; ?>.png" height="80px"/>
															<div class="table-responsive">
																<table >
																	<tbody>
																		<br>
																		<tr>
																			<td style="font-size: 13px;"><b>Price:</b></td>
																			<td style="font-size: 13px;"><?php echo $dac->Sellprice; ?><font color="green"></b>$</b></font></td>
																		</tr>
																		<tr>
																			<td style="font-size: 13px;"><b>Plate:</b></td>
																			<td style="font-size: 13px;"><?php echo $dac->Plate; ?></td>
																		</tr>
																		<tr>
																			<td style="font-size: 13px;"><b>Mileage:</b></td>
																			<td style="font-size: 13px;"><?php echo $dac->Mileage; ?><font color="green"></b>Km</b></font></td>
																		</tr>
																		<tr>
																			<td style="font-size: 13px;" align="center"><i class="fa fa-map-marker"></i><a href="<?php echo Config::$_PAGE_URL; ?>seemap/<?php echo $dac->X;?>/<?php echo $dac->Y;?>">display on map</a></td>
																			<td></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</td> 
														<?php }?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</ul>
							</div>
						</div>
						<div class="tab-pane" id="tab_1_2">
							<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
								<ul class="feeds">
									<div class="portlet-body">
										<div class="table-responsive">
											<table class="table">
											<?php if(($data->ID) > 0) { ?>
												<thead>
													<th><b>House ID:</b></th>
													<th><?php echo $data->ID; ?></th>
												</thead>
												<tbody>
													<tr>
														<td style="font-size: 13px;">
															 <b>Price:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo number_format(Config::getHouseData("HouseInfo", "Sellprice", ($data->ID)),0,'.','.'); ?> <font color="green"><b>$</b></font>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;">
															 <b>Level:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo number_format(Config::getHouseData("HouseInfo", "Level", ($data->ID)),0,'.','.'); ?>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;">
															 <b>Rent:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo number_format(Config::getHouseData("HouseInfo", "RentPrice", ($data->ID)),0,'.','.'); ?> <font color="green"><b>$</b></font>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;">
															 <b>Status:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo (Config::getHouseData("HouseInfo", "Closed", ($data->ID)) == 0 ? '<font color="green">Opened</font>':'<font color="red">Locked</font>'); ?>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;"><i class="fa fa-map-marker"></i><a href="<?php echo Config::$_PAGE_URL; ?>seemap/<?php echo Config::getHouseData("HouseInfo", "X", ($data->ID));?>/<?php echo Config::getHouseData("HouseInfo", "Y", ($data->ID));?>">display on map</a></td>
														<td></td>
													</tr>
												</tbody>
											<?php } else { ?><center>This player does not own a house.</center> <?php } ?>
											</table>
										</div>
									</div>
								</ul>
							</div>
						</div>
						<div class="tab-pane" id="tab_1_3">
							<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
								<ul class="feeds">
									<div class="portlet-body">
										<div class="table-responsive">
											<table class="table">
											<?php if(Config::getBizData("BusinessInfo", "ID", ($data->Name)) > 0) { ?>
												<thead>
													<th><b>Business name:</b></th>
													<th><?php echo $data->Name; ?></th>
												</thead>
												<tbody>
													<tr>
														<td style="font-size: 13px;">
															 <b>Business ID:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo Config::getBizData("BusinessInfo", "ID", ($data->Name)); ?>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;">
															 <b>Price:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo number_format(Config::getBizData("BusinessInfo", "Sellprice", ($data->Name)),0,'.','.'); ?> <font color="green"><b>$</b></font>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;">
															 <b>Business fee:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo number_format(Config::getBizData("BusinessInfo", "Tax", ($data->Name)),0,'.','.'); ?> <font color="green"><b>$</b></font>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;">
															 <b>Status:</b>
														</td>
														<td style="font-size: 13px;">
															<?php echo (Config::getBizData("BusinessInfo", "Locked", ($data->Name)) == 0 ? '<font color="green">Opened</font>':'<font color="red">Locked</font>'); ?>
														</td>
													</tr>
													<tr>
														<td style="font-size: 13px;"><i class="fa fa-map-marker"></i><a href="<?php echo Config::$_PAGE_URL; ?>seemap/<?php echo Config::getBizData("BusinessInfo", "X", ($data->Name));?>/<?php echo Config::getBizData("BusinessInfo", "Y", ($data->Name));?>">display on map</a></td>
														<td></td>
													</tr>
												</tbody>
											<?php } else { ?><center>This player does not own a business.</center> <?php } ?>
											</table>
										</div>
									</div>
								</ul>
							</div>
						</div>
						<div class="tab-pane" id="tab_1_4">
							<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
								<ul class="feeds">
									<div class="portlet-body">
										<div class="table-responsive">
											<table class="table" align="center" >
												<?php echo($data->DriverLicense == 1 ? '<td><br><center><i class="fa fa-car fa-2x"></i><br><br><b>Driving</b><br>'.$data->DriverLicense.' hours</td>' : '</center>'); ?>
												<?php echo($data->PilotLicense == 1 ? '<td><br><center><i class="fa fa-plane fa-2x"></i><br><br><b>Flying</b><br>'.$data->PilotLicense.' hours</td>' : '</center>'); ?>
												<?php echo($data->SailingLicense == 1 ? '<td><br><center><i class="fa fa-support fa-2x"></i><br><br><b>Sailing</b><br>'.$data->SailingLicense.' hours</td>' : '</center>'); ?>
												<?php echo($data->WeaponLicense == 1 ? '<td><br><center><i class="fa fa-crosshairs fa-2x"></i><br><br><b>Weapon</b><br>'.$data->WeaponLicense.' hours</td>' : '</center>'); ?>
												<?php if(!$data->DriverLicense && !$data->PilotLicense && !$data->SailingLicense) echo '<br><td style="padding:5px;">None.</td>'; ?>
											</table>
										</div>
									</div>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!--END TABS-->
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
</div>
<div class="row">

	
	<div class="col-md-6 col-sm-6">
		<!-- BEGIN PORTLET-->
		<div class="portlet paddingless">
			<div class="portlet-body">
				<!--BEGIN TABS-->
				<div class="tabbable tabbable-custom">
					<ul class="nav nav-tabs">
						
						<li>
							<a href="#tab_3_1" data-toggle="tab">
								 Signature
							</a>
						</li>
						
					</ul>
					<div class="tab-content">
						
						<div>
							<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
								<ul class="feeds">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<center><tr align ="center"><td><img src="<?php echo Config::$_PAGE_URL; ?>signature/<?php echo $user; ?>"><br>
												<br>HTML Code: <input type="text" class="form-control placeholder-no-fix" value="<img src='<?php echo Config::$_PAGE_URL; ?>signature/<?php echo $user; ?>'>" style="width:230px;"/>
												<br>AP-RP Forum: <input type="text" class="form-control placeholder-no-fix" value="[rpg=<?php echo $user; ?>]" style="width:230px;"/></td></tr></center>

											</tbody>
										</table>
									</div>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!--END TABS-->
			</div>
		</div>
		<!-- END PORTLET-->
	</div>
	
</div>

