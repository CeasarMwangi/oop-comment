<?php
session_start();

//global variable an array of arrays

//USE SERVER ADDRESS (127.0.0.1) TO AVOID SLOWING PROCESSING DOWN
//DOING DNS TABLE LOOK UP
$GLOBALS['config'] = array(
	'mysql' => array(
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'db' => 'oopblog'
		),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
		)

	);

//spl_autoloading(standard php library) class as the need arise/ when required
//like when you do $db = new DB(); the DB class in loaded automatically 
//you do not need to maintain a list of required classes
spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';
});
require_once 'sanitize.php';