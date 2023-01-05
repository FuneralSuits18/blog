<?php
    require 'admin/config/constants.php';

    $email = $_SESSION['signin-data']['email'] ?? null;
    $password = $_SESSION['signin-data']['password'] ?? null;

    unset($_SESSION['singin-data']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONTS (MONTSERRAT) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign In</h2>
            <?php 
                if(isset($_SESSION['update-success'])) : ?>
                    <div class="alert__message success">
                        <p>
                            <?=
                                $_SESSION['update-success'];
                                unset($_SESSION['update-success']);
                            ?>
                        </p>
                    </div>
            <?php elseif(isset($_SESSION['signin'])) : ?>
                <div class="alert__message error">
                            <p>
                                <?=
                                    $_SESSION['signin'];
                                    unset($_SESSION['signin']);
                                ?>
                            </p>
                        </div>
                <?php endif ?>
            <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
                <button type="submit" name="submit" class="btn">Sign In</button>
            </form>
        </div>
    </section>
</body>
</html>