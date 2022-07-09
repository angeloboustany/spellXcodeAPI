<?php

include_once 'dbh.inc.php';
include_once 'pfunc.php';


header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

if (isset($obj['pid'])) {
    $pid = $obj['pid'];
    $problem = getProblem($conn, $pid);
    echo json_encode($problem);
}else{
    echo json_encode(array('error' => 'no pid'));
}