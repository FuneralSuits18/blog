<?php
    require 'config/database.php';

    if(isset($_POST['submit'])){
        // get form data
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var(($_POST['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$title){
            $_SESSION['add-category'] = "Please enter the title.";
        }
        elseif(!$description){
            $_SESSION['add-category'] = "Please enter the description.";
        }

        // redirect back to edit-user page if any probems are found
        if(isset($_SESSION['add-category'])){
            $_SESSION['add-category-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        }
        else{
            // insert category into database
            $add_category_query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
            $add_category_result = (mysqli_query($connection, $add_category_query));

            if(mysqli_errno($connection)){
                // database connection error
                $_SESSION['add-category'] = "Failed to add category.";
                header('location: ' . ROOT_URL . 'admin/add-category.php');
                die();
            }
            else{
                // redirect to manage-categories page
                $_SESSION['add-category-success'] = "Category $title added successfully!";
                header('location: ' . ROOT_URL . 'admin/manage-categories.php');
                die();
            }
        }
    }
    else{
        // if submit button not clicked, bounce back to the add-category page
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    }
?>