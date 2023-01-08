<?php
    include 'partials/header.php';

    if(isset($_GET['search']) && isset($_GET['submit'])){
        $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $query = "SELECT posts.*, categories.title AS category_title,users.username, users.avatar FROM `posts` JOIN categories ON posts.category_id=categories.id JOIN users ON posts.user_email=users.email WHERE posts.title LIKE '%$search%' ORDER BY date_time DESC";
        $posts = mysqli_query($connection, $query);

        // get all the categories from the database
        $categories_query = "SELECT * FROM categories";
        $categories_result = mysqli_query($connection, $categories_query);
    }
    else{
        header('location: ' . ROOT_URL . 'blog.php');
        die();
    }
?>

    <!-- ======================================== SEARCH BAR ======================================== -->

    <section class="search__bar">
        <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>


    
    <!-- ======================================== POSTS ======================================== -->
    <?php if(mysqli_num_rows($posts) > 0) : ?>
        <section class="posts">
            <div class="container posts__container">
                <?php while($post = mysqli_fetch_assoc($posts)) : ?>
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
    <?php else : ?>
        <div class="alert__message error featured__container section__extra-margin">
            <p>No posts found for this search.</p>
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