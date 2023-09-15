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
                        } else if ($role === 'faculty') {
                            ?>
                                <small class="mt-3"><a href="#">View Courses</a></small>
                                <small><a href="#">View Certifications</a></small>
                            <?php
                        }
                        ?>

                    </aside>

                    <aside class="user-information-details">

                        <form action="">

                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" placeholder="<?=$firstname?>" class="rounded-pill">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" placeholder="<?=$lastname?>" class="rounded-pill">
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" placeholder="<?=$email?>" class="rounded-pill">
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" placeholder="<?=$phone?>" class="rounded-pill">
                            </div>
                            <div class="w-100"></div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" placeholder="<?=$username?>" class="rounded-pill">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" value="<?=$password?>" class="rounded-pill">
                            </div>


                        </form>
                    </aside>
                </div>

            </div>
        </section>
    </section>
</main>