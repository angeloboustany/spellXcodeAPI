<?php

include_once 'dbh.inc.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

// rank users to create a leaderboard based on their points and solved problems

$pointAsc = "SELECT idUsers, uidUsers, fnUsers, lnUsers, uPoints, uSolved FROM users ORDER BY uPoints ASC";
$pointDesc = "SELECT idUsers, uidUsers, fnUsers, lnUsers, uPoints, uSolved FROM users ORDER BY uPoints DESC";
$solvedAsc = "SELECT idUsers, uidUsers, fnUsers, lnUsers, uPoints, uSolved FROM users ORDER BY uSolved ASC";
$solvedDesc = "SELECT idUsers, uidUsers, fnUsers, lnUsers, uPoints, uSolved FROM users ORDER BY uSolved DESC";

if (isset($obj)) {
    $rank = $obj['rank'];
    if ($rank == 'points') {
        $sql = $pointDesc;
    } else if ($rank == 'solved') {
        $sql = $solvedDesc;
    } else if ($rank == 'apoints') {
        $sql = $pointAsc;
    }else if ($rank == 'asolved') {
        $sql = $solvedAsc;
    }else {
        $sql = $pointDesc;
    }

    $result = mysqli_query($conn, $sql);
    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    echo json_encode(array('users' =>$users, 'rank' =>$rank));
} else {
    echo json_encode(array('error' => 'no rank'));
}

