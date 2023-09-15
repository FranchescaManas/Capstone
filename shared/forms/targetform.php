<?
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/connection.php';
$role = $_SESSION['role'];
$link = "../../' . $role . '/index.php?page=forms";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate</title>
    <link rel="stylesheet" href="/capstone/shared/css/components.css">
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="d-flex flex-column justify-content-center align-content-center ">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/navbar.php';
    include $_SERVER['DOCUMENT_ROOT'] .'/capstone/shared/shared-functions.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/forms/FormClass.php';

    $faculty = facultyData();
    $form = new Form;

    $formName = $form->getFormName($_GET['form']);
    ?>
    <!-- LOGIN FORM -->
    <div class="container text-center" id="login-container">

        <div class="d-flex justify-content-center mb-3">

            <h4><?= $formName?></h4>


        </div>

        <form action="./form.php" method="post" class="d-flex flex-column text-start">
                
                <div class="row">

                    <div class="col-6">
                        <label for="evaluatorID">Evaluator Username:</label>
                        <input type="text" name="evaluatorID" id="evaluatorID" class="rounded">
                    </div>
                    <div class="col-6">
                        <label for="professor">Professor:</label>

                        <select name="target_id" id="professor" class="rounded">
                            
                            <?php
                            
                            while($row = $faculty->fetch_assoc()){
                                echo '<option value="'.$row['faculty_id'].'">'. $row['firstname'] .' ' .$row['lastname'] .'</option>';
                            }
                            
                            ?>
                            
                        </select>
                    </div>
                </div>
            
            
                
            <button type="submit" class="rounded-pill fw-bold" name="start_eval" value="<?= $_GET['form']?>">Start Evaluation</button>
        </form>



    </div>



    <!-- bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>

