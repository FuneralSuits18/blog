<?php
    include 'partials/header.php';
    
    // get current user data
    if(isset($_SESSION['user-email'])){
        $email = $_SESSION['user-email'];
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);
        $avatar = $user['avatar'];
    }
    else{
        header('location: ' . ROOT_URL . '../signin.php');
        die();
    }
    


    // get back form data if there was registration error
    $firstname = $_SESSION['edit-user_data']['firstname'] ?? $user['firstname'];
    $lastname = $_SESSION['edit-user_data']['lastname'] ?? $user['lastname'];
    $username = $_SESSION['edit-user_data']['username'] ?? $user['username'];
    $updatepassword = $_SESSION['edit-user_data']['updatepassword'] ?? null;
    $confirmpassword = $_SESSION['edit-user_data']['confirmpassword'] ?? null;
    
    // delete 'edit-user_data' session
    unset($_SESSION['edit-user_data']);
?>



    <!-- ======================================== EDIT USER ======================================== -->
  
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit User Information</h2>
            <?php
                if(isset($_SESSION['edit-user'])): ?>
                <div class="alert__message error">
                    <p>
                        <?= 
                            $_SESSION['edit-user'];
                            unset($_SESSION['edit-user']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
                <div class="email"><?= $email ?></div>
                <input type="hidden" name="prev_avatar_name" value="<?= $avatar ?>">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="Firstname">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Lastname">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="password" name="updatepassword" value="<?= $updatepassword ?>" placeholder="Update Password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
                <div class="form__control">
                    <label for="avatar">Update Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Update</button>
            </form>
        </div>
    </section>


<!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>