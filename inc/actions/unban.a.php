<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isAjax()) 
	die('Nope.');
if(!Config::isLogged())
	return print_r(json_encode(array('message' => 'An error occured #1.','color' => 'red')));
$q = Config::$g_con->prepare('SELECT * FROM bans WHERE banID = ?');
$q->execute(array($_POST['id']));
if(!$q->rowCount())
	return print_r(json_encode(array('message' => 'An error occured #2.','color' => 'red')));
$ban_data = $q->fetch(PDO::FETCH_OBJ);

$q = Config::$g_con->prepare('SELECT * FROM playeraccounts WHERE playerName = ?');
$q->execute(array($ban_data->playerNameBanned));
if(!$q->rowCount())
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));

$q = Config::$g_con->prepare('UPDATE playeraccounts SET playerBanned = 0 WHERE playerName = ?');
$q->execute(array($ban_data->playerNameBanned));

$q = Config::$g_con->prepare('DELETE FROM bans WHERE playerNameBanned = ?');
$q->execute(array($ban_data->playerNameBanned));

return print_r(json_encode(array('message' => 'You unbanned <b>' . $ban_data->playerNameBanned . '</b>','color' => 'green','success' => 1)));

?>