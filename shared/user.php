<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/capstone2/shared/connection.php';

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
        if($role === 'admin'){
            $conn = connection();
            $sql = "SELECT `admin_level` FROM admin WHERE `user_id` = $id";

            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $role = $row['admin_level'];
            }
        }
        
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
                                <input type="password" value="" name="password" class="rounded-pill">
                            </div>
                            <?php
                            if(getRole() === 'superadmin'){
                                if($role !== 'student'){
                                ?>
                            
                                <div class="form-group">
                                <label for="role">Role:</label>
                                <select name="role" id="role" class="mx-2 rounded-pill p-1">
                                    <?php
                                    $roles = [
                                        'superadmin' => 'Super Admin',
                                        'dean' => 'Dean',
                                        'vice dean' => 'Vice-dean',
                                        'department chair' => 'Department Chair',
                                        'faculty' => 'Faculty'
                                    ];

                                    foreach ($roles as $value => $label) {
                                        $selected = ($role === $value) ? 'selected' : '';
                                        echo "<option value=\"$value\" $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                                
                                <?php
                                }
                            }else{
                                ?>
                            
                                <input type="hidden" name="role" value="<?=$role?>">
                                <?php
                            }
                            
                            ?>
                            <input type="hidden" name="submit" value="<?=$action?>">
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