<?php
    include 'partials/header.php';

    // get category information from database
    $query = "SELECT * FROM categories ORDER BY title";
    $results = mysqli_query($connection, $query);
?>



    <!-- ======================================== MANAGE CATEGORIES ======================================== -->
  
    <section class="dashboard">
        <?php  // shows if add-category was successful
            if(isset($_SESSION['add-category-success'])) : ?>
                <div class="alert__message success container">
                    <p>
                        <?=
                            $_SESSION['add-category-success'];
                            unset($_SESSION['add-category-success']);
                        ?>
                    </p>
                </div>
        <?php // shows if edit-category was successful
            elseif(isset($_SESSION['edit-category-success'])) : ?>
                <div class="alert__message success container">
                     <p>
                        <?=
                            $_SESSION['edit-category-success'];
                            unset($_SESSION['edit-category-success']);
                        ?>
                    </p>
                </div>
        <?php // shows if delete-category was successful
            elseif(isset($_SESSION['delete-category-success'])) : ?>
                <div class="alert__message success container">
                     <p>
                        <?=
                            $_SESSION['delete-category-success'];
                            unset($_SESSION['delete-category-success']);
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
                        <a href="dashboard.php"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-book-medical"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <li>
                        <a href="../edit-user.php"><i class="uil uil-user"></i>
                            <h5>Edit User</h5>
                        </a>
                    </li>
                </ul>
            </aside>
            <main>
                <h2>Manage Categories</h2>
                <?php if(mysqli_num_rows($results) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($result = mysqli_fetch_assoc($results)) : ?>
                                <tr>
                                    <td><?= $result['title'] ?></td>
                                    <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $result['id'] ?>" class="btn btn__small">Edit</a></td>
                                    <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $result['id'] ?>" class="btn btn__small btn__red">Delete</a></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="alert__message error">No category found.</div>
                <?php endif ?>
            </main>
        </div>
    </section>



    <!-- ======================================== FOOTER ======================================== -->

<?php
    include '../partials/footer.php';
?>