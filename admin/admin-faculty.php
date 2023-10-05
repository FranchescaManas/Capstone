<main class="d-flex w-100">
    <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Faculty Members</h2>
        </header>

        <section class="flex-center flex-wrap w-100">
            <input type="text" placeholder="search" id="txtbx_search" onkeyup="filterTable()" class="searchbox rounded-pill">
            <!-- <button class="rounded custom-btn">Filter</button> -->
            <!-- <a href="./index.php?page=user&action=faculty">
                <button class="rounded custom-btn">Add User</button>
            </a> -->
            <!-- <button class="rounded custom-btn">Import</button> -->
            <button class="rounded custom-btn" data-bs-toggle="modal" data-bs-target="#importfaculty">Import</button>
        </section>

        <section class="flex-center">
            <table class="user-table" id="facultyTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th> 
                        <th>Department</th> 
                        <th>Email</th> 
                        <th>Status</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $facultyList = facultyData();

                    while($row = $facultyList->fetch_assoc()){
                        ?>
                        <tr class="table-row" id="<?= $row['user_id']?>">
                        <td class="text-end">
                            <a href="./index.php?page=user&id=<?= $row['user_id']?>">
                                <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
                            </a>                        </td>
                        <td><?= $row['firstname'] . ' '. $row['lastname']?></td>
                        <td><?= $row['department']?></td>
                        <td><?= $row['email']?></td>
                        <td><?= $row['employment_status']?></td>
                    
                    </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </section>

    
</main>

<script type="text/javascript">
        function filterTable() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("txtbx_search");
            filter = input.value.toUpperCase();
            table = document.getElementById("facultyTable");
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
<?php
include '../shared/modals.php';
?>