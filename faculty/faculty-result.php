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

            while ($row = $admin->fetch_assoc()) {
                $role = $row['role'];
                $fid = $row['form_id'];
                $role = strtolower($role);
                if ($fid === $_GET['fid'])
                    if ($role === 'dean') {
                        echo '<select name="observation-role" id="observation-role" class="my-2">';
                        echo "<option value='$role'>$role</option>";
                        echo '</select>';
                    } else {
                        break;
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
                // echo 'max Score:' . $maxScore . '<br>';
                $scaleScore = 0;
                $scaleReponses = 0;

                // echo $row['scale_text'] . '<br>';
            
                foreach ($scaleResponses as $scaleResponse) {
                    foreach ($scaleResponse as $key => $value) {
                        $scaleScore += $value;
                        $scaleReponses++;
                        // echo "value: $value <br>";
                    }
                }

                $scaleAverage = $scaleScore / $scaleReponses;
                // echo "scale average: $scaleAverage <br>";
                $scalePercent = ($scaleAverage / $maxScore) * 100;
                // echo "scale percent: $scalePercent <br>";
            
                // Store the scale score in the associative array
                $scaleText = $row['scale_text'];
                if (!isset($scaleScores[$scaleText])) {
                    $scaleScores[$scaleText] = 0;
                    $respondents[$scaleText] = 0; // Initialize the respondent count for this scale
                }
                $scaleScores[$scaleText] += $scalePercent;
                $respondents[$scaleText]++; // Increment the respondent count for this scale
                // echo "scale score: " . $scaleScores[$scaleText] . '<br>';
                // $scaleScores[$scaleText] = round($scaleScores[$scaleText], 2);
                // echo "scale score: " . $scaleScores[$scaleText] . '<br>';
                // echo "scale response: $scaleReponses <br>";
                // echo "computed average: $sAverage <br>";
                // $scoreTotal += $scaleScores[$scaleText];
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
                        <?= round($sAverage/20, 2)?>
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




            <!-- <div class="text-container">
                <h6>Strengths</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A at necessitatibus, perferendis aut id dolore, commodi consectetur voluptates sed unde tempore labore, vero hic ipsam nesciunt maxime nobis explicabo. Recusandae earum aliquam inventore. Sed, illo?</p>
            </div>
            <div class="text-container">
                <h6>Recommendation</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A at necessitatibus, perferendis aut id dolore, commodi consectetur voluptates sed unde tempore labore, vero hic ipsam nesciunt maxime nobis explicabo. Recusandae earum aliquam inventore. Sed, illo?</p>
            </div> -->

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