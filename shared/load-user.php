<?php

include $_SERVER['DOCUMENT_ROOT'] . '/capstone2/shared/shared-functions.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $role = getRole();

    echo json_encode($role);


}

?>