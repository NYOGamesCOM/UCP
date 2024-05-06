<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isAjax()) 
	die('Nope.');
?>

<?
if(!Config::isLogged())
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
	
$q = Config::$g_con->prepare('SELECT playerName,playerAdminLevel FROM playeraccounts WHERE playerID = ?');
$q->execute(array($_SESSION['awm_user']));
if(!$q->rowCount())
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
$data = $q->fetch(PDO::FETCH_OBJ);

if(!$data->playerAdminLevel)
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
	
$q = Config::$g_con->prepare('SELECT * FROM bans WHERE playerNameBanned = ?');
$q->execute(array($_POST['name']));
if($q->rowCount())
	return print_r(json_encode(array('message' => 'Player is already banned.','color' => 'red')));

$q = Config::$g_con->prepare('UPDATE playeraccounts SET playerBanned = 1 WHERE playerName = ?');
$q->execute(array($_POST['name']));

$q = Config::$g_con->prepare('INSERT INTO bans (playerNameBanned,playerBanReason,playerBanDate,IPBanned,playerBannedBy) VALUES (?,?,?,?,?)');
$q->execute(array($_POST['name'],$_POST['reason'],date('Y-m-d H:i:s'),'0.0.0.0',$data->playerName));

return print_r(json_encode(array('message' => 'Player <i>'.$_POST['name'].'</i> is now banned.','color'=>'green')));

?>