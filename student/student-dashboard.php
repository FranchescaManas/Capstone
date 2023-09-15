<!-- 

    This is the default page set on the right

    NEXT:NONE
    PREVIOUS: student/index.php
 -->


<main class="d-flex w-100">
    <section class="page-container">

        <header class="page-title d-flex justify-content-start">
            <h2>Home</h2>
        </header>

        <section class="flex-between flex-wrap">
           

            <div class="form-schedule-card">

                <div class="d-flex flex-column form-schedule-row" id="faculty-table">
                    <div class="row">
                        <div class="col-10">
                            Faculty
                        </div>
                        <div class="col-2">
                            Status
                        </div>
                    </div>
                    <?php getFaculty($_SESSION['user_id']); ?>
                </div>
                
            </div>
            

        </section>

    </section>
    <summary class="summary-container d-flex flex-column">
        <h2>Evaluation Form</h2>
            <p>Student Evaluation</p>
            <p>The student-teacher evaluation form is an important tool90 that helps to improve the quality of education by providing students with a voice and enabling educators to make improvements based on feedback from their students.</p>
            <form action="../shared/forms/form.php" method="post" class="start-form w-100">
                <input type="text" hidden id="targetID" name="target_id" value="">
                <button type="submit" class='disabled' id="evaluate-btn" name="">Start Evaluate</button>
            </form>
    </summary>
</main>
