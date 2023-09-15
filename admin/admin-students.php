<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone2/shared/shared-functions.php';

?>

 
<script type="text/javascript">
        function filterTable() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtbx_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("studentTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                td = tr[i].getElementsByTagName("td")[1]; // Assuming you want to filter the first column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>



<main class="d-flex w-100">
  <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Students</h2>
        </header>

        <section class="flex-center flex-wrap w-100">
            <input type="text" placeholder="search name" id="txtbx_search"  onkeyup="filterTable()" class="searchbox rounded-pill">
            <!-- <a href="./index.php?page=user&action=student">
                <button class="rounded custom-btn">Add User</button>
            </a> -->
            <button class="rounded custom-btn" data-bs-toggle="modal" data-bs-target="#importstudent">Import</button>
        </section>

        <section class="flex-center">
            <table class="user-table" id="studentTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $studentList = studentData();

                    while($row = $studentList->fetch_assoc()){
                        ?>
                        <tr class="table-row" id="<?= $row['user_id']?>">
                        <td class="text-end">
                            <a href="./index.php?page=user&id=<?= $row['user_id']?>">
                                <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
                            </a>
                        </td>
                        <td><?= $row['firstname'] . ' '. $row['lastname']?></td>
                        <td><?= $row['year_level']?></td>
                        <td><?= $row['section']?></td>
                        <td><?= $row['course']?></td>
                    </tr>
                        <?php
                    }
                    ?>
                    
                    
                </tbody>
            </table>
        </section>
    </section>



<?php
include '../shared/modals.php';
?>