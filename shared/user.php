<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = userData($id);

    while ($row = $data->fetch_assoc()) {
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $phone = $row['phone'];
        $username = $row['username'];
        $password = $row['password'];
        $role = $row['role'];
    }
    $action = "update user";
}else{
    $firstname = null;
    $lastname = null;
    $email = null;
    $phone = null;
    $username = null;
    $password = null;
    $role = $_GET['action'];
    $action = "insert user";
}



?>
<main class="d-flex w-100">
    <section class="page-container w-100">

        <header class="page-title flex-start">
            <!-- <h2>{{header}}</h2> -->
        </header>

        <section class="flex-center flex-wrap w-100">

            <div class="user-information-container rounded text-center">

                <div class="user-information-heading">
                    <h5>User Information</h5>
                </div>

                <div class="user-information-content flex-center">
                    <aside class="user-information-profile">

                        <img src="../assets/images/user.jpg" alt="" class="user-profile" width="150px">
                        <?php
                        if ($role === 'student') {
                            ?>
                            <small><a href="#">View Courses</a></small>
                            <?php
                        } else {
                            if ($role === 'faculty') {
                            ?>
                            
                                <small class="mt-3"><a href="#">View Courses</a></small>
                                <small><a href="#">View Certifications</a></small>
                            <?php
                            }
                            ?>
                            <div class="d-flex">
                            <p>Role:</p>
                            <select name="role" id="role" class="mx-2 h-75%">
                                <option value="dean">Super Admin</option>
                                <option value="dean">Dean</option>
                                <option value="dean">Vice-dean</option>
                                <option value="dean">Department Chair</option>
                                <option value="dean">Faculty</option>
                            </select>
                            </div>
                           
                            <?php
                        }
                        ?>

                    </aside>

                    <aside class="user-information-details">

                        <form action="../shared/forms/event-listener.php" method="post">

                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" value="<?=$firstname?>" name="firstname" class="rounded-pill">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" value="<?=$lastname?>" name="lastname" class="rounded-pill">
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" value="<?=$email?>" name="email" class="rounded-pill">
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" value="<?=$phone?>" name="phone" class="rounded-pill">
                            </div>
                            <div class="w-100"></div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="<?=$username?>" name="username" class="rounded-pill" readonly>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" value="<?=$password?>" name="password" class="rounded-pill">
                            </div>
                            <input type="hidden" name="submit" value="<?=$action?>">
                            <input type="hidden" name="role" value="<?=$role?>">
                            <?php
                            if(isset($id)){
                                echo '<input type="hidden" name="userID" value="'.$id.'">';
                            }
                            ?>
                            <div class="d-flex w-100 justify-content-end">

                                <button type="submit" class="rounded w-25 mx-2">Save</button>
                                <!-- <button class="rounded w-25 mx-2">Cancel</button> -->
                            </div>
                        </form>

                        <?php
                       
                        ?>
                    </aside>
                </div>

            </div>
        </section>
    </section>
</main>