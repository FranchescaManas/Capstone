<?php

session_start();

$userID = $_SESSION['user_id'];

$role = strtolower($_SESSION['role']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/forms.css">
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(202, 202, 202, 0.55);
            z-index: -1;
        }
    </style>
</head>

<body>

    <?php
    // include '../navbar.php';
    include '../shared-functions.php';
    include './FormClass.php';

    
    $form = new Form;

    // if (isset($_POST['viewForm'])) 
    // {
    //     $formId = $_POST['viewForm'];
    //     formContent($formId, $form);
    // }
 
    // else 
    // {
    //     $formId = $form->getFormID($userID, $role);

    //     if (isset($_POST['target_id'])) 
    //     {
    //         $targetID = $_POST['target_id'];

    //         if (count($formId) === 1) 
    //         {
    //             $access = $form->checkAccess($formId[0], $role);
    //             if(is_array($formId)){
    //                 $formId = $formId[0];
    //             }

    //             if ($access === 'can access') {
    //                 $formName = $form->getFormName($formId);
    //                 formContent($formId, $form, 'evaluate');
    
    //             } else if ($access === 'can modify') {
    //                 if($role === 'dean' || $role === 'vice-dean' || $role === 'chairperson'){
    //                     $role = 'admin';
    //                 }
    //                 header('location: ../../' . $role . '/index.php?page=forms');
    
    //             } else {
    //                 echo "no permission to forms";
    //             }
    //         }
    //         else
    //         {
    //             if(isset($_POST['start_eval'])){

    //                 $formId = $_POST['start_eval'];
    //                 $formName = $form->getFormName($formId);
    //                 formContent($formId, $form, 'evaluate');
    //             }
    //             else{
    //                 if($role === 'dean' || $role === 'vice-dean' || $role === 'chairperson'){
    //                     $role = 'admin';
    //                 }
    //                 header('location: ../../' . $role . '/index.php?page=forms');
    //             }
    //         }
    //     } else {

        
    //         if($role === 'superadmin'){
    //             header('location: ../../' . $role . '/index.php?page=forms');

    //         }else{
                
    //             if(count($formId) > 1){
    //                 if (isset($_POST['evaluateForm'])) 
    //                 {
    //                     $formId = $_POST['evaluateForm'];
    //                     $formName = $form->getFormName($formId);
                        
                        
    //                     header('location: ./targetForm.php?form=' . $formId);
        
    //                 }
    //                 else
    //                 {
    //                     if($role === 'dean' || $role === 'vice-dean' || $role === 'chairperson'){
    //                         $role = 'admin';
    //                     }
    //                     header('location: ../../' . $role . '/index.php?page=forms');
    //                 }

    //             }else{
    //                 if(!isset($_POST['target_id'])){
    //                     if(is_array($formId)){
    //                         $formId = $formId[0];
    //                     }
    //                     header('location: ./targetForm.php?form=' . $formId);

    //                 }                   
    //             }
                
    //         }
            
    //     }
        print_r($_POST);
        if(isset($_POST['viewForm']))
        {
            $formId = $_POST['viewForm'];
            formContent($formId, $form);
        }
        else if(isset($_POST['start_eval']))
        {
            $formId = $_POST['start_eval'];
            $targetID = $_POST['target_id'];
            $formName = $form->getFormName($formId);
            formContent($formId, $form, 'evaluate');
            ?>
            <script>
                var formID = <?php echo json_encode($formId); ?>;
                var userID = <?php echo json_encode($userID); ?>;
                var role = <?php echo json_encode($role); ?>;
                var targetID = <?php echo json_encode($targetID); ?>;
            </script>
            <?php
        }
        
        else //if forms are not for viewing, but for responding/modifying
        {
            //get all the forms available to the user
            $formId = $form->getFormID($userID, $role);
            // if the user has only one form available
            if(count($formId) === 1)
            {

                if(is_array($formId))
                {
                    $formId = $formId[0];
                }
                // check the current access of the user to the form
                $access = $form->checkAccess($formId, $role);
                //if user has access to respond to the form
                if($access === 'can access')
                {
                    //check if there is a target id
                    if(isset($_POST['target_id']))
                    {
                        $targetID = $_POST['target_id'];
                        $formName = $form->getFormName($formId);
                        formContent($formId, $form, 'evaluate');
                    }
                    //if there is no set target id 
                    else
                    {   
                        print_r($_POST);
                        // if target page was set, get the id and load the form
                        if(isset($_POST['start_eval']))
                        {
                            $formId = $_POST['start_eval'];
                            $formName = $form->getFormName($formId);
                            formContent($formId, $form, 'evaluate');
                        }
                        // go to target form if no targer is set
                        else
                        {
                            header('location: ./targetForm.php?form=' . $formId);
                        }
                    }

                }
                else if($access === 'can modify')
                {
                    if($role === 'dean' || $role === 'vice-dean' || $role === 'chairperson'){
                        $role = 'admin';
                    }
                    // echo "redirect to admin page";
                    header('location: ../../' . $role . '/index.php?page=forms');
                }
                else
                {
                    echo "no current permissions to forms. Please contact the administrator.";
                }

            }
            //if there are more than 1 form
            else
            {
                print_r($formId);
                if($role === 'superadmin')
                {
                    header('location: ../../' . $role . '/index.php?page=forms');
                }
                else
                {
                    if($role === 'dean' || $role === 'vice-dean' || $role === 'chairperson'){
                        $role = 'admin';
                    }
                    if(count($formId) > 1){
                        if (isset($_POST['evaluateForm'])) 
                        {
                            $formId = $_POST['evaluateForm'];
                            $formName = $form->getFormName($formId);
                            
                            
                            header('location: ./targetForm.php?form=' . $formId);
            
                        }
                        else
                        {
                            header('location: ../../' . $role . '/index.php?page=forms');
                        }
                    }

                }
                
                
            }
        
        ?>
        <script>
            var formID = <?php echo json_encode($formId); ?>;
            var userID = <?php echo json_encode($userID); ?>;
            var role = <?php echo json_encode($role); ?>;
            var targetID = <?php echo json_encode($targetID); ?>;
        </script>
        <?php
    }
    
    ?>
    



    <!-- bootstrap js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <script src="../js/response-form-jquery.js"></script>
    
</body>

</html>