<?php
if(isset($_GET['p_id'])){
    $the_post_id = $_GET['p_id'];
}
    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";//You can limit it by adding LIMIT 3 to the end
    $select_posts_by_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_title = $row['post_title'];
        $post_category = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comment_count'];
        $post_content = $row['post_content'];
    }
if(isset($_POST['update_post'])){
    $post_author = mysqli_real_escape_string($connection,$_POST['post_author']);
    $post_title = mysqli_real_escape_string($connection,$_POST['post_title']);
    $post_category_id = mysqli_real_escape_string($connection,$_POST['post_category']);
    $post_status = mysqli_real_escape_string($connection,$_POST['post_status']);
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_content = mysqli_real_escape_string($connection,$_POST['post_content']);
    $post_tags = mysqli_real_escape_string($connection,$_POST['post_tags']);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($select_image)){
            $post_image = $row['post_image'];  
        }
    }

    $query = "UPDATE posts SET post_title = '{$post_title}', post_category_id = '{$post_category_id}', post_date = now(), post_author = '{$post_author}', ";
    $query .= "post_status = '{$post_status}', post_image = '{$post_image}', post_tags = '{$post_tags}', post_content = '{$post_content}' WHERE post_id = {$the_post_id}";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);
    echo "Post Edited Successfully" . "<br>" . "<a href='../post.php?p_id={$post_id}' class='btn btn-success'>View Post</a>" . " " . "<a href='posts.php' class='btn btn-primary'>View All Posts</a>" . "<br>";
}
?>


<form action="" method="post" enctype='multipart/form-data'>
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <select name="post_category" id="post_category">
<?php
    $query = "SELECT * FROM categories";//You can limit it by adding LIMIT 3 to the end
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
        <label for="author">Post Author</label>
        <select name="post_author" id="post_author">
            <option value="<?php echo $post_author; ?>"><?php echo $post_author; ?></option>
            <?php
            $query = "SELECT * FROM users WHERE username != '{$post_author}'";//You can limit it by adding LIMIT 3 to the end
            $select_users = mysqli_query($connection, $query);
            confirmQuery($select_users);
            while($row = mysqli_fetch_assoc($select_users)){
                $username = $row['username'];
                echo "<option value='{$username}'>{$username}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
            <?php
                if($post_status == 'published'){
                    echo "<option value='draft'>draft</option>";
                } else {
                    echo "<option value='published'>publish</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Post Image</label><br>
        <img width="100" src="../images/<?php echo $post_image; ?>" name="image"alt="">
        <input type="file"  name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>"type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>