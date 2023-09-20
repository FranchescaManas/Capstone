<?php

//include .shared-functions.php using document root
include $_SERVER['DOCUMENT_ROOT'] . '/capstone2/shared/shared-functions.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        isset($_POST['targetID']) &&
        isset($_POST['formID']) &&
        isset($_POST['percent']) &&
        isset($_POST['observer'])
    ) {
        $targetID = $_POST['targetID'];
        $formID = $_POST['formID'];
        $percent = $_POST['percent'];
        $observer = $_POST['observer'];

        // echo $targetID;
        // echo $formID;
        // echo $percent;
        // echo $observer;


        echo json_encode(getObserverScore($targetID, $formID, $percent, $observer));
    }
}

?>