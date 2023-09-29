<?php
$count = 1;
if (isset($_GET['fid'])) {
    $formID = $_GET['fid'];
    $count++;
    // echo $count;
}
?>

<main class="d-flex" style="width: 100%;">
    <div class="page-container">
        <div class="page-title flex-start">
            <h2>
                <?= getFormName($formID) ?>
            </h2>

            <?php

$admin = formPage(getUsername());
$fid = $_GET['fid']; // Assuming $_GET['fid'] contains the form ID

// Define an array of allowed roles
$allowedRoles = ['dean', 'vice-dean', 'department chair'];

while ($row = $admin->fetch_assoc()) {
    $role = strtolower($row['role']);
    $currentFid = $row['form_id'];

    // Check if the form ID matches the one from the URL
    if ($currentFid === $fid) {
        // Check if the role is one of the allowed roles
        if (in_array($role, $allowedRoles)) {
            // If it's an allowed role, add it as an option to the select
            echo '<select name="observation-role" id="observation-role" class="my-2">';
            echo "<option value='$role'>$role</option>";
            echo '</select>';
            break; // Exit the loop since we found a matching role
        }
    }
}


            ?>



        </div>
        <div class="d-flex flex-wrap justify-content-between">
            <?php
            $scores = perScale(getUsername(), $formID);
            $scaleScores = array(); // Create an associative array to store scale scores
            
            $scoreTotal = 0;

            while ($row = $scores->fetch_assoc()) {
                if ($row['response_value'] !== null) {
                    $scaleResponses = json_decode($row['response_value'], true)['value'];
                } else {
                    return 0;
                }

                $maxScore = $row['number_of_labels'];
                $maxScore = (int) $maxScore;
                $scaleScore = 0;
                $scaleReponses = 0;

                foreach ($scaleResponses as $scaleResponse) {
                    foreach ($scaleResponse as $key => $value) {
                        $scaleScore += $value;
                        $scaleReponses++;
                    }
                }

                $scaleAverage = $scaleScore / $scaleReponses;
                $scalePercent = ($scaleAverage / $maxScore) * 100;

                // Store the scale score in the associative array
                $scaleText = $row['scale_text'];
                if (!isset($scaleScores[$scaleText])) {
                    $scaleScores[$scaleText] = 0;
                    $respondents[$scaleText] = 0; // Initialize the respondent count for this scale
                }
                $scaleScores[$scaleText] += $scalePercent;
                $respondents[$scaleText]++; // Increment the respondent count for this scale
            
            }

            // Loop through the associative array and display total scores and respondent counts for each scale
            $questionCount = 0;
            foreach ($scaleScores as $scaleText => $totalScore) {
                $questionCount++;
                $sAverage = $totalScore / $respondents[$scaleText];
                $scoreTotal += $sAverage;
                ?>
                <div class="score-card">
                    <h1>
                        <?= round($sAverage / 20, 2) ?>
                    </h1>
                    <p>
                        <?= $scaleText ?>
                    </p>
                </div>
                <?php
            }
            $scoreTotal = $scoreTotal / $questionCount;
            $scoreTotal = $scoreTotal / 20;
            ?>



            <?php


            $comments = getComments(getUsername(), $formID);

            // Initialize variables to track the current question and comments
            $currentQuestion = null;
            $currentComments = array();

            while ($row = $comments->fetch_assoc()) {
                $question = $row['question'];
                $response = json_decode($row['response_value'], true)['value'];

                // Check if the question has changed
                if ($question !== $currentQuestion) {
                    // If it has changed, display the previous comments in a single container
                    if ($currentQuestion !== null) {
                        echo '<div class="text-container">';
                        echo '<h6>' . $currentQuestion . '</h6>';

                        foreach ($currentComments as $comment) {
                            echo '<p>' . $comment . '</p>';
                        }

                        echo '</div>';
                    }

                    // Update the current question and reset the comments array
                    $currentQuestion = $question;
                    $currentComments = array();
                }

                // Add the current response to the comments array
                $currentComments[] = $response;
            }

            // Display the last set of comments
            if ($currentQuestion !== null) {
                echo '<div class="text-container">';
                echo '<h6>' . $currentQuestion . '</h6>';

                foreach ($currentComments as $comment) {
                    echo '<p> ~ ' . $comment . '</p>';
                }

                echo '</div>';
            }
            ?>



        </div>
    </div>


    <div class="summary-container d-flex flex-column">
        <h1>SUMMARY</h1>
        <div class="summary-score">
            <h1>
                <?= round($scoreTotal, 2) ?>
            </h1>
            <p>OVERALL RATING</p>
        </div>
        <p>
            <b>RATING INTERPRETATION</b>
            <br>
            5 - Excellent <br>
            4 - Superior, Very Good <br>
            3 - Good <br>
            2 - Fair <br>
            1 - Poor or Unsatisfactory <br>
        </p>
    </div>
</main>