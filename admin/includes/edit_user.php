<?php

if(isset($_GET['edit_user'])){
    $the_user_id = $_GET['edit_user'];
}
$query = "SELECT * FROM users WHERE user_id = $the_user_id";//You can limit it by adding LIMIT 3 to the end
$select_users_by_id = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_users_by_id)){
    $post_user_firstname = $row['user_firstname'];
    $post_user_lastname = $row['user_lastname'];
    $post_username = $row['username'];
    $post_user_password = $row['user_password'];
    $post_user_email = $row['user_email'];
    $post_user_role = $row['user_role'];
}



if(isset($_POST['edit_user'])){
    $user_firstname = mysqli_real_escape_string($connection,$_POST['user_firstname']);
    // $post_date = date('d-m-y');
    $user_lastname = mysqli_real_escape_string($connection,$_POST['user_lastname']);
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $user_email = mysqli_real_escape_string($connection,$_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection,$_POST['user_password']);
    $user_role = mysqli_real_escape_string($connection,$_POST['user_role']);


    $query = "UPDATE users SET username = '{$username}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', ";
    $query .= "user_email = '{$user_email}', user_password = '{$user_password}', user_role = '{$user_role}' WHERE user_id = {$the_user_id}";
    $update_user_query = mysqli_query($connection, $query);
    confirmQuery($update_user_query);
    header("Location: users.php");
}


?>


<form action="" method="post" enctype='multipart/form-data'>
<div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname" value=<?php echo $post_user_firstname;?>>
</div>
<div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname" value=<?php echo $post_user_lastname;?>>
</div>
<div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" value=<?php echo $post_username;?>>
</div>
<div class="form-group">
        <label for="user_role">User Role</label><br>
        <select name="user_role"  id="post_role">
            <option value=<?php echo $post_user_role;?>><?php echo $post_user_role;?></option>
            <?php
            if($post_user_role == 'admin'){
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

<!-- <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="post_image">
</div> -->
<div class="form-group">
    <label for="user_email">E-mail</label>
    <input type="email" class="form-control" name="user_email" value=<?php echo $post_user_email;?>>
</div>
<div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password" value=<?php echo $post_user_password;?>>
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
</div>







</form>
