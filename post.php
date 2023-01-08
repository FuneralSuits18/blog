<?php
    include 'partials/header.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT posts.*, users.username, users.avatar FROM `posts` JOIN users ON posts.user_email=users.email WHERE id=$id";
        $result = mysqli_query($connection, $query);
        $post = mysqli_fetch_assoc($result);
    }
    else{
        header('location: ' . ROOT_URL);
        die();
    }
?>



    <!-- ======================================== SINGLE POST ======================================== -->

    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= $post['title'] ?></h2>
            <div class="post__author">
                <div class="post__author-avatar">
                    <img src="./images/<?= $post['avatar'] ?>">
                </div>
                <div class="post__author-info">
                    <h5>By: <?= $post['username'] ?></h5>
                    <small><?= date("j M, y - h:ia", strtotime($post['date_time'])) ?></small>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>">
            </div>
            <p><?= $post['body'] ?></p>

        </div>
    </section>


    
    <!-- ======================================== FOOTER ======================================== -->

<?php
    include 'partials/footer.php';
?>