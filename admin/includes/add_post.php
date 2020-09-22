<?php
if(isset($_POST['create_post'])){
    $post_title = mysqli_real_escape_string($connection,$_POST['title']);
    $post_author = mysqli_real_escape_string($connection,$_POST['author']);
    $post_date = date('d-m-y');
    $post_category = mysqli_real_escape_string($connection,$_POST['post_category']);
    $post_status = mysqli_real_escape_string($connection,$_POST['post_status']);
    $post_tags = mysqli_real_escape_string($connection,$_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection,$_POST['post_content']);

    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];

    move_uploaded_file($post_image_tmp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
    $query .= "VALUES({$post_category}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
    echo "Post Created Successfully" . "<br>" . "<a href='posts.php' class='btn btn-primary'>View Posts</a>" . "<br>";
}


?>

<form action="" method="post" enctype='multipart/form-data'>
<div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
</div>
<div class="form-group">
        <label for="post_category">Post Category</label><br>
        <select name="post_category" id="post_category">
<?php
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
    confirmQuery($select_categories);
    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<option value='$cat_id'>{$cat_title}</option>";
    }


?>
        </select>
    </div>
<div class="form-group">
    <label for="author">Post Author</label><br>
    <select name="author" id="author">
        <?php
        $currentUser = $_SESSION['username'];
        $currentUserId = $_SESSION['id'];
        echo "<option value='$currentUserId'>{$currentUser}</option>";
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);
        confirmQuery($select_users);
        while($row = mysqli_fetch_assoc($select_users)){
            $user_name = $row['username'];
            $user_id = $row['user_id'];
            echo "<option value='$user_id'>{$user_name}</option>";
        }


        ?>
    </select>
</div>
<div class="form-group">
    <label for="post_status">Post Status</label><br>
    <select name="post_status" id="post_status">
        <option value="draft">Draft</option>
        <option value="published">Publish</option>
    </select>
</div>
<div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="post_image">
</div>
<div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
</div>
<div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" id="editor" cols="30" rows="10">
    </textarea>
</div>

<div class="form-group">
<input type="submit" class="btn btn-primary" name="create_post" value="Submit Post">
</div>







</form>