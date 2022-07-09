<?php

function setProblem($conn, $pName, $pCategory, $pPoint, $pAC, $pSub, $pContest) {
    
    $sql = "INSERT INTO problems (pName, pCategory, pPoint, pAC, pSub, pContest) VALUES ('$pName', '$pCategory', '$pPoint', '$pAC', '$pSub', '$pContest')";
    mysqli_query($conn, $sql);
}

function getProblem($conn, $pid) {
    $sql = "SELECT * FROM problems WHERE pid = $pid";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $pName = $row['pName'];
    $pCategory = $row['pCategory'];
    $pPoint = $row['pPoint'];
    $pAC = $row['pAC'];
    $pSub = $row['pSub'];
    $pContest = $row['pContest'];

    $problem = array('pName' => $pName, 'pCategory' => $pCategory, 'pPoint' => $pPoint, 'pAC' => $pAC, 'pSub' => $pSub, 'pContest' => $pContest);
    return $problem;
}

function getHotProblems($conn) {
    $sql = "SELECT * FROM problems ORDER BY pSub ASC LIMIT 10";
    $result = mysqli_query($conn, $sql);
    $problems = array();
    while ($row = mysqli_fetch_array($result)) {
        $pid = $row['pid'];
        $pName = $row['pName'];
        $pCategory = $row['pCategory'];
        $pPoint = $row['pPoint'];
        $pAC = $row['pAC'];
        $pSub = $row['pSub'];
        $pContest = $row['pContest'];

        $problem = array('pid' => $pid, 'pName' => $pName, 'pCategory' => $pCategory, 'pPoint' => $pPoint, 'pAC' => $pAC, 'pSub' => $pSub, 'pContest' => $pContest);
        array_push($problems, $problem);
    }
    return $problems;
}

function getProblems($conn, $obj) {

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

}
