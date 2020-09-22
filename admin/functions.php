<?php

function escape($str) { //This is for everything that comes and goes to the database
    global $connection;
    return mysqli_real_escape_string($connection, trim($str));
}

function usersOnline(){
    if(isset($_GET['onlineusers'])) {
        global $connection;
        if(!$connection){
            session_start();
            include '../includes/db.php';
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 60;
            $timeOut = $time - $time_out_in_seconds;
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);
            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time= '$time' WHERE session = '$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$timeOut'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}
usersOnline();

function confirmQuery($result){
    global $connection;
    if(!$result){
        die("Query Failed" . mysqli_error($connection));
    }
}

function createCategories(){
    global $connection;
    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)){
            echo "This field should not be empty!";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query){
                die("Query Failed!" . mysqli_error($connection));
            }
        }
    }
}




function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";//You can limit it by adding LIMIT 3 to the end
    $select_categories = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";

    }
}



function deleteCategory(){
    global $connection;
    if(isset($_GET['delete'])){
        $cat_id_delete = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$cat_id_delete}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

?>