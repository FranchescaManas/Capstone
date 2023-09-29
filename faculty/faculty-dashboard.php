<main class="d-flex" style="width: 100%;">
    <div class="page-container">
        <div class="page-title flex-start">
            <h2>Dashboard</h2>
            

        </div>
        <div class="d-flex flex-wrap justify-content-between">
            <?php
            $studentCount = studentCount(getUsername());
            $certificates = certificateData($_SESSION['user_id']);
            $respondent = respodentcount(getUsername());
            
            
          
            ?>

            <div class="score-card">
                <h1><?= $respondent?></h1>
                <p>No. Repondents</p>
            </div>
            <div class="score-card">
                <h1><?= mysqli_num_rows($certificates);?></h1>
                <p>No. of Certificates</p>
            </div>
            <div class="score-card">
                <h1><?= $studentCount?></h1>
                <p>No. of Students</p>
            </div>
            
        </div>
    </div>


    <div class="summary-container d-flex flex-column">
        <h1>SUMMARY</h1>
        <div class="summary-score">

            <h1><?= getScaleOverallUser(getUsername())?></h1>
            <p>OVERALL RATING</p>
        </div>
        <p>
            <b>RATING INTERPRETATION</b>
            <br>
            5 - Excellent <br>
            4 - Superior, Very Good  <br>
            3 - Good  <br>
            2 - Fair <br>
            1 - Poor or Unsatisfactory <br>
        </p>
    </div>
</main>