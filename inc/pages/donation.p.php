<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');

$user = $_SESSION['awm_user'];

$q = Config::$g_con->prepare('SELECT * FROM dtickets WHERE id = ?');
$q->execute(array((int)Config::$_url[1]));
$data = $q->fetch(PDO::FETCH_OBJ);

$name1 = "Awesome.";
$name2 = Config::getPlayerData($user,'playerName');

if(isset($_POST['reject']))
{
	echo "<center><font color=red>You have rejected this ticket.</font></center><br>";
	$fa = Config::$g_con->prepare('UPDATE `dtickets` SET `status`=1 WHERE `id`=?');
	$fa->execute(array((int)Config::$_url[1]));
}
if(isset($_POST['accept']))
{
	echo "<center><font color=green>You have accepted this ticket.</font></center><br>";
	$fa = Config::$g_con->prepare('UPDATE `dtickets` SET `status`=2 WHERE `id`=?');
	$fa->execute(array((int)Config::$_url[1]));
}
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Donation ID: <?php echo $data->id;?>
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
					Tickets
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<?php if ( $name1 == $name2 ){?>
		<div class="col-md-4">
			<font size="3"><b>Donator:</b></font><br>
			Cont: <b><a href="<?php echo Config::$_PAGE_URL; ?>profile/<?php echo $data->pID;?>"><?php echo Config::getPlayerData($data->pID,'playerName');?></a></b>
			<br>Nume: <b><?php echo $data->name;?></b>
			<br>Metoda: <b><?php echo $data->met;?></b>
			<br>Suma: <b><?php echo $data->suma;?></b>
			<br>Pentru: <b><?php echo $data->pentru;?></b>
			<br>PIN/Dovada: <b><?php echo $data->pin;?></b>
		</div>
		<div class="col-md-4">
			<font size="3"><b>Stare:</b></font><br>
			<br>Status: <b><?php if($data->status == 1) { ?> <b><font color="darkred">Rejected</font></b> <?php } ?>
					<?php if($data->status == 2) { ?> <b><font color="green">Completed</font></b> <?php } ?>
					<?php if($data->status == 3) { ?> <b><font color="gray">Pending...</font></b> <?php } ?> </b>
			<br>
			<br>
			<form action="" method="post" >
				<button type="submit" class="btn green btn-xs" id="accept" name="accept">Complete</button> 
				<button type="submit" class="btn red btn-xs" id="reject" name="reject">Reject</button>
			</form>
		</div>
	<?php } else { echo '<div class="alert alert-danger">Nu ai permisiunea sa vezi asta.</div>'; }?>
	</div>
</div>