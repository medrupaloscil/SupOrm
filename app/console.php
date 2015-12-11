<?php

require_once(__DIR__.'/../src/core/create.php');

$create = new Create();
$return = $create->generateTableByName($argv[1]);
echo $return;