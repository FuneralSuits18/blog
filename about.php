<?php
    include 'partials/header.php';
?>


    <!-- ======================================== ABOUT ======================================== -->

    <section class="about">
        <h1>About Page</h1>
    </section>
    <?php if(isset($_SESSION['user-email'])) : ?>
    <?php else : ?>
        <div class="signin">
            <a href="signin.php">Tolstoy</a>
        </div>
    <?php endif ?>

    <!-- ======================================== FOOTER ======================================== -->

<?php
    include 'partials/footer.php';
?>