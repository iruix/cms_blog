<?php
include("modals.php");
if(isset($_POST['checkBoxArray'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            foreach($_POST['checkBoxArray'] as $checkBoxValue) {
                $bulkOptions = $_POST['bulk_options'];
                switch ($bulkOptions) {
                    case 'published':
                        $query = "UPDATE posts SET post_status = '{$bulkOptions}' WHERE post_id = {$checkBoxValue}";
                        $publishQuery = mysqli_query($connection, $query);
                        confirmQuery($publishQuery);
                        break;
                    case 'draft':
                        $query = "UPDATE posts SET post_status = '{$bulkOptions}' WHERE post_id = {$checkBoxValue}";
                        $draftQuery = mysqli_query($connection, $query);
                        confirmQuery($draftQuery);
                        break;
                    case 'delete':
                        $query = "DELETE FROM posts WHERE post_id = {$checkBoxValue}";
                        $deleteQuery = mysqli_query($connection, $query);
                        confirmQuery($deleteQuery);
                        break;
                    case 'clone':
                        $query = "SELECT * FROM posts WHERE post_id = {$checkBoxValue}";
                        $select_posts_by_id = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
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
                        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                        $query .= "VALUES({$post_category}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
                        $update_post = mysqli_query($connection, $query);
                        confirmQuery($update_post);
                }
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("You have to be Admin to do that")';
            echo '</script>';
        }
    }
}


?>

<form action="" method="post">
<table class="table table-bordered table-hover">
    <div id="bulkOptionsContainer" class="col-xs-3">
        <select class="form-control" name="bulk_options" id="">
            <option disabled selected value>Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
    </div>



    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Post ID</th>
            <th>Author</th>
            <th>Date</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Post Views</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Clone</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
<?php
    $query = "SELECT * FROM posts";//You can limit it by adding LIMIT 3 to the end
    $select_posts = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_title = $row['post_title'];
        $post_category = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comment_count'];
        $post_views = $row['post_views'];
        echo "<tr>";
        ?>
        <td><input class='checkBoxes' type='checkbox' name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
        <?php
        echo "<td>{$post_id}</td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$post_date}</td>";
        echo "<td>{$post_title}</td>";


        $query = "SELECT * FROM categories WHERE cat_id = {$post_category}";
        $select_categories_edit = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_categories_edit)){
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];

        echo "<td>{$cat_title}</td>";
        }
        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/{$post_image}' alt='image'></td>";
        echo "<td>{$post_tags}</td>";

        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $send_comment_count = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($send_comment_count);
        $comment_id = isset($row['comment_id']);
        $count_comments = mysqli_num_rows($send_comment_count);
        echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";



        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to reset post views?'); \" href='posts.php?resetviews={$post_id}'>{$post_views}</a></td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
        echo "<td><a href='posts.php?source=edit_posts&p_id={$post_id}'>Edit</a></td>";
//        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to clone?'); \" href='posts.php?clone={$post_id}'>Clone</a></td>";
        echo "<td><a rel='$post_id' href='javascript:void(0)' class='clone_link'>Clone</a></td>";
        echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
//        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
    }

?>       
    </tbody>
    </table>
</form>
<?php
if(isset($_GET['delete'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $post_id_delete = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "DELETE FROM posts WHERE post_id = {$post_id_delete}";
            $delete_query = mysqli_query($connection, $query);
            header("Location: posts.php");
        } else {
            echo '<script language="javascript">';
            echo 'alert("You have to be Admin to do that")';
            echo '</script>';
        }
    }

}
if(isset($_GET['resetviews'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $post_id_reset = mysqli_real_escape_string($connection, $_GET['resetviews']);
            $query = "UPDATE posts SET post_views = 0 WHERE post_id = {$post_id_reset}";
            $delete_query = mysqli_query($connection, $query);
            header("Location: posts.php");
        } else {
            echo '<script language="javascript">';
            echo 'alert("You have to be Admin to do that")';
            echo '</script>';
        }
    }

}
if(isset($_GET['clone'])){
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $post_id_clone = mysqli_real_escape_string($connection, $_GET['clone']);
            $query = "SELECT * FROM posts WHERE post_id = $post_id_clone";
            $select_posts_by_id = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
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

            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES({$post_category}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
            $update_post = mysqli_query($connection, $query);
            confirmQuery($update_post);
            echo "Post Cloned Successfully" . "<br>" . "<a href='../post.php?p_id={$post_id}' class='btn btn-primary'>View Post</a>" . "<br>";
            header("Location: posts.php");
        } else {
            echo '<script language="javascript">';
            echo 'alert("You have to be Admin to do that")';
            echo '</script>';
        }
    }
}


?>

<script>
    $(document).ready(function (){
        $('.delete_link').on('click', function(){
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+ id +"";

            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });

        $('.clone_link').on('click', function(){
            var id = $(this).attr("rel");
            var clone_url = "posts.php?clone="+ id +"";

            $(".modal_clone_link").attr("href", clone_url);
            $("#cloneModal").modal('show');
        });
    });
</script>
