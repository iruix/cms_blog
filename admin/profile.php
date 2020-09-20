<?php include "includes/admin_header.php"; ?>
<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_user_profile)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
    }

}

if(isset($_POST['update_user'])){
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    // $post_date = date('d-m-y');
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    if (!empty($user_password)) {
        $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);

        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password'];
        if ($db_user_password != $user_password) {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        }
        $query = "UPDATE users SET username = '{$username}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', user_password = '{$user_password}', user_role = '{$user_role}' WHERE username = '{$username}'";
        $update_user_query = mysqli_query($connection, $query);
        confirmQuery($update_user_query);
        header("Location: users.php");
    }

}

?>
<div id="wrapper">
    <?php include "includes/admin_navigation.php"; ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Admin Page
                        <small>Author</small>
                    </h1>
                    <form action="" method="post" enctype='multipart/form-data'>
                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input type="text" class="form-control" name="user_firstname" value=<?php echo $user_firstname;?>>
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input type="text" class="form-control" name="user_lastname" value=<?php echo $user_lastname;?>>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value=<?php echo $username;?>>
                        </div>

                        <!-- <div class="form-group">
                            <label for="post_image">Post Image</label>
                            <input type="file" class="form-control" name="post_image">
                        </div> -->
                        <div class="form-group">
                            <label for="user_email">E-mail</label>
                            <input type="email" class="form-control" name="user_email" value=<?php echo $user_email;?>>
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password<small>(If this field is empty, password will not be changed)</small></label>
                            <input type="password" class="form-control" name="user_password" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="update_user" value="Update Profile">
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include "includes/admin_footer.php"; ?>

