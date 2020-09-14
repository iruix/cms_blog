<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-Mail</th>
            <th>Role</th>
            <th>Role => Admin</th>
            <th>Role => Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
<?php
    $query = "SELECT * FROM users";//You can limit it by adding LIMIT 3 to the end
    $select_users = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_users)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
        echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";
        echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "</tr>";
    }

?>       
    </tbody>
    </table>
<?php
if(isset($_GET['change_to_admin'])){
    $user_role_admin = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_role_admin";
    $user_admin_query = mysqli_query($connection, $query);
    header("Location: users.php");
}

if(isset($_GET['change_to_subscriber'])){
    $user_role_subscriber = $_GET['change_to_subscriber'];
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $user_role_subscriber";
    $user_subscriber_query = mysqli_query($connection, $query);
    header("Location: users.php");
}

if(isset($_GET['delete'])){
    $user_id_delete = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = {$user_id_delete}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: users.php");
}


?>