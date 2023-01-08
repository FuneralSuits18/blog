<?php
    include 'partials/header.php';

    // get the featured post from database
    $featured_query = "SELECT posts.*, categories.title AS category_title,users.username, users.avatar FROM `posts` JOIN categories ON posts.category_id=categories.id JOIN users ON posts.user_email=users.email WHERE is_featured=1";
    $featured_result = mysqli_query($connection, $featured_query);
    $featured = mysqli_fetch_assoc($featured_result);

    // get all the posts from database
    $posts_query = "SELECT posts.*, categories.title AS category_title,users.username, users.avatar FROM `posts` JOIN categories ON posts.category_id=categories.id JOIN users ON posts.user_email=users.email ORDER BY posts.date_time DESC";
    $posts_result = mysqli_query($connection, $posts_query);

    // get all the categories from the database
    $categories_query = "SELECT * FROM categories";
    $categories_result = mysqli_query($connection, $categories_query);

?>


    <?php if(mysqli_num_rows($featured_result) == 1) : ?>
        <!-- ======================================== FEATURED ======================================== -->

        <div class="featured__container__container">
            <section class="featured">
                <div class="container featured__container">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $featured['thumbnail'] ?>">
                    </div>
                    <div class="post__info">
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category__button"><?= $featured['category_title'] ?></a>
                        <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
                        <p class="post__body">
                            <?= substr($featured['body'], 0, 300) ?>...
                        </p>
                        <div class="post__author">
                            <div class="post__author-avatar">
                                <img src="./images/<?= $featured['avatar'] ?>">
                            </div>
                            <div class="post__author-info">
                                <h5>By: <?= $featured['username'] ?></h5>
                                <small><?= date("j M, y - h:ia", strtotime($featured['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    <?php endif ?>



    <!-- ======================================== POSTS ======================================== -->

    <section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($posts_result)) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>">
                    </div>
                    <div class="post__info">
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $post['category_title'] ?></a>
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