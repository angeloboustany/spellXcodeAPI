<?php

include_once 'dbh.inc.php';
include_once 'pfunc.php';


header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

// get hot problems
if (isset($obj['hot'])) {
    $problems = getHotProblems($conn);
    echo json_encode($problems);
}else{
    echo json_encode(array('error' => 'no hot'));
}
