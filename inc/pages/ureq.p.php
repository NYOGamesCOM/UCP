<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');
if(isset(Config::$_url[1])) $user = (int)Config::$_url[1];
else $user = $_SESSION['awm_user'];


if(Config::isLogged()) $banned = Config::getPlayerData($_SESSION['awm_user'],'playerBanned');
else $banned = 0;

$ww = Config::$g_con->prepare('SELECT * FROM playeraccounts WHERE playerID = ?');
$ww->execute(array($user));
$aef = $ww->fetch(PDO::FETCH_OBJ);

$ss = Config::$g_con->prepare('SELECT * FROM `bans` WHERE `playerNameBanned` = ?');
$ss->execute(array($aef->playerName));
$new = $ss->fetch(PDO::FETCH_OBJ);

$ss = Config::$g_con->prepare('SELECT * FROM unbanreq WHERE pName = ? AND Status = 0 AND Closed = 0');
$ss->execute(array($aef->playerName));
$check = $ss->rowCount();

if(isset($_POST['login_submit'])) 
{
	if(!$_POST['admin'] || !$_POST['reason'] || !$_POST['dovada1'] || !$_POST['ip'] || !$_POST['precizare']) 
	{
		echo '<center><font color="red"><b>Complete all fields.</b></font></center>';
	} 
	else 
	{
		$data = date('Y-m-d H:m:s');
		$b = Config::$g_con->prepare("INSERT INTO `unbanreq` (`playerID`,`pName`,`pLevel`,`pHours`,`pFaction`,`AdminName`,`Reason`,`Dovada1`,`Dovada2`,`Dovada3`,`pIP`,`Precizari`,`Status`,`Closed`, `Date`, `BanTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$b->execute(array($user,$aef->playerName,$aef->playerLevel,$aef->playerHours,$aef->playerGroup,$_POST['admin'],$_POST['reason'],$_POST['dovada1'],$_POST['dovada2'],$_POST['dovada3'],$_POST['ip'],$_POST['precizare'],'0','0', $data, $new->playerBanDate));
		echo '<center><div class="alert alert-success"><b>Your unban request has been sent.</b></div></center>';
	}
}

?>


				
					<?php
                      if($banned < 1){
						?><div class="alert alert-danger">
                                Your account is not banned!
							</div>
					<?php } else if($check) {
						echo '<div class="alert alert-danger">
                                You\'ve already maked a unban request!
							</div>';
					} else {?>
					<form action="" method="post" >
						<div class="col-sm-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Your Account Details & Ban info</h3>
								</div>
								<div class="panel-body">       
									<ul class="list-group">
										<li class="list-group-item"><b>Name:</b> <?php echo $aef->playerName; ?></li>
										<li class="list-group-item"><b>Level:</b> <?php echo $aef->playerLevel; ?></li>
										<li class="list-group-item"><b>Played Hours:</b> <?php echo $aef->playerHours; ?></li>
										<li class="list-group-item"><b>Faction:</b> <?php echo Config::$factions[$aef->playerGroup]['name']; ?></li>
									</ul>
									<li><font color="red">If you are banned for <b>s0beit</b> don't try to make a request, is in vain.</font>
								</div>
								<div class="panel-body">       
									<ul class="list-group">
										<li class="list-group-item"><b>Banned at:</b> <?php echo $new->playerBanDate; ?></li>
										<li class="list-group-item"><b>Ban reason:</b> <?php echo $new->playerBanReason; ?></li>
										<li class="list-group-item"><b>IP Banned:</b> <?php echo $new->IPBanned; ?></li>
										<li class="list-group-item"><b>Banned by:</b> <?php echo $new->playerBannedBy; ?></li>
									</ul>
								</div>
								
							</div>
						</div>
						<div class="col-sm-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Unban Request</h3>
								</div>
								<div class="panel-body">       
									<ul class="list-group">
										<b>Adminul care te-a banat:</b><br>
										<input class="form-control" id="admin" name="admin">
										<b>Reason:</b><br>
										<input class="form-control" id="reason" name="reason">
										<b>Dovezi(screen/video):</b><br>
										<input class="form-control" id="dovada1" name="dovada1">
										<input class="form-control" id="dovada2" name="dovada2">
										<input class="form-control" id="dovada3" name="dovada3">
										<b>IP-ul tau:</b><br>
										<input class="form-control" id="ip" name="ip">
										<b>Alte precizari:</b><br>
										<textarea class="form-control"  id="precizare" name="precizare"></textarea>
									</ul>
								</div>
							</div>
						</div>
						
						<input type='submit' class="btn btn-lg btn-danger" value='Submit' id="login_submit" name="login_submit" /><br></div>
					</form>
					<?php }?>
					
					

                           


