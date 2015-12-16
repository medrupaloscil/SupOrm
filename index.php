<?php
require_once('autoloader.php');

$query = new Query();
$query->orderBy('id', 'DESC');
$query->limit(2, 4);
$user = $query->isEntity('Users');
var_dump($user);