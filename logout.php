<?php
require_once 'core/init.php';
/*
 * implement checking if the user is logged in first
 */
$user = new User();

$user->logout();

Redirect::to('index.php');