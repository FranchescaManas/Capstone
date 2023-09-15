<?php
include '../shared-functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // print_r($_POST);
        $action = $_POST['submit'];
        if ($action === 'insert user' || $action === 'update user') {
            userAddUpdate($_POST);
        } else if ($action === 'upload certificate') {
            certificateAddUpdate($_POST);
            // go back 1 page and refresh
            header('Location:' . $_SERVER['HTTP_REFERER']);
            ;
            exit;
        } else if ($action === 'delete certificate') {
            // echo "kjfsld";
            deleteCertificate($_POST);
            // refresh the page
        } else if ($action === 'modify certificate') {

            certificateAddUpdate($_POST);
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }else if($action === 'close form') {
            $conn = connection();
            $sql = "UPDATE `form` SET `start_date`= NULL,`end_date`= NULL, is_open = 0";

            $result = $conn->query($sql);
            if($result){
                header('Location:' . $_SERVER['HTTP_REFERER']);
                ;
                exit;
            }else{
                $conn->error;
            }

        }
    } else {

        if (isset($_POST['certData'])) {
            $certData = json_decode($_POST['certData'], true);
            $certID = $certData['certId'];
            // echo (int)$certID;
            $result = getCertificate($certID);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data['certificate_id'] = $row['certificate_id'];
                $data['name'] = $row['name'];
                $data['title'] = $row['title'];
                $data['issued_date'] = $row['issued_date'];
                $data['issued_by'] = $row['issued_by'];
                $data['image'] = base64_encode($row['image']);
            }
            echo json_encode($data);



        } else {
            $formData = json_decode($_POST['data'], true);
            $actionData = json_decode($_POST['action'], true);

            $action = $actionData['action'];
            $role = $actionData['role'];

            if ($role === 'superadmin') {
                if ($action === 'create form') {
                    createForm($role, $formData);
                } else if ($action === 'delete form') {
                    deleteForm($formData);
                    //refresh the page after deleting

                } else if ($action === 'modify form') {
                    updateForm($formData);
                    // print_r($formData);
                } else if ($action === 'update permission') {
                    updatePermission($formData);
                }else if ($action === 'update schedule') {
                    updateSchedule($formData);
                    echo "success";
                }
                // TODO: put the success prompt in the ajax if query works
                echo "success";
            } else {
                if ($action === 'insert response') {
                    insertResponse($role, $formData);
                    // print_r($formData);
                } else if ($action === 'update schedule') {
                    updateSchedule($formData);
                    echo "success";
                }
            }
        }


    }

}

?>