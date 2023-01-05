<?php
    include 'partials/header.php';

    // get category data from database
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM categories WHERE id=$id";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
            $result = mysqli_fetch_assoc($result);
        }
    }
    else{
        header('location: ' . ROOT_URL. 'admin/manage-categories.php');
        die();
    }
?>



    <!-- ======================================== EDIT CATEGORY ======================================== -->

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Category</h2>
            <?php  // shows if there was any problem
                if(isset($_SESSION['edit-category'])) : ?>
                    <div class="alert__message error">
                        <p>
                            <?=
                                $_SESSION['edit-category'];
                                unset($_SESSION['edit-category']);
                            ?>
                        </p>
                    </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
                <input type="hidden" name="id" value="<?= $result['id'] ?>">
                <input type="text" name="title" value="<?= $result['title'] ?>" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"><?= $result['description'] ?></textarea>
                <button type="submit" name="submit" class="btn">Update</button>
            </form>
        </div>
    </section>


    
    <!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>