<?php
	if(Config::isLogged()) 
	{
		$leader = Config::getPlayerData($_SESSION['awm_user'],'playerLeader');
		$q = Config::$g_con->prepare('SELECT * FROM groups WHERE groupID = ?');
		$q->execute(array($leader));
		$smt = $q->fetch(PDO::FETCH_OBJ);
		$m = Config::$g_con->prepare('SELECT playerID FROM playeraccounts WHERE playerGroup = ?');
		$m->execute(array($leader));
		$numm = $m->rowCount();
	}
	if(isset($_POST['close']))
	{
		echo "<center><font color=darkred>You have closed the applications!</font></center><br>";
		$fa = Config::$g_con->prepare('UPDATE `groups` SET `groupApplications`=0 WHERE `groupID`=?');
		$fa->execute(array($leader));
	}
	if(isset($_POST['open']))
	{
		echo "<center><font color=green>You have open the applications!</font></center><br>";
		$fa = Config::$g_con->prepare('UPDATE `groups` SET `groupApplications`=1 WHERE `groupID`=?');
		$fa->execute(array($leader));
	}
?>
<?php if( Config::isLogged() && $leader > 0) {?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Leader Control Panel - <b><?php echo Config::$factions[$leader]['name']; ?></b>
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
					Leader Control Panel
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<center>
			Faction members: <b><?php echo $numm;?> / <?php echo $smt->groupMaxMembers;?></b>
			<br>Applications curent status: <?php if($smt->groupApplications == 0) { echo '<b><font color="darkred">Closed</b></font>'; } else { echo '<b><font color="green">Opened</b></font>'; }?>
			<br>
			<form action="" method="post" >
				<button type="submit" class="btn red pull" id="close" name="close">
				<i class="fa fa-lock"></i> Close
				</button>
				<button type="submit" class="btn green pull" id="open" name="open">
				Open <i class="fa fa-unlock"></i>
				</button>
			</form>
		</center>
	</div>
</div>
<?php }?>