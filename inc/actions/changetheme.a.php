<?php
if(!defined('AWM'))
	die('Nope.');
if(!Config::isAjax()) 
	die('Nope.');
	
$user = $_SESSION['awm_user'];

if(!Config::isLogged())
	return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));
	

	
	$q = Config::$g_con->prepare("UPDATE playeraccounts SET theme = ? WHERE playerID = ?");
	$q->execute(array($_POST['name'],$user));
	if(!$q->rowCount())
		return print_r(json_encode(array('message' => 'An error occured.','color' => 'red')));

		

return print_r(json_encode(array('message' => 'Theme changed.','color'=>'green')));

?>