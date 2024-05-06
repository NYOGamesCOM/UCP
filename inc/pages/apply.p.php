<?php
if(!Config::isLogged() && !isset(Config::$_url[1])) header('Location: ' . $_PAGE_URL . 'login');

$user = $_SESSION['awm_user'];

if(isset($_POST['submit'])) 
{
	if(!$_POST['dece'] || !$_POST['varsta'] || !$_POST['timp'] || !$_POST['ocup'] || !$_POST['desc']) 
	{
		echo '<center><font color="red"><b>Complete all fields.</b></font></center>';
	} 
	else 
	{
		$data = date('Y-m-d H:m:s');
		$b = Config::$g_con->prepare("INSERT INTO `applications` (`pID`,`fID`,`dece`,`varsta`,`timp`,`ocup`,`descriere`,`Status`,`Closed`,`Date`) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$b->execute(array($user,Config::$_url[1],$_POST['dece'],$_POST['varsta'],$_POST['timp'],$_POST['ocup'],$_POST['desc'],'0','0', $data));
		echo '<center><font color="green"><b>Your application has been sent.</b></font></center>';
	
	}
}
?>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<?php include_once("inc/theme.inc.php");?>
		<h3 class="page-title">
		Apply
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
	<div class="col-md-12">

	<form action="" method="post" >
		<div class="form-body">
			<div class="form-group">
				<div class="col-md-3">Why do you want to join our server?</div>
				<div class="col-md-9"><textarea class="form-control" rows="3" id="dece" name="dece" placeholder="Why do you want to join our server?</textarea></div>
			</div>
			<div id="pae" class="form-group">
				<div class="col-md-3">What's your real age?</div>
				<div class="col-md-9"><textarea class="form-control" rows="3" id="varsta" name="varsta" placeholder="Care este varsta ta reala?"></textarea></div>
			</div>
			<div id="pae" class="form-group">
				<div class="col-md-3">How often will you play?</div>
				<div class="col-md-9"><textarea class="form-control" rows="3" id="timp" name="timp" placeholder="How often will you play?"></textarea></div>
			</div>	
			<div id="pae" class="form-group">
				<div class="col-md-3">Why should we accept your application?</div>
				<div class="col-md-9"><textarea class="form-control" rows="3" id="ocup" name="ocup" placeholder="Why should we accept your application?"></textarea></div>
			</div>
			<div id="pae" class="form-group">
				<div class="col-md-3">Tell us something about you!</div>
				<div class="col-md-9"><textarea class="form-control" rows="3" id="desc" name="desc" placeholder="Describe yourself (20 characters)"></textarea></div>
			</div>
		</div>
		<br><div class="rig2"><input type='submit' class="btn btn-lg btn-danger" value='Apply' id="submit" name="submit" /><br></div></div>
	<?php }
	}?>
		</form>
	</div>
</div>