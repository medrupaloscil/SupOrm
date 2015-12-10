<?php
require_once('src/core/create.php');
require_once('src/core/entity.php');
require_once('src/model/users.php');

$database = new Create();
$database->createDatabase();

$user = new Users();
//var_dump($user->findAll());