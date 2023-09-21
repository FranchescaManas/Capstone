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

        .form-schedule-card {
            text-align: left;
            background: none;
            width: 85%;
            max-height: none;
        }

        .head {
            background-color: #C9C9C9;
            padding: 12px 0px 12px 0px;
            margin: 7px 0px 0px 0px;
            font-size: 16px;
        }

        .content {
            background-color: rgba(201, 201, 201, 0.3);
            padding: 7px 0px 7px 0px;
            margin: 0px 0px 2px 0px;
        }

        .content2 {

            padding: 7px 0px 7px 0px;
            margin: 0px 0px 2px 0px;
        }

        #center {
            text-align: center;
        }

        button {
            width: 40%;
        }

        .inputs {
            width: 50px !important;
            padding: 0 !important;
            text-align: right !important;
        }

        .enabled {
            /* width: 50px !important; */
            /* padding: 0 !important; */
            /* border:none !important; */
            background-color: none !important;
        }

        .disabled {
            /* width: 50px !important; */
            /* padding: 0 !important; */
            border: none !important;
            background-color: transparent !important;
        }

        .icon {
            background-color: transparent !important;
            width: fit-content !important;
        }

        .minus-row {
            background-color: transparent !important;
            width: fit-content !important;
        }
    </style>




</head>


<body>

    <?php
    include '../navbar.php';
    include '../shared-functions.php';

    $faculty = facultyData();
    $select = [];
    $selectData = userTypes();

    $selectOptions = '<select class="form-control inputs" style="width: fit-content !important">';
    while ($row = $selectData->fetch_assoc()) {
       
        $selectOptions .= '<option>' . $row['user_type'] . '</option>';
    }
    $selectOptions .= '</select>';
    ?>

    <main class="report" style="overflow: visible;">
        <h3>Faculty Performance Appraisal Summative Report</h3>


        <div style="text-align: right; margin: 2% 11% 2% 10%;">
            <a href="#" id="print">
                <img src="../../assets/images/print.png" alt="Print" style="width:28px;height:28px;">
            </a>
            <button class="icon inputs" id="edit-report">
                <img src="https://cdn-icons-png.flaticon.com/512/7398/7398464.png" alt="" width="28px" height="28px">
            </button>
        </div>
        <div class="report-header" style=" ">


            <div class="col" style="text-align: left;">
                <b>Faculty: </b>
                <select name="faculty_report" id="professor" class="rounded">
                    <?php
                    while ($row = $faculty->fetch_assoc()) {
                        echo '<option value="' . $row['faculty_id'] . '" data-department="' . $row['department'] . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
                    }
                    ?>
                </select>
                <br /><br />

            </div>


            <div class="col" style="text-align: right;">
                <div>
                    <b>Department: </b>
                    <p id="department">-- </p>
                </div>

                <!-- <b>Date of Class/Observation: -----</b></br></br>
                <b>Evaluation Period: ----</b> -->
            </div>
        </div>


        <section class="flex-between flex-wrap">

            <form action="javascript:void(0)" method="post" class="w-100 d-flex flex-column align-items-center">

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

                        <?php
                        $forms = getForms();

                        foreach ($forms as $id => $name) {
                            ?>
                            <div class="row head" id="<?= $id ?>">
                                <div class="col-4">
                                    <?= $name ?>
                                </div>
                                <div class="col-1">
                                    <button class="icon">
                                        <img src="https://cdn.icon-icons.com/icons2/2761/PNG/512/plus_insert_add_rectangle_icon_176436.png"
                                            alt="" width="28px" height="28px">
                                    </button>
                                </div>
                                <div class="col-2" id="center">
                                    <?php
                                    $reportData = reportData($id);

                                    if ($reportData->num_rows > 0) {
                                        while ($row = $reportData->fetch_assoc()) {
                                            $percentage = $row['percentage'];
                                            $observers = json_decode($row['observers'], true);

                                            echo '<input type="number" class="inputs enabled" name="numberInput" min="0" max="100" value="' . $percentage . '" >%';

                                            ?>

                                            <script>
                                                $(document).ready(function () {

                                                    var observers = <?php echo json_encode($observers); ?>;
                                                    var select = <?php echo json_encode($selectOptions); ?>;
                                                    var formID = <?php echo json_encode($id); ?>;

                                                    if (observers !== null) {
                                                        for (var i = 0; i < observers.length; i++) {
                                                            observer = observers[i];
                                                            user = observer.observer;
                                                            percentage = observer.percentage;
                                                            var rowhead = $('#<?= $id ?>');
                                                            
                                                            var observerElement = $('<div class="row content"></div>');
                                                            observerElement.append('<div class="col-4" id="center">' + select + '</div>');
                                                            observerElement.append('<div class="col-1" id="center"></div>');
                                                            observerElement.append('<div class="col-2" id="center"><input type="number" class="inputs disabled" name="numberInput" min="0" max="100" value="' + percentage + '">%</div>');
                                                            observerElement.append('<div class="col-3 rating text-end" id=""></div>');
                                                            observerElement.append('<div class="col-2" id="center"></div>');

                                                            rowhead.after(observerElement);

                                                            observerElement.find('select').val(user);

                                                        }
                                                    }
                                                });
                                            </script>

                                            <?php
                                            
                                        }
                                    } else {
                                        // If no rows are found, display the input field with a default value of 0
                                        echo '<input type="number" class="inputs enabled" name="numberInput" min="0" max="100" value="0" >%';
                                    }
                                    ?>
                                </div>

                                <div class="col-4" id="center"></div>
                                <div class="col-1 rowtotal" id="center">
                                    --
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                        </br></br>
                        <h4 id="center" class="totalScore">
                        Overall: 
                        </h4>


                        <button type="submit" name="save-report" id="save-report"
                            class="rounded-pill py-1 align-self-center">Save</button>
                    </div>

                </div>

                </div>

            </form>


        </section>
    </main>


    <!-- bootstrap js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <script src="../js/response-form-jquery.js"></script>
    <script src="../reports/report.js"></script>
    <script>
        var select = <?php echo json_encode($selectOptions); ?>;

    </script>

</body>

</html>