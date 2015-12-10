<?php
require_once('src/core/create.php');
require_once('src/core/entity.php');
require_once('src/model/users.php');

$database = new Create();
$database->createDatabase();

$user = new Users();
$user->select(['pseudo', 'id']);
$user->where(['id = 2', 'age = 19']);
$user->orderBy('id', 'DESC');
var_dump($user->find());