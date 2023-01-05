<?php
    require 'config/database.php';

    if(isset($_POST['submit'])){
        $user_email = $_SESSION['user-email'];
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_featured = filter_var($_POST['is__featured'], FILTER_SANITIZE_NUMBER_INT);
        $thumbnail = $_FILES['thumbnail'];

        // set is__featured to 0 if unchecked
        $is_featured = $is_featured == 1 ? : 0;

        // validate form data
        if(!$title){
            $_SESSION['add-post'] = "Enter the title.";
        }
        elseif(!$body){
            $_SESSION['add-post'] = "Enter the body.";
        }
        elseif(!$thumbnail['name']){
            $_SESSION['add-post'] = "Add a thumbnail.";
        }
        else{
            // WORK ON THUMBNAIL
            // rename image
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // check if file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extention = explode('.', $thumbnail_name);
            $extention = end($extention);
            if(in_array($extention, $allowed_files)){
                // check if image is too large
                if($thumbnail['size'] < 10_000_000){
                    // upload thumbnail
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                }
                else{
                    $_SESSION['add-post'] = "Image size must be less than 10MB.";
                }
            }
            else{
                $_SESSION['add-post'] = "File should be PNG, JPG or JPEG.";
            }
            
        }

        // redirect back to add-post page if any problems are found
        if(isset($_SESSION['add-post'])){
            // pass form back to add-post page
            $_SESSION['add-post-data'] = $_POST;
            header('location: '. ROOT_URL . 'admin/add-post.php');
            die();
        }
        else{
            // set is_featured of all posts to 0 if is_featured is set to 1 on this one
            if($is_featured == 1){
                $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
                $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
            }

            // insert post into the posts table
            $add_post_query = "INSERT INTO posts (title, body, thumbnail, category_id, user_email, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id, '$user_email', $is_featured)";
            $add_post_result = mysqli_query($connection, $add_post_query);

            if(mysqli_errno($connection)){
                // database connection error
                $_SESSION['add-post'] = "Failed to add post.";
                header('location: ' . ROOT_URL . 'admin/add-post.php');
                die();
            }
            else{
                $_SESSION['add-post-success'] = "New post added successfully!";
                header('location: ' . ROOT_URL . 'admin/dashboard.php');
                die();
            }
        }
    }
    else{
        // if submit button not clicked, bounce back to the add-post page
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }
?>