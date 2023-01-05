<?php
    require 'config/database.php';

    // check if submit button is clicked
    if(isset($_POST['submit'])){
        // get form data
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // validate input values
        if(!$title){
            $_SESSION['edit-category'] = "Please enter the title.";
        }
        elseif(!$description){
            $_SESSION['edit-category'] = "Please enter the description.";
        }

        // redirect to edit-category page if problems are found
        if(isset($_SESSION['edit-category'])){
            header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
            die();
        }
        else{
            $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id";
            $result = mysqli_query($connection, $query);

            if(mysqli_errno($connection)){
                $_SESSION['edit-category'] = "Connection error";
                header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
                die();
            }
            else{
                $_SESSION['edit-category-success'] = "Category $title updated successfully!";
                header('location: ' . ROOT_URL . 'admin/manage-categories.php');
                die();
            }
        }

    }
    else{
        header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        die();
    }
?>

