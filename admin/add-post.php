<?php
    include 'partials/header.php';

    // get categories from database
    $query = "SELECT * FROM categories ORDER BY title";
    $results = mysqli_query($connection, $query);

    // get back form data if there was registration error
    $title = $_SESSION['add-post-data']['title'] ?? null;
    $body = $_SESSION['add-post-data']['body'] ?? null;
    
    // delete 'add-post-data' session
    unset($_SESSION['add-post-data']);
?>



    <!-- ======================================== ADD POST ======================================== -->

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Post</h2>
            <?php  // shows if there was any problem
                if(isset($_SESSION['add-post'])) : ?>
                    <div class="alert__message error">
                        <p>
                            <?=
                                $_SESSION['add-post'];
                                unset($_SESSION['add-post']);
                            ?>
                        </p>
                    </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <select name="category">
                    <?php while($result = mysqli_fetch_assoc($results)) : ?>
                        <option value="<?= $result['id'] ?>"><?= $result['title'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="15" name="body" placeholder="Body"><?= $body ?></textarea>
                <div class="form__control">
                    <input type="checkbox" name="is__featured" value="1" id="is__featured">
                    <label for="is__featured">Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Category</button>
            </form>
        </div>
    </section>


    
    <!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>