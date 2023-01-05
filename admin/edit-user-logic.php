<?php
    require 'config/database.php';

    // check if submit button is clicked
    if(isset($_POST['submit'])){
        $email = $_SESSION['user-email'];
        // get form data
        $prev_avatar_name = filter_var($_POST['prev_avatar_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $updatepassword = filter_var($_POST['updatepassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];

        // validate input values
        if(!$firstname){
            $_SESSION['edit-user'] = "Please enter your first name.";
        }
        elseif(!$lastname){
            $_SESSION['edit-user'] = "Please enter your last name.";
        }
        elseif(!$username){
            $_SESSION['edit-user'] = "Please enter your username.";
        }
        elseif(strlen($updatepassword) < 8 || strlen($confirmpassword) < 8){
            $_SESSION['edit-user'] = "Password should be more than 8 characters!";
        }
        else{
            // check if passwords match
            if($updatepassword!==$confirmpassword){
                $_SESSION['edit-user'] = "Passwords do not match.";
            }
            else{
                // hash password
                $hashed_password = password_hash($updatepassword, PASSWORD_DEFAULT);
                
                // WORK ON AVATAR

                // delete previous thumbnail if new thumbnail is uploaded
                if($avatar['name']){
                    $prev_avatar_path = '../images/' . $prev_avatar_name;
                    if($prev_avatar_path){
                        unlink($prev_avatar_path);
                    }
                
                    // rename avatar
                    $time = time();
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination_path = '../images/' . $avatar_name;

                    // check if file is an image
                    $allowed_files = ['png', 'jpg', 'jpeg'];
                    $extension = explode('.', $avatar_name);
                    $extension = end($extension);
                    if(in_array($extension, $allowed_files)){
                        // check if image is too large
                        if($avatar['size'] < 4_000_000){
                            //upload avatar
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        }
                        else{
                            $_SESSION['edit-user'] = "Image size must be less than 2MB.";
                        }
                    }
                    else{
                        $_SESSION['edit-user'] = "File should be PNG, JPG or JPEG.";
                    }
                }
            }
        }

        // redirect back to edit-user page if any probems are found
        if(isset($_SESSION['edit-user'])){
            // pass form back to edit-user page
            $_SESSION['edit-user_data'] = $_POST;
            header('location:' . ROOT_URL . 'admin/edit-user.php');
            die();
        }
        else{
            // insert updated data into the users table
            $update_user_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = '$hashed_password', avatar = '$avatar_name' WHERE email = '$email';";
            $update_user_result = mysqli_query($connection, $update_user_query);

            if(mysqli_errno($connection)){
                // database connection error
                $_SESSION['edit-user'] = "Failed to update user.";
                header('location:' . ROOT_URL . 'admin/edit-user.php');
                die();
            }
            else{
                // redirect to dashboard
                $_SESSION['update-success'] = "$firstname's profile updated successfully!";
                header('location:' . ROOT_URL . 'admin/dashboard.php');
                die();
            }
        }
    }
    else{
        // if submit button not clicked, bounce back to the edit-user page
        header('location: ' . ROOT_URL . 'admin/edit-user.php');
        die();
    }
?>