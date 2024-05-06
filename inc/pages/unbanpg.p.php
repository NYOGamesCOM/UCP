<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');
$_SESSION['awm_user'];


$xx = Config::$g_con->prepare('SELECT * FROM unbanreq WHERE ID = ?');
$xx->execute(array((int)Config::$_url[1]));

$ef = $xx->fetch(PDO::FETCH_OBJ);

if(isset($_POST['submit'])) 
{
	if(!$_POST['dovada1']) 
	{
		echo '<div id="page-wrapper" class="alert alert-danger" align="center"><b>Complete field.</b></div>';
	} 
	else 
	{
		$data = date('Y-m-d H:m:s');
		$b = Config::$g_con->prepare("INSERT INTO `comments` (`reqID`,`comment`,`pID`,`Date`) VALUES (?,?,?,?)");
		$b->execute(array((int)Config::$_url[1],htmlspecialchars ( $_POST['dovada1'] ),Config::getPlayerData($_SESSION['awm_user'],'playerID'),$data));
		echo '<div id="page-wrapper" class="alert alert-success" align="center"><b>Your comment has been submitted.</b></div>';
	}
}
if(isset($_POST['submit3'])) 
{
	$z = Config::$g_con->prepare("UPDATE `unbanreq` SET `Status` = 1 , `Closed` = 1 WHERE `ID` = ?");
	$z->execute(array((int)Config::$_url[1]));
	$z = Config::$g_con->prepare("UPDATE `playeraccounts` SET `playerBanned` = 0 WHERE `playerName` = ?");
	$z->execute(array($ef->pName));
	$z = Config::$g_con->prepare("DELETE FROM `bans` WHERE `playerNameBanned` = ?");
	$z->execute(array($ef->pName));
	echo '<div id="page-wrapper" class="alert alert-success" align="center"><b>Your have closed and accept unban request.</b></div>';
}

if(isset($_POST['submit2'])) 
{
	$g = Config::$g_con->prepare("UPDATE `unbanreq` SET `Status` = 0 , `Closed` = 1 WHERE `ID` = ?");
	$g->execute(array((int)Config::$_url[1]));
	echo '<div id="page-wrapper" class="alert alert-success" align="center"><b>Your have closed and reject unban request.</b></div>';
}
?>






				
					
					<form action="" method="post" >
						<div class="col-sm-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">User Account Details</h3>
								</div>
								<div class="panel-body">       
									<ul class="list-group">
										<li class="list-group-item"><b>Name:</b> <?php echo $ef->pName ?></li>
										<li class="list-group-item"><b>Level:</b> <?php echo $ef->pLevel?></li>
										<li class="list-group-item"><b>Played Hours:</b> <?php echo $ef->pHours?></li>
										<li class="list-group-item"><b>Faction:</b> <?php echo Config::$factions[$ef->pFaction]['name']?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Ban Details</h3>
								</div>
								<div class="panel-body">       
									<ul class="list-group">
										<li class="list-group-item"><b>Banned at:</b> <?php echo $ef->BanTime?></li>
										<li class="list-group-item"><b>Admin:</b> <?php echo $ef->AdminName?></li>
										<li class="list-group-item"><b>Reason:</b> <?php echo $ef->Reason?></li>
										<li class="list-group-item"><b>Dovezi:</b> <?php echo $ef->Dovada1?><br><?php echo $ef->Dovada2?><br><?php echo $ef->Dovada3?></li>
										<li class="list-group-item"><b>Precizari:</b> <?php echo $ef->Precizari?></li>
									</ul>
								</div>
							</div>
						</div>
					<br>
					<div class="col-sm-4">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Unban Request Details</h3>
								</div>
								<div class="panel-body">       
									<ul class="list-group">
										<li class="list-group-item"><b>Status:</b> <?php echo ($ef->Closed? '<font color="red">Closed</font>' : '<font color="green">Opened</font>');?></li>
										<li class="list-group-item"><b>Ban Status:</b> <?php echo ($ef->Status? '<font color="green">Unbanned</font>' : '<font color="red">Banned</font>');?></li>
									</ul>
								</div>
							</div>
						</div>
					<div class="col-sm-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">Comments</h3>
								</div>
								<div class="panel-body">
									 <?php 
									 $vww = Config::$g_con->prepare('SELECT * FROM comments WHERE reqID = ? ORDER BY `Date` DESC');
									 $vww->execute(array((int)Config::$_url[1]));
									 $num = $vww->rowCount();
									 while($asd = $vww->fetch(PDO::FETCH_OBJ)) {
									 if($num > 0)
									 {
									 $qq = Config::$g_con->prepare('SELECT playerSkin,playerName,playerID FROM playeraccounts WHERE playerID = ?');
									 $qq->execute(array($asd->pID));
									 $bn = $qq->fetch(PDO::FETCH_OBJ);
									 ?>
									 <div id="cat2"><img src="<?php echo Config::$_PAGE_URL; ?>assets/img/100skin/<?php echo $bn->playerSkin; ?>.png" width="35" height="35"></div>	
									 <div class="col-lg-11">
										<div class="well well-sm">
											<a href=<?php Config::$_PAGE_URL?>profile/<?php echo $ef->playerID; ?>> <b> <?php echo $bn->playerName; ?></b></a><div class="time"><font color="#df8a13"><b><i class="fa fa-clock-o"></i> <?php echo $asd->Date; ?></b></font></div>
											<p><?php echo $asd->comment; ?></p>
										</div>
									 </div>
									 
									 <?php }else{?>
									 <i><li>No comments yet.</i><br>
									 <?php }
									 }?>
									 
									 <?php if($ef->Closed == 0){?>
									 <textarea class="form-control" rows="3" id="dovada1" name="dovada1" placeholder="Leave a reply."></textarea>
									 <br><input type='submit' class="btn btn-sm btn-success" value='Post' id="submit" name="submit" /><br></div>
									 <?php }else{?>
									 <input class="form-control" id="disabledInput" type="text" placeholder="You can't reply here, this request is closed." disabled>
									 <br><fieldset disabled><input type='submit' class="btn btn-sm btn-success" value='Post' id="submit" name="submit" /></fieldset>
									 <?php }?>
								</div>
							</div>
						
						<?php if(Config::isLogged()) {
						$admin = Config::getPlayerData($_SESSION['awm_user'],'playerAdminLevel');
						if($admin != 0) echo '<div class="col-md-12"><center><hr></hr><input type="submit" class="btn btn-success" value="Aprove & Close" id="submit3" name="submit3" /> <input type="submit" class="btn btn-danger" value="Reject & Close" id="submit2" name="submit2" /></center><hr></hr></div>';	
						}	?>
					</form>
					
					




