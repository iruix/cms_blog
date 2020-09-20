<?php
if(isset($_POST['create_user'])){
    $user_firstname = mysqli_real_escape_string($connection,$_POST['user_firstname']);
    // $post_date = date('d-m-y');
    $user_lastname = mysqli_real_escape_string($connection,$_POST['user_lastname']);
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $user_email = mysqli_real_escape_string($connection,$_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection,$_POST['user_password']);
    $user_role = mysqli_real_escape_string($connection,$_POST['user_role']);
    $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=> 12));

    $query = "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$username}', '{$user_email}', '{$password}', '{$user_role}')";
    $add_user_query = mysqli_query($connection, $query);
    confirmQuery($add_user_query);
    echo "User Created Successfully" . "<br>" . "<a href='users.php' class='btn btn-primary'>View Users</a>" . "<br>";
}


?>


<form action="" method="post" enctype='multipart/form-data'>
<div class="form-group">
    <label for="user_firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname">
</div>
<div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname">
</div>
<div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username">
</div>
<div class="form-group">
        <label for="user_role">User Role</label><br>
        <select name="user_role"  id="post_role">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

<!-- <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="post_image">
</div> -->
<div class="form-group">
    <label for="user_email">E-mail</label>
    <input type="email" class="form-control" name="user_email">
</div>
<div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" class="form-control" name="user_password">
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" name="create_user" value="Add User">
</div>







</form>
