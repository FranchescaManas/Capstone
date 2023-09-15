<?php
session_start();
include '../shared-functions.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Form</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/forms.css">
    
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(223, 222, 222, 0.73);
            /* Gray color with 0.6 opacity */
            z-index: -1;

        }
        
    </style>
</head>

<body>
    <header>
        <?php include '../navbar.php'; ?>
    </header>

    <main>


        <?php
        $autofill = facultyAutofill();

        // print_r($autofill);

        if (isset($_POST['modify'])) {
            ?>
            <form action="javascript:void(0)" id="form" method="post" data-category="<?php echo $_POST['modify']; ?>">
                <header class="field-group form-title">
                    <label for="form-title">Form Title:</label>
                    <input type="text" name="form-title" id="" value="<?php echo getFormName($_POST['modify']); ?>">
                </header>
                <script>
                    // still in progress
                    var data = <?php loadFormData($_SESSION['role'], $_POST['modify']); ?>;
                    // console.log(data);
                </script>
                <?php
                
                
                echo '<button id="form-submit" class="rounded" style="width: 10%;"value="' . $_SESSION['role'] . '">Submit</button>';

        } else {
            ?>
                <form action="javascript:void(0)" id="form" method="post" data-category="normal">

                    <header class="field-group form-title">
                        <label for="form-title">Form Title:</label>
                        <input type="text" name="form-title" id="">
                    </header>



<<<<<<< HEAD
                    <div style="width: 10%;">
                    <button id="form-submit" class="rounded" value="<?php echo $_SESSION['role']; ?>">Submit</button>
                    </div>
                    
=======
                    <button id="form-submit" class="rounded" value="<?php echo $_SESSION['role']; ?>">Submit</button>
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c


                    <?php
        }


        ?>
       
        <script>
            // still in progress
            var autofilldata = <?php echo json_encode($autofill); ?>;
        </script>
                <aside class="w-100">
                    <div class="form-group-add">

                        <button id="add-btn" type="button">
                            <i class="fa-solid fa-plus fa-lg"></i>
                        </button>
                        <button id="choice-btn" type="button">
                            <i class="fa-regular fa-circle-dot fa-lg"></i>
                        </button>
                        <button id="text-btn" type="button">
                            <i class="fa-solid fa-font fa-lg"></i>
                        </button>
                        <button id="date-btn" type="button">
                            <i class="fa-regular fa-calendar-days"></i>
                        </button>
                        <button id="time-btn" type="button">
                            <i class="fa-regular fa-clock fa-lg"></i>
                        </button>
                        <button id="page-btn" type="button">
                            <i class="fa-regular fa-file fa-lg"></i>
                        </button>
                        <button id="section-btn" type="button">
                            <i class="fa-solid fa-section fa-lg"></i>
                        </button>

                    </div>
                </aside>

            </form>





    </main>

    <!-- bootstrap js cdn -->
    

    <script src="../js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>


        <script>
            var isModifyMode = <?php echo isset($_POST['modify']) ? 'true' : 'false'; ?>;
            var formid = <?php echo isset($_POST['modify']) ? $_POST['modify'] : 'null'; ?>;
        </script>

</body>

</html>