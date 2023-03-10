<?php
    include 'partials/header.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // get category name
        $category = "SELECT title FROM categories WHERE id=$id";
        $category_result = mysqli_query($connection, $category);
        $category_name = mysqli_fetch_assoc($category_result);

        // get all the posts from database
        $posts_query = "SELECT posts.*, categories.title AS category_title,users.username, users.avatar FROM `posts` JOIN categories ON posts.category_id=categories.id JOIN users ON posts.user_email=users.email  WHERE category_id=$id ORDER BY posts.date_time DESC";
        $posts_result = mysqli_query($connection, $posts_query);

        // get all the categories from the database
        $categories_query = "SELECT * FROM categories";
        $categories_result = mysqli_query($connection, $categories_query);
    }
    else{
        header('location: ' . ROOT_URL);
        die();
    }
?>



    <!-- ======================================== CATEGORY TITLE ======================================== -->

    <header class="category__title">
        <h2><?= $category_name['title'] ?></h2>
    </header>



    <!-- ======================================== POSTS ======================================== -->
    <?php if(mysqli_num_rows($posts_result) > 0) : ?>
        <section class="posts">
            <div class="container posts__container">
                <?php while($post = mysqli_fetch_assoc($posts_result)) : ?>
                    <article class="post">
                        <div class="post__thumbnail">
                            <img src="./images/<?= $post['thumbnail'] ?>">
                        </div>
                        <div class="post__info">
                            <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                            <p class="post__body">
                                <?= substr($post['body'], 0, 200) ?>...
                            </p>
                            <div class="post__author">
                                <div class="post__author-avatar">
                                    <img src="./images/<?= $post['avatar'] ?>">
                                </div>
                                <div class="post__author-info">
                                    <h5>By: <?= $post['username'] ?></h5>
                                    <small><?= date("j M, y - h:ia", strtotime($post['date_time'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile ?>
            </div>
        </section>
    <?php else : ?>
        <div class="alert__message error featured__container section__extra-margin">
            <p>No posts found in this category.</p>
        </div>
    <?php endif ?>



    <!-- ======================================== CATEGORIES ======================================== -->

    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php while($category = mysqli_fetch_assoc($categories_result)) :?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
            <?php endwhile ?>
        </div>
    </section>



    <!-- ======================================== FOOTER ======================================== -->

<?php
    include 'partials/footer.php';
?>