<?php
    include 'partials/header.php';

     // get back form data if there was registration error
     $title = $_SESSION['add-category-data']['title'] ?? null;
     $description = $_SESSION['add-category-data']['description'] ?? null;
     
     // delete 'add-category-data' session
     unset($_SESSION['add-category-data']);
?>



    <!-- ======================================== ADD CATEGORY ======================================== -->

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>
            <?php  // shows if there was any problem
                if(isset($_SESSION['add-category'])) : ?>
                    <div class="alert__message error">
                        <p>
                            <?=
                                $_SESSION['add-category'];
                                unset($_SESSION['add-category']);
                            ?>
                        </p>
                    </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"><?= $description ?></textarea>
                <button type="submit" name="submit" class="btn">Add Category</button>
            </form>
        </div>
    </section>


    
    <!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>