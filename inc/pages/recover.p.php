<?php
function randomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
if(isset(Config::$_url[1])) {
	$q = Config::$g_con->prepare("SELECT * FROM `lostpw` WHERE `Session` = ?");
	$q->execute(array(Config::$_url[1]));
	if($q->rowCount()) {
		$row = $q->fetch();
		if($_SERVER['REMOTE_ADDR'] === $row['IP']) {
			if($row['Time'] < time()) {
				echo '<font color="red">Session expired.</font>';
			}
			$password = randomPassword();
			echo 'Noua ta parola: ' . $password;
			$q = Config::$g_con->prepare("UPDATE playeraccounts SET playerPassword = ? WHERE playerName = ?");
			$q->execute(array(strtoupper(hash('whirlpool',$password)),$row['Name']));
			$q = Config::$g_con->prepare("DELETE FROM `lostpw` WHERE `Session` = ?");
			$q->execute(array(Config::$_url[1]));
			return;
		} else {
			echo '<font color="red">Session expired.</font>';
			return;
		}		
	}
}
if(isset($_POST['lp_submit']) && $_POST['lp_name'] && $_POST['lp_email']) {
	$q = Config::$g_con->prepare("SELECT * FROM playeraccounts WHERE playerName = ? AND playerEmail = ? LIMIT 0,1");
	$q->execute(array($_POST['lp_name'],$_POST['lp_email']));
	if(!$q->rowCount()) echo '<font color="red">No account with this user and email combination.</font>';
	else {
		$q = Config::$g_con->prepare("SELECT * FROM `lostpw` WHERE `Name` = ? AND `Email` = ?");
		$q->execute(array($_POST['lp_name'],$_POST['lp_email']));
		if($q->rowCount()) {
			$row = $q->fetch();
			if($row['Time'] > time()) {
				echo '<font color="red">There\'s already a request in the past hour to this account. Check your email.</font>';
			}
		} else {
			$session = md5(uniqid($_POST['lp_name'], true)).md5(rand());
			$q = Config::$g_con->prepare("INSERT INTO `lostpw` (`Email`,`Name`,`Session`,`IP`,`Time`) VALUES (?,?,?,?,?)");
			$q->execute(array($_POST['lp_email'],$_POST['lp_name'],$session,$_SERVER['REMOTE_ADDR'],time()+3600));
			echo '<font color="green">A reset link was sent to your email.</font>';
			$to      = $_POST['lp_email'];
			$subject = 'Password reset';
			$message = "To reset your password click the link below.\n
If you didn't request this password reset email,then ignore it.\n
Link: " . Config::$_PAGE_URL . 'recover/' . $session;
			$headers = 'From:  support@ap-rp.com' . "\r\n" .
				'Reply-To:  support@ap-rp.com' . "\r\n" .

			mail($to, $subject, $message, $headers);
			$_SESSION['session'] = $session;
		}	
	}
}
?>

<form action="" method="post">
	<input style="margin:5px;" type="text" name="lp_name" placeholder="Name"/><BR>
	<input style="margin:5px;" type="text" name="lp_email" placeholder="Email"/><BR>
	<input type="submit" name="lp_submit"/>
</form>

<div class="col-md-4 col-sm-4" align="center"> </div>
<div class="col-md-4 col-sm-4" align="center">
	<form action="" method="post" >
		<h3 class="form-title">Recover your password</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
				 Enter your account <b>name</b> and <b>email</b>.
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Name</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Name" id="lp_name" name="lp_name" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Email</label>
			<div class="input-icon">
				<i class="fa fa-mail-reply-all"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" id="lp_email" name="lp_email" />
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn green pull" id="lp_submit" name="lp_submit">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		
	</form>
</div>