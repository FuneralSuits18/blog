<?php
    require 'config/database.php';

    // chech if submit button was clicked
    if(isset($_POST['submit'])){
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $prev_thumbnail_name = filter_var($_POST['prev_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
        $thumbnail = $_FILES['thumbnail'];

        // set is__featured to 0 if unchecked
        $is_featured = $is_featured == 1 ? : 0;

        // validate form data
        if(!$title){
            $_SESSION['edit-post'] = "Enter the title.";
        }
        elseif(!$body){
            $_SESSION['edit-post'] = "Enter the body.";
        }
        else{
            // delete previous thumbnail if new thumbnail is uploaded
            if($thumbnail['name']){
                $prev_thumbnail_path = '../images/' . $prev_thumbnail_name;
                if($prev_thumbnail_path){
                    unlink($prev_thumbnail_path);
                }

                // WORK ON NEW THUMBNAIL
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
            if(isset($_SESSION['edit-post'])){
                // pass form back to edit-post page
                $_SESSION['edit-post-data'] = $_POST;
                header('location: '. ROOT_URL . 'admin/edit-post.php');
                die();
            }
            else{
                // set is_featured of all posts to 0 if is_featured is set to 1 on this one
                if($is_featured == 1){
                    $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
                    $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
                }

                // insert post into the posts table
                $thumbnail_to_insert = $thumbnail_name ?? $prev_thumbnail_name;
                $edit_post_query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id";
                $edit_post_result = mysqli_query($connection, $edit_post_query);

                if(mysqli_errno($connection)){
                    // database connection error
                    $_SESSION['edit-post'] = "Failed to edit post.";
                    header('location: ' . ROOT_URL . 'admin/edit-post.php');
                    die();
                }
                else{
                    $_SESSION['edit-post-success'] = "Post edited successfully!";
                    header('location: ' . ROOT_URL . 'admin/dashboard.php');
                    die();
                }
            }
        }
    }
    else{
        // if submit button not clicked, bounce back to the dashboard page
        header('location: ' . ROOT_URL . 'admin/dashboard.php');
        die();
    }
?>