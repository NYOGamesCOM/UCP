<?php
error_reporting(1);

$b = Config::$g_con->prepare('SELECT * FROM applications WHERE id = ?');
$b->execute(array((int)Config::$_url[1]));

$data = $b->fetch(PDO::FETCH_OBJ);

$k = Config::$g_con->prepare('SELECT * FROM notifications WHERE aID = ?');
$k->execute(array((int)Config::$_url[1]));
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
			<?php echo Config::getPlayerData($data->pID,'PlayerName');?>'s application at <?php echo Config::$factions[$data->fID]['name']; ?>
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

<div class="row">
	<?php
	if(isset($_POST['accept']))
	{
		if(Config::getPlayerData($data->pID,'playerGroup') != 0)
		{
			echo "<center><font color=red>This application has been rejected automatically because this player is already in a faction!</font></center><br>";
			$fa = Config::$g_con->prepare('UPDATE `applications` SET `Status`=1 WHERE `id`=?');
			$fa->execute(array($data->id));
		} else {
			if(Config::getPlayerData($data->pID,'playerStatus') != 0) echo "<center><font color=red><h5>[WARNING!]: Acest player este deja conectat! Pentru a evita problemele accepta aici cererea si foloseste [/invite] din server!</h5></font></center>";
			echo "<center><font color=green>You have accepted his application! The application has been closed.</font></center><br>";
			
			$message = 'has joined the group '.Config::$factions[$data->fID]['name'].'. (application accepted by '.Config::getPlayerData($_SESSION['awm_user'],'playerName').')';
			$fa = Config::$g_con->prepare('UPDATE `applications` SET `Status`=2 WHERE `id`=?');
			$fa->execute(array($data->id));
			$fa = Config::$g_con->prepare('UPDATE `playeraccounts` SET `playerGroup`=?,`playerLeader`=0,`playerGroupRank`=1,`pFWarn`=0,`playerFactionEntry`=? WHERE `playerID`=?');
			$fa->execute(array($data->fID,date('Y-m-d h:m:s'),$data->pID));
			$fa = Config::$g_con->prepare('INSERT INTO `log_faction` (`fac_player_name`,`fac_player_id`,`fac_time`) VALUES (?,?,?)');
			$fa->execute(array(Config::getPlayerData($data->pID,'playerName'),$data->pID,strtotime(date('Y-m-d h:m:s'))+1040));
			
			$as = Config::$g_con->prepare('UPDATE `log_faction` SET `fac_text` = ? WHERE `fac_time` = ?');
			$as->execute(array($message,strtotime(date('Y-m-d h:m:s'))+1040));
			
			$message = ''.Config::getPlayerData($_SESSION['awm_user'],'playerName').' has accepted';
			$fa = Config::$g_con->prepare('INSERT INTO `notifications` (`aID`,`pID`,`Time`) VALUES (?,?,?)');
			$fa->execute(array(Config::getPlayerData($_SESSION['awm_user'],'playerID'),$data->pID,strtotime(date('Y-m-d h:m:s'))+1040));
			$as = Config::$g_con->prepare('UPDATE `notifications` SET `text` = ? WHERE `Time` = ?');
			$as->execute(array($message,strtotime(date('Y-m-d h:m:s'))+1040));
		}
	}
	if(isset($_POST['reject']))
	{
		echo "<center><font color=red>You have rejected his application! The application has been closed.</font></center><br>";
		$fa = Config::$g_con->prepare('UPDATE `applications` SET `Status`=1 WHERE `id`=?');
		$fa->execute(array($data->id));
	}
	?>
	<div class="col-md-12">
		<div class="col-md-6">
			<b>Status:</b> <?php if($data->Status == 0) { echo "<b><font color='gold'>Pending</font></b>"; } if($data->Status == 1) { echo "<b><font color='darkred'>Rejected</font></b>"; } if($data->Status == 2) { echo "<b><font color='green'>Accepted</font></b>"; }?>
			<br><b>Date:</b> <?php echo $data->Date;?>
			<hr></hr>
	
			<?php while($k = $vb->fetch(PDO::FETCH_OBJ)) { ?>
				<?php echo $vb->id;?> <?php echo $vb->text;?> <?php echo Config::getPlayerData($vb->pID,'playerName');?> asd<br>
			<?php 
			}
			?>
			<p><h5>"De ce vrei sa intri in <strong><?php echo Config::$factions[$data->fID]['name']; ?></strong>?"</h5></p>
			<p><i><?php echo $data->dece; ?></i></p><hr></hr>
			
			<p><h5>"Care este varsta ta reala?"</h5></p>
			<p><i><?php echo $data->varsta; ?></i></p><hr></hr>
			
			<p><h5>"Cat timp petreci zilnic pe server?"</h5></p>
			<p><i><?php echo $data->timp; ?></i></p><hr></hr>
			
			<p><h5>"Cu ce crezi ca se ocupa <strong><?php echo Config::$factions[$data->fID]['name']; ?></strong>?"</h5></p>
			<p><i><?php echo $data->ocup; ?></i></p><hr></hr>
			
			<p><h5>"Descrie-te in 20 de cuvinte!"</h5></p>
			<p><i><?php echo $data->descriere; ?></i></p><hr></hr>
			<?php 
			if(Config::getPlayerData($_SESSION['awm_user'],'playerLeader') == $data->fID && $data->Status == 0) 
			{
				echo '<form action="" method="post" >
					<button type="submit" class="btn red pull" id="reject" name="reject">
					<i class="m-icon-swapleft m-icon-white"></i> Reject
					</button>
					<button type="submit" class="btn green pull" id="accept" name="accept">
					Accept <i class="m-icon-swapright m-icon-white"></i>
					</button>
				</form>';
			}
			?>
		</div>
		<div class="col-md-6">
			<b><h5><strong>About this player:</strong></h5></b>
			<hr></hr>
			<li>Current player level: <strong><?php echo Config::getPlayerData($data->pID,'playerLevel');?></strong></li>
			<li>Played time (h/m/s): <strong><?php echo gmdate("H:i:s", Config::getPlayerData($data->pID,'playerSeconds'));?></strong></li>
			<hr>
			<b><h5><strong>Faction History:</strong></h5></b>
			<?php $fa = Config::$g_con->prepare('SELECT * FROM `log_faction` WHERE `fac_player_id` = ? ORDER BY `fac_time` DESC LIMIT 10');
			$fa->execute(array($data->pID)); ?>
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<?php 
						if(!$fa->rowCount()) {
							echo "<p>This player doesn't have faction history!</p>";
						} else {
						while($row = $fa->fetch(PDO::FETCH_OBJ)) {
						$date = new DateTime();
						$date->setTimestamp($row->fac_time);?>
						<tr>
							<td style="font-size: 13px;">
								<div id="cat2"><img src="<?php echo Config::$_PAGE_URL; ?>assets/img/100skin/<?php echo Config::getPlayerData($data->pID,'playerSkin'); ?>.png" width="35" height="27"></div>
							</td>
							<td style="font-size: 13px;">
								<b><?php echo $row->fac_player_name;?></b> <?php echo $row->fac_text;?>
								<br>
								<span class="badge badge-info"><?php echo $date->format('d-m-Y H:i:s'); ?></span>
							</td>
						</tr>
						<?php } }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>