<?php

include_once 'inc/samp.inc.php';
$server = new Server(Config::$_IP);
if($server->isOnline()) $sData = $server->getInfo();
else $sData = array('players' => 0,'maxplayers' => 0);

$d = Config::$g_con->prepare('SELECT PlayerName, Message, DateTime, PhoneNumber FROM Advertisements ORDER BY DateTime DESC LIMIT 10');
$d->execute();

include_once("inc/ago.inc.php");
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Home
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="<?php echo Config::$_PAGE_URL; ?>">
					Home
				</a>
				<!-- <i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">
					Dashboard
				</a>
			</li>-->
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue">
			<div class="visual">
				<i class="fa fa-user"></i>
			</div>
			<div class="details">
				<div class="number">
					 <?php echo number_format(Config::rows('PlayerInfo','SQLID'),0,'.','.'); ?>
				</div>
				<div class="desc">
					 Registered Accounts
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-gamepad"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php echo $sData['players'] . '/' . $sData['maxplayers']; ?>
				</div>
				<div class="desc">
					 Players Online
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat yellow">
			<div class="visual">
				<i class="fa fa-home"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php echo number_format(Config::rows('HouseInfo','ID'),0,'.','.'); ?>
				</div>
				<div class="desc">
					 Houses
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red">
			<div class="visual">
				<i class="fa fa-usd"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php echo number_format(Config::rows('BusinessInfo','ID'),0,'.','.'); ?>
				</div>
				<div class="desc">
					 Businesses
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-sitemap"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php echo number_format(Config::rows('FactionInfo','ID'),0,'.','.'); ?>
				</div>
				<div class="desc">
					 Factions
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>	
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat pink">
			<div class="visual">
				<i class="fa fa-car"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php echo number_format(Config::rows('VehicleInfo','ID'),0,'.','.'); ?>
				</div>
				<div class="desc">
					 Vehicles
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-thumbs-up"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php echo number_format(Config::rows('Whitelist','ID'),0,'.','.'); ?>
				</div>
				<div class="desc">
					 Whitelisted Accounts
				</div>
			</div>
			<a class="more" href="#">
				 More Details <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	
</div>
<div class="col-md-8 col-sm-8">
	<!-- BEGIN PORTLET-->
	<div class="portlet paddingless">
		<div class="portlet-title line">
			<div class="caption">
				<i class="fa fa-bell-o"></i>News Feed
			</div>
		</div>
		<div class="portlet-body">
			<!--BEGIN TABS-->
			<div class="tabbable tabbable-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_1_1" data-toggle="tab">
							 General
						</a>
					</li>
					
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1_1">
						<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible="0">
							<ul class="feeds">
							<?php
								while($row = $d->fetch(PDO::FETCH_OBJ)) {?>
								<li>
									<div class="col1">
										<div class="cont">
											<div class="cont-col1">
												<div class="label label-sm label-success">
													<i class="fa fa-bell-o"></i>
												</div>
											</div>
											<div class="cont-col2">
												<div class="desc">
													 <?php echo "{$row->Message} | Call:{$row->PhoneNumber} ({$row->PlayerName})"?>
												</div>
											</div>
										</div>
									</div>
									<div class="col2">
										<div class="date">
											 <?php $lastseen = strtotime("$row->DateTime"); ?>
											<?php $timeago = (time_ago("$lastseen", '0')); ?>
											<span class="badge"><?php echo "$timeago ago"; ?></span>
										</div>
									</div>
								</li>
								<?php }?>
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
<div class="col-md-4 col-sm-4">
	<!-- BEGIN PORTLET-->
	<div class="portlet paddingless">
		<div class="portlet-title line">
			<div class="caption">
				<i class="fa fa-facebook"></i>Facebook
			</div>
		</div>
		<div class="portlet-body">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=1545100102374621";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

		<div class="portlet-body">
				<div id="fb-root"></div>
				<div class="fb-page" data-href="https://www.facebook.com/APRP.Official" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/APRP.Official"><a href="https://www.facebook.com/APRP.Official">Angel Pine Roleplay</a></blockquote></div></div>
		</div>
	</div>
</div>