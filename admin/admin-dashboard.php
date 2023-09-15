<?php

$facultyCount = facultyData();
$studentCount = studentData();
$submissions = submissionMetric();
$formCount = formCount();


$facultyCount = $facultyCount->num_rows;
$studentCount = $studentCount->num_rows;


?>
<main class="d-flex w-100">
    <section class="page-container">

        <header class="page-title d-flex justify-content-start">
            <h2>Dashboard</h2>
        </header>

        <section class="flex-between flex-wrap">
            <div class="score-card">
                <h1><?= $facultyCount?></h1>
                <p>No. of Faculty</p>
            </div>
            <div class="score-card">
                <h1><?= $studentCount?></h1>
                <p>No. of Students</p>
            </div>
            <div class="score-card">
                <h1><?= $submissions?></h1>
                <p>Submission Metrics</p>
            </div>
            <div class="score-card">
                <h1><?= $formCount?></h1>
                <p>No. of Forms</p>
            </div>

            <div class="form-schedule-card">

                <h3>Form Schedule</h3>
                <?php
                
                $formschedules = formSchedules();

                while($row = $formschedules->fetch_assoc()){
                    if($row['start_date'] === null || $row['end_date'] === null){
                        $date = "Not Scheduled";
                    }else{
                        //format the date to be readable
                        $start_date = date_create($row['start_date']);
                        $end_date = date_create($row['end_date']);
                        $date = $start_date->format('M d, Y') .' - ' . $end_date->format('M d, Y');
                    }
                ?>
                <!-- TODO: FORMAT THE DATE -->
                <div class="form-schedule-row flex-row-between">
                    <h6><?= $row['form_name']; ?></h6>
                    <small><?= $date; ?></small>
                </div>
                <?php
                }
                ?>
            </div>
            

        </section>

    </section>
    <summary class="summary-container d-flex flex-column">
        <h1>SUMMARY</h1>
        <div class="summary-score">
            <h1><?= $score = getScaleOverall(); ?></h1>
            <p>OVERALL RATING</p>
            
        </div>
    </summary>
</main>