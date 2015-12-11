<?php
require_once('autoloader.php');

$query = new Query();
$query->orderBy('id', 'DESC');
$user = $query->find('Users');
var_dump($user);