<?php
if(!defined('AWM'))
	die('Nope.');
if(Config::isLogged()) header('Location: ' . Config::$_PAGE_URL . 'profile');
if(isset($_POST['login_submit'])) {
	if(!$_POST['login_username'] || !$_POST['login_password']) {
		echo '<font color="red"><b>Complete all fields.</b></font>';
	} else {
		$q = Config::$g_con->prepare('SELECT `SQLID` FROM `PlayerInfo` WHERE `PlayerName` = ? AND `Password` = ?');
		$q->execute(array($_POST['login_username'],strtoupper(hash('whirlpool',$_POST['login_password']))));
		if($q->rowCount()) {
			$row = $q->fetch(PDO::FETCH_OBJ);
			$_SESSION['awm_user'] = $row->SQLID;
			echo '<div class="alert alert-success">You have successfully logged in. You will be redirected in <b>1</b> seconds.</div>';
			echo '<meta http-equiv="refresh" content="1;URL=\''.Config::$_PAGE_URL.'profile\'/>';
		}
		else echo '<div class="alert alert-danger">Invalid username or password.</div>';
	}
}
?>

<!--

<form action="" method="post" >
	
</form>
<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

<div class="col-md-4 col-sm-4" align="center"> </div>
<div class="col-md-4 col-sm-4" align="center">
	<form action="" method="post" >
		<h3 class="form-title">Login to your account</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
				 Enter any username and password.
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" id="login_username" name="login_username" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" id="login_password" name="login_password" />
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn green pull" id="login_submit" name="login_submit">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 No worries, click
				<a href="javascript:;" id="forget-password">
					 here
				</a>
				 to reset your password.
			</p>
		</div>
	</form>
</div>
