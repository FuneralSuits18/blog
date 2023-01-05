<?php
    include 'partials/header.php';

    // get categories from database
    $query = "SELECT * FROM categories ORDER BY title";
    $results = mysqli_query($connection, $query);

    // get post data from database based on id
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $post_query = "SELECT * FROM posts where id=$id";
        $post_result = mysqli_query($connection, $post_query);
        $post = mysqli_fetch_assoc($post_result);
    }
    else{
        header('location: ' . ROOT_URL . 'admin/dashboard.php');
        die();
    }
?>



    <!-- ======================================== EDIT POST ======================================== -->

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Post</h2>
            <?php  // shows if there was any problem
                if(isset($_SESSION['edit-post'])) : ?>
                    <div class="alert__message error">
                        <p>
                            <?=
                                $_SESSION['edit-post'];
                                unset($_SESSION['edit-post']);
                            ?>
                        </p>
                    </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <input type="hidden" name="prev_thumbnail_name" value="<?= $post['thumbnail'] ?>">
                <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title">
                <select name="category">
                    <?php while($result = mysqli_fetch_assoc($results)) : ?>
                        <option value="<?= $result['id'] ?>"><?= $result['title'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="15" name="body" placeholder="Body"><?= $post['body'] ?></textarea>
                <div class="form__control">
                    <input type="checkbox" name="is_featured" id="is__featured" value="1">
                    <label for="is__featured">Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Change Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Update</button>
            </form>
        </div>
    </section>


    
    <!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>