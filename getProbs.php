<?php

include_once 'dbh.inc.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);


$pointAsc = "SELECT * FROM problems ORDER BY pPoint ASC";
$pointDesc = "SELECT * FROM problems ORDER BY pPoint DESC";
$subAsc = "SELECT * FROM problems ORDER BY pSub ASC";
$subDesc = "SELECT * FROM problems ORDER BY pSub DESC";

if (isset($obj)) {
    $rank = $obj['rank'];
    if ($rank == 'points') {
        $sql = $pointDesc;
    } else if ($rank == 'sub') {
        $sql = $subDesc;
    } else if ($rank == 'apoints') {
        $sql = $pointAsc;
    }else if ($rank == 'asub') {
        $sql = $subAsc;
    }else {
        $sql = $pointDesc;
    }

    $result = mysqli_query($conn, $sql);
    $probs = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $probs[] = $row;
    }
    echo json_encode(array('probs' =>$probs, 'rank' =>$rank));
} else {
    echo json_encode(array('error' => 'no rank'));
}
