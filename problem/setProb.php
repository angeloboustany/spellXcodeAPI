<?php   

include_once 'dbh.inc.php';
include_once 'pfunc.php';


header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$pName = "WayToLong";
$pCategory = "Strings";
$pPoint = 7;
$pAC = 1;
$pSub = 8;
$pContest = "first";

setProblem($conn, $pName, $pCategory, $pPoint, $pAC, $pSub, $pContest);


