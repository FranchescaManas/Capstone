
<?php
session_start();
require './shared/connection.php';


function login($username, $password){
    $conn = connection();

    $sql = "SELECT * FROM users WHERE  username = '$username'";
    
    if($result = $conn->query($sql)){
        if($result->num_rows == 1){
            $user_row = $result-> fetch_assoc();
            
            if(password_verify($password, $user_row['password'])){
                
                // print_r($user_row);

                // SESSION VARIABLES

                $_SESSION['user_id'] = $user_row['user_id'];
                $_SESSION['username'] = $user_row['username'];
                $_SESSION['full_name'] = $user_row['firstname'] . " " . $user_row['lastname'];
                $_SESSION['role'] = $user_row['role'];

                // page redirection depending on user's role

               if($_SESSION['role'] == 'superadmin'){
                    header('location: ./superadmin');
                    
               }elseif($_SESSION['role'] == 'admin'){
                    $sql = "SELECT `admin_level` FROM `admin` WHERE `user_id` = " . $_SESSION['user_id'];
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $_SESSION['role'] = $row['admin_level'];
                    header('location: ./admin/index.php?page=dashboard');
                    
               }elseif($_SESSION['role'] == 'faculty'){
                    header('location: ./faculty/index.php?page=dashboard');
                    
                }elseif($_SESSION['role'] == 'student'){
                    header('location: ./student/index.php?page=dashboard');
                
                }else{
                    echo "<p class='text-danger'>An error has occured.</p>";
                }
                exit;

            }else{
                echo "<p class='text-danger'>Incorrect password.</p>";
            }
        }else{
            echo "<p class='text-danger'>Username not found.</p>";
        }
    }else{
        die("Error with the query: " . $conn->error);
    }
}



if(isset($_POST['btn_login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    login($username,  $password);
}

    
?>