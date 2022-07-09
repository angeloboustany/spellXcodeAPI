<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

if (isset($obj)) {

    require_once 'dbh.inc.php';
    require_once 'func.php';

    $username = $obj['username'];
    $password = $obj['password'];

    loginUser($conn, $username, $password);

}