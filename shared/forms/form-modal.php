<!-- 
    This file contains the code/design for the modals in the superadmin-forms page

    PREVIOUS: superadmin-forms.php

 -->

<!-- schedule form -->

<div class="modal fade" id="scheduleform" tabindex="-1" aria-labelledby="scheduleformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title" id="scheduleformLabel">Schedule Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                    <section class="flex-start">
                        <div class="form-group">
                            <label for="start-date">Start Date:</label>
                            <input type="date" name="start-date" id="start-date" class="w-25">
                        </div>
                        <div class="form-group">
                            <label for="end-date">Start Date:</label>
                            <input type="date" name="end-date" id="end-date" class="w-25">
                        </div>
                        <form action="../shared/forms/event-listener.php" method="post">
                            <p>- or -</p>
                            <button type="submit" class="rounded w-25" name="submit" value="close form" >Close Forms</button>
                        </form>
                    </section>

                    <section class="d-flex flex-wrap m-3">
                        <h6>Select Forms:</h6>
                        <div class="w-100"></div>
                        
                        <div class="form-check my-2 me-5">
                            
                            <?php

                                $forms = getForms();
                                
                                foreach ($forms as $formid=> $formName) {
                                    ?>
                                    <input class="form-check-input" type="checkbox" value="<?php echo $formid?>" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        <?php echo $formName?>
                                    </label><br>
                                    <?php
                                }
                            ?>
                        </div>
                        
                        
                    </section>
                   
            </div>
            <div class="modal-footer flex-end">
                <button type="button" class="red-btn small-btn rounded" id="save-schedule">Save</button>
                <button type="button" class="red-btn small-btn rounded" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- form permission -->

<div class="modal fade" id="assignForm" tabindex="-1" aria-labelledby="assignFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title" id="assignFormLabel">Assign Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="">
                    <section class="d-flex flex-row">
                        <div class="form-group">
                            <label for="form-select">Select Form:</label>

                            <select name="form-select" id="form-select">
                            <?php
                                    $forms = getForms();
                                    
                                    foreach ($forms as $formid=> $formName) {
                                        ?>
                                        <option value="<?php echo $formid?>"><?php echo $formName?></option>                        
                                        <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group d-flex flex-row">
                            <input class="form-check-input" type="checkbox" name="can_access" id="canAccess">
                            <label class="form-check-label mx-2" for="canAccess">
                                can access
                            </label>
                        </div>
                        <!-- <div class="form-group d-flex flex-row">
                            <input class="form-check-input" type="checkbox" name="can_view_results" id="canViewResults">
                            <label class="form-check-label mx-2" for="canViewResults">
                                can view results
                            </label>
                        </div> -->
                        <div class="form-group d-flex flex-row">
                            <input class="form-check-input" type="checkbox" name="can_modify" id="canModify">
                            <label class="form-check-label mx-2" for="canModify">
                                can modify
                            </label>
                        </div>

                    </section>

                    <section class="d-flex flex-wrap m-3">
                        <h6>Respondents:</h6>
                        <div class="w-100"></div>
                        
                        <div class="form-check my-2 me-5">
                        <?php
                            $roles = getRoles();

                        foreach ($roles as $role) {
                            ?>
                            <input class="form-check-input" name="respondents[]" type="checkbox" value="<?php echo $role; ?>" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                            <?php echo $role; ?>
                            </label><br>                           
                            <?php
                        }
                            ?>
                        </div>
                       
                    </section>
                   
                </form>
            </div>
            <div class="modal-footer flex-end">
                <button type="button" class="red-btn small-btn rounded" id="save-permission" value="<?php echo $_SESSION['role']; ?>">Save</button>
                <button type="button" class="red-btn small-btn rounded" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- <script src="../shared/js/forms.js"></script> -->