<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Post ID</th>
            <th>Author</th>
            <th>Date</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
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
        echo "<tr>";
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
        echo "<td>{$post_comments}</td>";
        echo "<td><a href='posts.php?source=edit_posts&p_id={$post_id}'>Edit</a></td>";
        echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
    }

?>       
    </tbody>
    </table>
<?php
if(isset($_GET['delete'])){
    $post_id_delete = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = {$post_id_delete}";
    $delete_query = mysqli_query($connection, $query);

}


?>