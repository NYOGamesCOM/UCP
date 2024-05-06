<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');


$user = $_SESSION['awm_user'];

if(isset($_POST['submit'])) 
{
	if(!$_POST['name'] || !$_POST['met'] || !$_POST['pin'] || !$_POST['pentru'] || !$_POST['suma']) 
	{
		echo '<center><font color="red"><b>Complete all fields.</b></font></center>';
	} 
	else 
	{
		$data = date('Y-m-d H:m:s');
		$b = Config::$g_con->prepare("INSERT INTO `dtickets` (`pID`,`name`,`met`,`pin`,`pentru`,`suma`,`status`,`date`) VALUES (?,?,?,?,?,?,?,?)");
		$b->execute(array($user,$_POST['name'],$_POST['met'],$_POST['pin'],$_POST['pentru'],$_POST['suma'],'3', $data));
		echo '<center><font color="green"><b>Your ticket has been sent.</b></font></center>';
	
	}
}
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Buy
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
					Buy
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-3">
		<font size="2">
		<li>Below you must fill some personal data, they will remain confidential;
		<li>Adding irrelevant data form will result in permanent ban of the user;
		<li>For posting screenshots you may use: <a href="http://imgur.com">imgur.com</a>.
		</font>
		</div>
		<div class="col-md-6">
			<form action="" method="post" >
				<div class="form-body">
					<div class="form-group">
						Firstname and Lastname:<br>
						<textarea class="form-control" rows="1" id="name" name="name" placeholder="Firstname and Lastname"></textarea>
						<br>
						Payment method:<br>
						<textarea class="form-control" rows="1" id="met" name="met" placeholder="Paypall"></textarea>
						<br>
						Amount:<br>
						<textarea class="form-control" rows="1" id="suma" name="Amount" placeholder="RON/Euro"></textarea>
						<br>
						PIN Paysafe/PRINT Paypall/SMS:<br>
						<textarea class="form-control" rows="1" id="pin" name="pin" placeholder="PayPall print (screenshot)."></textarea>
					</div>
				</div>
				<br><div class="rig2"><input type='submit' class="btn btn-lg btn-danger" value='Submit' id="submit" name="submit" /><br></div></div>
			</form>
		<div class="col-md-3">
	
		</div>
		<div class="col-md-12">
			<center>
			<hr></hr>
			<a href="<?php echo Config::$_PAGE_URL; ?>methods"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Orange_logo.svg/2000px-Orange_logo.svg.png" height="30"></img></a>
			<a href="<?php echo Config::$_PAGE_URL; ?>methods"><img src="http://www.foromarketing.com/sites/default/files/fotos/Vodafone_Group.jpg" height="30"></img></a>
			<a href="<?php echo Config::$_PAGE_URL; ?>methods"><img src="http://www.telekom.me/content/images/logo-T-tab2.png" height="30"></img></a>
			<a href="<?php echo Config::$_PAGE_URL; ?>methods"><img src="http://www.starkmedia.com/blog/wp-content/uploads/2015/03/secure-paypal-logo.jpg" height="30"></img></a>
			<a href="<?php echo Config::$_PAGE_URL; ?>methods"><img src="http://www.tenniswettenonline.net/images/paysafecard.jpg" height="30"></a>
			</center>
		</div>
	</div>
</div>