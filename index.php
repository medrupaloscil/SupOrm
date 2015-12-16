<?php
require_once('autoloader.php');

$query = new Query();
$query->orderBy('id', 'DESC');
$query->limit(2, 4);
$user = $query->isEntity('Users');
var_dump($user);

$user = new Users();
$user->setPseudo('Luke Skywalker');
$user->setAge('26');
$user->setPassword('LoveMySister');
$user->save();