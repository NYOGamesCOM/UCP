<?php
if(!defined('AWM')) 
	die('Nope.');
ob_start();	

if(Config::isLogged()) {

$user = $_SESSION['awm_user'];

$zzz = Config::$g_con->prepare('SELECT Skin, PlayerName, level FROM PlayerInfo WHERE SQLID = ?');
$zzz->execute(array($user));

$muia = $zzz->fetch(PDO::FETCH_OBJ);

$admin = Config::getPlayerData($user,'AdminLevel');
$helper2 = Config::getPlayerData($user,'Helper');


$not = Config::$g_con->prepare('SELECT * FROM OPMs WHERE ID = ? LIMIT 3');
$not->execute(array($user));

$numn = $not->rowCount();
}
include_once 'inc/samp.inc.php';
$server = new Server(Config::$_IP);
if($server->isOnline()) $sData = $server->getInfo();
else $sData = array('players' => 0,'maxplayers' => 0);

$i = Config::$g_con->prepare('SELECT * FROM PlayerInfo WHERE AdminLevel > 0 OR Helper > 0');
$i->execute();
$num1 = $i->rowCount();

$o = Config::$g_con->prepare('SELECT * FROM PlayerInfo WHERE AdminLevel > 0 AND Online > 0');
$o->execute();
$num2 = $o->rowCount();

$p = Config::$g_con->prepare('SELECT * FROM PlayerInfo WHERE Helper > 0 AND Online > 0');
$p->execute();
$num3 = $p->rowCount();

$num4 = $num2 + $num3;

?>
<html>
<head>
<meta charset="utf-8"/>
<title>User Control Panel</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo Config::$_PAGE_URL; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo Config::$_PAGE_URL; ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/pages/tasks.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/themes/<?php if(Config::isLogged()) { echo $muia->theme; } else { echo "light"; } ?>.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="<?php echo Config::$_PAGE_URL; ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo Config::$_PAGE_URL; ?>favicon.ico"/>

<script>
		var _PAGE_URL = '<?php echo Config::$_PAGE_URL; ?>';
</script>
</head>
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
		<?php
				if(Config::isLogged()) {
		?>
			<!-- BEGIN NOTIFICATION DROPDOWN -->
			<li class="dropdown" id="header_notification_bar">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="fa fa-bell-o"></i>
					<span class="badge">
						 <?php echo $numn; ?>
					</span>
				</a>
				<ul class="dropdown-menu extended notification">
					<li>
						<p>
							 You have <?php echo $numn; ?> new notifications
						</p>
					</li>
					<li>
						<ul class="dropdown-menu-list scroller" style="height: 250px;">
						<?php while($rand = $not->fetch(PDO::FETCH_OBJ)) {?>
							<li>
								<a href="<?php echo Config::$_PAGE_URL; ?>application/<?php echo $rand->aID;?>">
									<span>
										<i class="fa fa-bell-o"></i>
									</span>
									 <?php echo $rand->text;?> your application.
								</a>
							</li>
						<?php }?>
						</ul>
					</li>
					<li class="external">
						<a href="#">
							 See all notifications <i class="m-icon-swapright"></i>
						</a>
					</li>
				</ul>
			</li>
			<!-- END NOTIFICATION DROPDOWN -->
			<!-- BEGIN USER LOGIN DROPDOWN -->
			
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img src="<?php echo Config::$_PAGE_URL; ?>assets/img/100skin/<?php echo $muia->Skin; ?>.png" width="29" height="29">
					<span class="username">
						 <?php echo $muia->PlayerName; ?>
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo Config::$_PAGE_URL; echo(Config::isLogged() ? 'profile' : 'login') ?>">
							<i class="fa fa-user"></i> My Profile
						</a>
					</li>
					<li>
						<a href="<?php echo Config::$_PAGE_URL; echo(Config::isLogged() ? 'mytickets' : 'login') ?>">
							<i class="fa fa-ticket"></i> My Tickets
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-gear"></i> Settings
						</a>
					</li>
					<li>
						<a href="javascript:;" id="trigger_fullscreen">
							<i class="fa fa-arrows"></i> Full Screen
						</a>
					</li>
					<li>
						<a href="<?php echo Config::$_PAGE_URL; ?>logout">
							<i class="fa fa-key"></i> Log Out
						</a>
					</li>
				</ul>
			</li>
			<?php
				} else {
			?>
			<div class="as">
				<a href="<?php echo Config::$_PAGE_URL; ?>login">
					<font color="white"><i class="fa fa-sign-in"></i>
						 Login</font>
				</a>
			</div>
			<?php } ?>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class="sidebar-search" action="<?php echo Config::$_PAGE_URL; ?>search/" method="post">
						<div class="form-container">
							<div class="input-box">
								<a href="javascript:;" class="remove">
								</a>
								<input name="search" type="text" placeholder="Search..."/>
								<input type='submit' id='search-btn' class="submit" value=" "/>
							</div>
						</div>
					</form>
					
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li <?php echo Config::isActive(''); ?>>
					<a href="<?php echo Config::$_PAGE_URL; ?>">
						<i class="fa fa-home"></i>
						<span class="title">
							Home
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
				<li <?php echo Config::isActive(array('profile','login','changeemail','changepass')); ?>>
					<a href="<?php echo Config::$_PAGE_URL; echo(Config::isLogged() ? 'profile' : 'login') ?>">
						<?php echo(Config::isLogged() ? '<i class="fa fa-fw fa-user"></i>' : '<i class="fa fa-fw fa-unlock"></i>') ?>
						<span class="title">
							<?php echo(Config::isLogged() ? 'Profile' : 'Login') ?>
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
				<li <?php echo Config::isActive('staff'); ?>>
					<a href="<?php echo Config::$_PAGE_URL; ?>staff">
						<i class="fa fa-android"></i>
						<span class="title">
							Staff<div class="rig"><span class="badge badge-warning"><?php echo "$num4"; ?>/<?php echo "$num1"; ?></span></div>
						</span>
						<span class="selected">
						</span>
					</a>
				</li>		
				<li <?php echo Config::isActive('online'); ?>>
					<a href="<?php echo Config::$_PAGE_URL; ?>online">
						<i class="fa fa-gamepad"></i>
						<span class="title">
							Online<div class="rig"><span class="badge badge-warning"><?php echo $sData['players']?></span></div>
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
				<li <?php echo Config::isActive('search'); ?>>
					<a href="<?php echo Config::$_PAGE_URL; ?>search">
						<i class="fa fa-search"></i>
						<span class="title">
							Search
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
				<li <?php echo Config::isActive('banlist'); ?>>
					<a href="<?php echo Config::$_PAGE_URL; ?>banlist">
						<i class="fa fa-search"></i>
						<span class="title">
							Banlist
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
				<li <?php echo Config::isActive(array('factions','apply','faction','applications','application')); ?>>
					<a href="javascript:;">
						<i class="fa fa-users"></i>
						<span class="title">
							Factions
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Config::$_PAGE_URL; ?>factions">
								<i class="fa fa-list"></i>
								List
							</a>
						</li>
						<li>
							<a href="<?php echo Config::$_PAGE_URL; ?>applications">
								<i class="fa fa-pencil-square-o"></i>
								Applications
							</a>
						</li>
					</ul>
				</li>
				<li <?php echo Config::isActive(array('apply')); ?>>
					<a href="javascript:;">
						<i class="fa fa-users"></i>
						<span class="title">
							Whitelist
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Config::$_PAGE_URL; ?>apply">
								<i class="fa fa-list"></i>
								Apply
							</a>
						</li>
					</ul>
				</li>
				<li <?php echo Config::isActive(array('top','richest','highestlevel')); ?>>
					<a href="javascript:;">
						<i class="fa fa-users"></i>
						<span class="title">
							Stats
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Config::$_PAGE_URL; ?>top">
								<i class="fa fa-list"></i>
								Top Players
							</a>
						</li>
						<li>
							<a href="<?php echo Config::$_PAGE_URL; ?>richest">
								<i class="fa fa-list"></i>
								Richest Players
							</a>
						</li>
						<li>
							<a href="<?php echo Config::$_PAGE_URL; ?>highestlevel">
								<i class="fa fa-list"></i>
								Highest Level
							</a>
						</li>
					</ul>
				</li>
				<li <?php echo Config::isActive(array('shop','buy','methods')); ?>>
					<a href="<?php echo Config::$_PAGE_URL; ?>shop">
						<i class="fa fa-usd"></i>
						<span class="title">
							Shop
						</span>
						<span class="selected">
						</span>
					</a>
				</li>				
				<li>
					 <a href="http://ap-rp.com/forum">
						<i class="fa fa-comments"></i>
						<span class="title">
							Forum
						</span>
						<span class="selected">
						</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	
	<div class="page-content-wrapper">
		<div class="page-content">