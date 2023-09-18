<?php

//include .shared-functions.php using document root
include $_SERVER['DOCUMENT_ROOT'] . 'shared/shared-functions.php';


//wait for ajax post
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$userType = userTypes();
echo $json_encode($userType);


// }

?>