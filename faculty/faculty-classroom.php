<main class="d-flex" style="width: 100%;">
    <div class="page-container">
        <div class="page-title flex-start">
            <h2>Classroom Observation</h2>
            <select name="observation-role" id="observation-role" class="my-2">
            <?php
            
            $admin = userTypes();

            while ($row = $admin->fetch_assoc()) {
                $role = $row['role'];
                if($role === 'admin'){
                    $user = $row['user_type'];
                    echo "<option value='$user'>$user</option>";
                }
            }
            
            ?>
        
            </select>

        </div>
        <div class="d-flex flex-wrap justify-content-between">
            <?php
            
            // $scores = perScale($_SESSION['user_id'], $formID, $_SESSION['user_type']);
            
            ?>

            <div class="score-card">
                <h1>4</h1>
                <p>Quality</p>
            </div>
            <div class="score-card">
                <h1>4</h1>
                <p>Quality</p>
            </div>
            <div class="score-card">
                <h1>4</h1>
                <p>Quality</p>
            </div>
            <div class="score-card">
                <h1>4</h1>
                <p>Quality</p>
            </div>
            

            <div class="text-container">
                <h6>Strengths</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A at necessitatibus, perferendis aut id dolore, commodi consectetur voluptates sed unde tempore labore, vero hic ipsam nesciunt maxime nobis explicabo. Recusandae earum aliquam inventore. Sed, illo?</p>
            </div>
            <div class="text-container">
                <h6>Recommendation</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A at necessitatibus, perferendis aut id dolore, commodi consectetur voluptates sed unde tempore labore, vero hic ipsam nesciunt maxime nobis explicabo. Recusandae earum aliquam inventore. Sed, illo?</p>
            </div>
            
        </div>
    </div>


    <div class="summary-container d-flex flex-column">
        <h1>SUMMARY</h1>
        <div class="summary-score">
            <h1>{{Score}}</h1>
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