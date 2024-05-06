<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isAjax()) 
	die('Nope.');
if(!Config::isLogged())
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
$faction = Config::getPlayerData($_SESSION['awm_user'],'playerGroup');
if($faction != $_POST['faction'])
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
if($_SESSION['awm_user'] == $_POST['id'])
	return print_r(json_encode(array('message' => 'You can\'t perform actions on yourself.','color' => 'red')));

$q = Config::$g_con->prepare('SELECT playerGroupRank,playerGroup,playerName FROM playeraccounts WHERE playerID = ?');
$q->execute(array((int)$_POST['id']));
if(!$q->rowCount())
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
$data = $q->fetch(PDO::FETCH_OBJ);

if($faction != $data->playerGroup)
	return print_r(json_encode(array('message' => 'Player <i>'.$data->playerName.'</i> is not in your faction.','color' => 'red')));
if($data->playerGroupRank == 6)
	return print_r(json_encode(array('message' => 'Player <i>'.$data->playerName.'</i> has maximum rank (6).','color' => 'red')));

$qa = Config::$g_con->prepare('UPDATE playeraccounts SET playerGroupRank = playerGroupRank+1 WHERE playerID = ?');
$qa->execute(array((int)$_POST['id']));

$data->playerGroupRank = $data->playerGroupRank + 1;
$rank = ($data->playerGroupRank != 0 ? 'groupRankName' . $data->playerGroupRank : 'groupRankName1');

$q = Config::$g_con->prepare('SELECT '.$rank.' FROM groups WHERE groupID = ?');
$q->execute(array($_POST['faction']));
$ranks = $q->fetch(PDO::FETCH_OBJ);

if($qa)
	return print_r(json_encode(array('message' => 'Player <i>'.$data->playerName.'</i> is now rank '.$ranks->$rank.'.','color'=>'green','rank' => $ranks->$rank)));
else
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));

?>