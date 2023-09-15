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
                var td1 = tr[i].getElementsByTagName("td")[1]; // Get the content of the second column (index 1)
                var td2 = tr[i].getElementsByTagName("td")[2]; // Get the content of the third column (index 2)

                if (td1 && td2) {
                    var txtValue1 = td1.textContent || td1.innerText;
                    var txtValue2 = td2.textContent || td2.innerText;

                    // Check if either of the columns contains the filter text
                    if (
                        txtValue1.toUpperCase().indexOf(filter) > -1 ||
                        txtValue2.toUpperCase().indexOf(filter) > -1
                    ) {
                        tr[i].style.display = ""; // Display the row
                    } else {
                        tr[i].style.display = "none"; // Hide the row
                    }
                }

            }
        }
    </script>


<main class="d-flex w-100">
    <section class="page-container w-100">
        <header class="page-title flex-start">
            <h2>Users</h2>
        </header>

        <section class="flex-center flex-wrap w-100">
            <input type="text" placeholder="search" id="txtbx_search" onkeyup="filterTable()" class="searchbox rounded-pill">
<<<<<<< HEAD
            <!-- <button class="rounded custom-btn">Filter</button> -->
=======
            <button class="rounded custom-btn">Filter</button>
>>>>>>> db2bacca1cb8e82f204f3fab1b337e136a461f0c
            <button class="rounded custom-btn">Import</button>
        </section>

        <section class="flex-center">
            <table class="user-table" id="studentTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $user = userData();

                        while($row = $user->fetch_array()){
                            ?>
                            <tr class="table-row" id="<?= $row['user_id']?>">
                            <td class="text-end">
                                <a href="./index.php?page=user&id=<?= $row['user_id']?>">
                                    <img src="../assets/images/user.jpg" alt="" class="user-profile" width="35px">
                                </a>
                            </td>
                            <td><?= $row['firstname']?></td>
                            <td><?= $row['lastname']?></td>
                            <td><?= $row['email']?></td>
                            <td><?= $row['role']?></td>
                        </tr>
                            <?php
                        }       

                        ?>
  
                </tbody>
            </table>
        </section>
    </section>

    
</main>
