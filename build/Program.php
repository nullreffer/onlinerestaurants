<?php

require_once "JodlParser.php";
require_once "ModelDefinitionsHelper.php";

use ThirdLabs\Services\JodlParser;
use ThirdLabs\Services\ModelDefinitionsHelper;

$jodlParser = JodlParser::Instance();

$mds1 = $jodlParser->LoadFile("basemodels.jodl");
$mds2 = $jodlParser->LoadFile("appmodels.jodl");

$mds = array_merge($mds1, $mds2);

$pdo = new PDO('mysql:host=127.0.0.1;dbname=iamjayde_food;charset=utf8', 'iamjayde_food', 'f00d!st1');
$mdh = new ModelDefinitionsHelper($mds, $pdo);
$sqls = $mdh->CreateTables($mds);
// echo $sqls;

$mdata = serialize($mds);
file_put_contents("mdata.txt", $mdata);

$mdata = file_get_contents("mdata.txt");
$mds = unserialize($mdata);

var_dump($mds);