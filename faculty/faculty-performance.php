<main class="d-flex" style="width: 100%;">
    <div class="page-container">
        <div class="d-flex justify-content-start page-title">
            <h2>Performance Appraisal</h2>
            <select name="observation-role" id="observation-role" class="my-2">
                <option value="Dean">Dean</option>
                <option value="Department Chair">VDAA</option>
            </select>
        </div>
        <div class="d-flex flex-wrap justify-content-evenly">
            <div class="score-card">
                <h1>4</h1>
                <p>Professional Responsibilities</p>
            </div>
            <div class="score-card">
                <h1>4</h1>
                <p>Professional Relationships</p>
            </div>
            <div class="score-card">
                <h1>4</h1>
                <p>Professional Qualities</p>
            </div>
            <br>

            <!-- TODO: FIX THE DESIGN OF THIIS TABLE -->
            <div class="score-table pt-0">
                <div class="row">
                    <div class="col-1">
                        <b>Score</b>
                    </div>
                    <div class="col-11">
                        <b>Professional Responsibilities</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <p>3</p>
                    </div>
                    <div class="col-11">
                        <p>Professional Responsibilities</p>
                    </div>
                </div>
            </div>




        </div>
    </div>


    <div class="summary-container d-flex flex-column">
        <h1>SUMMARY</h1>
        <div class="summary-score">
            <h1>{{Score}}</h1>
            <p>OVERALL RATING</p>
        </div>
      
    </div>
</main>