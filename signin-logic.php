<?php
    require 'admin/config/database.php';

    if(isset($_POST['submit'])){
        // get form data
        $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$email){
            $_SESSION['signin'] = "Enter email.";
        }
        elseif(!$password){
            $_SESSION['signin'] = "Enter password.";
        }
        else{
            // get user from database
            $get_user_query = "SELECT * FROM users WHERE email = '$email'";
            $get_user_result = mysqli_query($connection , $get_user_query);

            if(mysqli_num_rows($get_user_result) == 1){
                // convert data into an associative array
                $user = mysqli_fetch_assoc($get_user_result);
                $db_password = $user['password'];

                // compare form password and database password
                if(password_verify($password, $db_password)){
                    // set session for access control
                    $_SESSION['user-email'] = $user['email'];

                    // log user in
                    header('location: ' . ROOT_URL . 'admin/dashboard.php');
                }
                else{
                    $_SESSION['signin'] = "Wrong password.";
                }
            }
            else{
                $_SESSION['signin'] = "Email not found.";
            }
        }

        // redirect back to signin page if any problems are found
        if(isset($_SESSION['signin'])){
            $_SESSION['signin-data'] = $_POST;
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }
    else{
        header('location: ' . ROOT_URL . 'signin.php');
    }
?>