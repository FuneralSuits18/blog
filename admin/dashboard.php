<?php
    include 'partials/header.php';

    // get posts from database
    $query = "SELECT posts.title as title, posts.id, categories.title AS category_title FROM POSTS JOIN categories ON posts.category_id=categories.id ORDER BY posts.date_time DESC";
    $results = mysqli_query($connection, $query);

?>



    <!-- ======================================== DASHBOARD (MANAGE POSTS) ======================================== -->
  
    <section class="dashboard">
        <?php  // shows if edit-user update was successful
            if(isset($_SESSION['update-success'])) : ?>
                <div class="alert__message success container">
                    <p>
                        <?=
                            $_SESSION['update-success'];
                            unset($_SESSION['update-success']);
                        ?>
                    </p>
                </div>
        <?php  // shows if add-post was successful
            elseif(isset($_SESSION['add-post-success'])) : ?>
                <div class="alert__message success container">
                    <p>
                        <?=
                            $_SESSION['add-post-success'];
                            unset($_SESSION['add-post-success']);
                        ?>
                    </p>
                </div>
        <?php  // shows if edit-post was successful
            elseif(isset($_SESSION['edit-post-success'])) : ?>
                <div class="alert__message success container">
                    <p>
                        <?=
                            $_SESSION['edit-post-success'];
                            unset($_SESSION['edit-post-success']);
                        ?>
                    </p>
                </div>
        <?php endif ?>
        <div class="container dashboard__container">
            <aside>
                <ul>
                    <li>
                        <a href="add-post.php"><i class="uil uil-plus"></i>
                            <h5>Add Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php" class="active"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-book-medical"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <li>
                        <a href="edit-user.php"><i class="uil uil-user"></i>
                            <h5>Edit User</h5>
                        </a>
                    </li>
                </ul>
            </aside>
            <main>
                <h2>Manage Posts</h2>
                <?php if(mysqli_num_rows($results) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($result = mysqli_fetch_assoc($results)) : ?>
                                <tr>
                                    <td><?= $result['title'] ?></td>
                                    <td><?= $result['category_title'] ?></td>
                                    <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $result['id'] ?>" class="btn btn__small">Edit</a></td>
                                    <td><a href="<?= ROOT_URL?>admin/delete-post.php?id=<?= $result['id'] ?>" class="btn btn__small btn__red">Delete</a></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="alert__message error">No posts found</div>
                <?php endif ?> 
            </main>
        </div>
    </section>



    <!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>