<?php
require_once('autoloader.php');

$database = new Create();
$database->createDatabase();

$query = new Query();
$query->orderBy('id', 'DESC');
$user = $query->findOne('Users');
$user->setAge(19);
$user->save();
var_dump($user);