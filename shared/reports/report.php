<?php

session_start();

$userID = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
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

        .form-schedule-card{
            text-align: left;
            background: none;
            width: 85%;
            max-height: none;
        }

        #head{
            background-color: #C9C9C9;
            padding: 12px 0px 12px 0px;
            margin: 7px 0px 0px 0px;
            font-size: 16px;
        }

        #content{
            background-color: rgba(201,201,201, 0.3);
            padding: 7px 0px 7px 0px;
            margin: 0px 0px 2px 0px;   
        }

        #content2{
            
            padding: 7px 0px 7px 0px;
            margin: 0px 0px 2px 0px;   
        }

        #center{
            text-align: center;
        }

        button{
            width: 40%;
        }
<<<<<<< HEAD
=======
        .inputs.enabled{
            width: 50px !important;
            padding: 0 !important;
        }
        .inputs.disabled{
            width: 50px !important;
            padding: 0 !important;
        }
        .icon{
            background-color:transparent !important; 
            width: fit-content !important";
        }
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
    </style>




</head>


<body>
    
<?php
    // include '../connection.php';
    include '../navbar.php';
    // include_once '../connection.php';
    include '../shared-functions.php';
    ?>

    <main class="report" style="overflow: visible;">
    <h3>Faculty Performance Appraisal Summative Report</h3>

    
    <div style="text-align: right; margin: 2% 11% 2% 10%;">
<<<<<<< HEAD
        <a href="default.asp">
            <img src="../../assets/images/print.png" alt="Print" style="width:28px;height:28px;">
        </a>
=======
        <a href="">
            <img src="../../assets/images/print.png" alt="Print" style="width:28px;height:28px;">
        </a>
        <button class="icon" id="edit-report">
            <img src="https://cdn-icons-png.flaticon.com/512/7398/7398464.png" alt="" width="28px" height="28px">
        </button>
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
    </div>
    <div class="report-header" style=" ">
    
        <div class="col" style="text-align: left; ">
        <b>Faculty: </b></br></br>
        <b>Department: </b>

        </div>
        <div class="col" style="text-align: right;">
        <b>Date of Class/Observation: -----</b></br></br>
        <b>Evaluation Period: ----</b>
        </div>
    </div>


    <section class="flex-between flex-wrap">
           

            <div class="form-schedule-card">

                <div class="d-flex flex-column form-schedule-row">
                    <div class="row" style="font-weight: 500; font-size: 18px;">
                        <div class="col-1">
                            ELEMENTS
                        </div>
                        <div class="col-8">
                        </div>
                        <div class="col-2">
                            RATING
                        </div>
                        <div class="col-1">
                            TOTAL
                        </div>
                    </div>
<<<<<<< HEAD
                    <div class="row" id="head">
                        <div class="col-5">
                            Classroom Observation
                        </div>
                        <div class="col-2" id="center">
                            (35%)
=======
                    <?php
                    // $forms = getForms();
                    // foreach($forms as $id => $name){
                        ?>
                        <!-- <div class="row" id="head">
                            <div class="col-5">
                                <?= $name?>
                            </div>
                            <div class="col-2" id="center">
                                (35%)
                            </div>
                            <div class="col-4" id="center">
                            </div>
                            <div class="col-1" id="center">
                                ---
                            </div>
                        </div> -->
                        <?php
                    // }
                    ?>
                    <div class="row" id="head">
                        <div class="col-5">
                            Classroom Observation
                            <button class="icon">
                            <img src="https://cdn.icon-icons.com/icons2/2761/PNG/512/plus_insert_add_rectangle_icon_176436.png" alt=""
                            width="28px" height="28px">
                        </button>
                        </div>
                        <div class="col-2" id="center">
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="35">%
                        
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-4" id="center">
                        </div>
                        <div class="col-1" id="center">
<<<<<<< HEAD
                            ---
=======
                            --
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                    </div>
                    <div class="row" id="content">
                        <div class="col-5">
                            1. VDAA
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (5%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="5">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-2" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>
                    <div class="row" id="content2">
                        <div class="col-5">
                            2. Chair/Coordinator
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (30%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="30">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-2" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>

                    

                    <div class="row" id="head">
                        <div class="col-5">
                            Performance Appraisal
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (40%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="40">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-4" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>
                    <div class="row" id="content">
                        <div class="col-5">
                            1. Dean/VDAA
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (5%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="5">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-2" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>
                    <div class="row" id="content2">
                        <div class="col-5">
                            2. Chair/Coordinator
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (30%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="30">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-2" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>



                    <div class="row" id="head">
                        <div class="col-5">
                            Student Evaluation
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (20%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="20">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-4" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>



                    <div class="row" id="head">
                        <div class="col-5">
                            Self Evaluation
                        </div>
                        <div class="col-2" id="center">
<<<<<<< HEAD
                            (5%)
=======
                        <input type="number" class="inputs enabled" name="numberInput" min="1" max="100" value="5">%

>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                        </div>
                        <div class="col-4" id="center">
                        </div>
                        <div class="col-1" id="center">
                            ---
                        </div>
                    </div>

                    </br></br>
                    <h4 id="center"><p>OVERALL: ---</p> </h4> 


                    <form action="#" method="post" class="w-100" style="  display: flex; justify-content: center;">
<<<<<<< HEAD
                         <button type="submit" name="btn-logout"  class="rounded-pill py-1">Log out</button>
=======
                         <!-- <button type="submit" name="btn-logout"  class="rounded-pill py-1">Log out</button> -->
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
                     </form>
                    </div>


                    

                    

                </div>


                
            </div>
            

        </section>
    </main>


    <!-- bootstrap js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <script src="../js/response-form-jquery.js"></script>
<<<<<<< HEAD
=======
    <script src="../reports/report.js"></script>
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c

</body>

</html>