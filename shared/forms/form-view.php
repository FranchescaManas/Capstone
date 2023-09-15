
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/shared-functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/forms/FormClass.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/forms/form-modal.php';

$userID = $_SESSION['user_id'];
$role = $_SESSION['role'];

?>
<main class="d-flex w-100">
    <section class="page-container">

        <header class="page-title">
            <h2>Forms</h2>
        </header>

        <?php
        $form = new Form;
        $formId = $form->getFormID($userID, $role);

        $accessData = array();
        foreach ($formId as $f_id) {
            $access = $form->checkAccess($f_id, $role);
            $accessData[$f_id] = $access;

            if ($access !== 'no access') {
                $form->loadFormsGroup($f_id, $access);
            }

        }

        

        ?>
        <script>
            var formAccessData = <?php echo json_encode($accessData); ?>;
        </script>
    </section>

    </section>


    <aside class="summary-container flex-col-center">


        <?php
        if ($_SESSION['role'] == 'superadmin') {
            echo "
                    <form action='../shared/forms/create-form.php' method='post' style='width: 75%;'>
                        <button class=\"white-btn w-100\" name='action' value='create'>CREATE FORM</button>
                    </form>
                        
                        <button class=\"white-btn\" data-bs-toggle=\"modal\" data-bs-target=\"#scheduleform\">SCHEDULE FORM</button>
                        <button class=\"white-btn\" data-bs-toggle=\"modal\" data-bs-target=\"#assignForm\">ASSIGN FORM</button>
                        ";
        } elseif ($_SESSION['role'] == 'admin') {
            echo "<button class=\"disabled\">CREATE FORM</button>
                        <button class=\"white-btn\" data-bs-toggle=\"modal\" data-bs-target=\"#scheduleform\">SCHEDULE FORM</button>
                        <button class=\"white-btn\" data-bs-toggle=\"modal\" data-bs-target=\"#assignForm\">ASSIGN FORM</button>
                        ";

        } elseif ($_SESSION['role'] == 'faculty') {

        } elseif ($_SESSION['role'] == 'student') {

        } else {
        }
        ?>

        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone/shared/forms/form-modal.php';
        ?>
    </aside>

</main>