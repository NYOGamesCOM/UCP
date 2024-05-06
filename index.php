<?php

session_start();

define('AWM',true);

include_once 'inc/Config.class.php';

Config::init()->getContent();

?>