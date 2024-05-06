<?php
if(!defined('AWM'))
	die('Nope.');
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Methods
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
					Methods
				</a>
			</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>	
<div class="row">
	<div class="col-md-12">
	<font size="4"><b>Payment methods:</b></font><br>
	<ul>
		<li>SMS;</li>
		<li>Paypall;</li>
		<li>Prices are listed in gold: 10 = 1 euro.</li>
	</ul>
	<hr></hr>
	<div class="col-md-4">
		<img src="http://www.starkmedia.com/blog/wp-content/uploads/2015/03/secure-paypal-logo.jpg" height="45px"><br>
		<font size="4"><b>Paypall</b></font><br>
		<ul>
			<li>To pay via PayPal you have an account or a credit card.</li>
			<li>Click the button below and follow the steps.</li>
			<li>Send a screenshot with the payment <a href="<?php echo Config::$_PAGE_URL; ?>buy">HERE</a>.</li>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="5WB8PZPDLCJCJ">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</ul>
	</div>
	<div class="col-md-4">
		<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Orange_logo.svg/2000px-Orange_logo.svg.png" height="45"></img>
		<img src="http://www.foromarketing.com/sites/default/files/fotos/Vodafone_Group.jpg" height="45"></img>
		<img src="http://www.telekom.me/content/images/logo-T-tab2.png" height="45"></img>
		<img src="http://www.tenniswettenonline.net/images/paysafecard.jpg" height="45px">
		<br>
		<font size="4"><b>SMS</b></font><br>
		<ul>
			<li> SOON </li>
		</ul>
	</div><br>
	</div>
</div>