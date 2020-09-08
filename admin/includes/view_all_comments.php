<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Date</th>
            <th>Comment</th>
            <th>E-Mail</th>
            <th>Status</th>
            <th>In Response To</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
<?php
    $query = "SELECT * FROM comments";//You can limit it by adding LIMIT 3 to the end
    $select_comments = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id = $row['comment_id'];
        $comment_author = $row['comment_author'];
        $comment_date = $row['comment_date'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_post_id = $row['comment_post_id'];
        $comment_content = $row['comment_content'];
        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_content}</td>";
        


        // $query = "SELECT * FROM categories WHERE cat_id = {$post_category}";
        // $select_categories_edit = mysqli_query($connection, $query);
        // while($row = mysqli_fetch_assoc($select_categories_edit)){
        //     $cat_title = $row['cat_title'];
        //     $cat_id = $row['cat_id'];

        // echo "<td>{$cat_title}</td>";
        // }




        echo "<td>{$comment_email}</td>";
        echo "<td>{$comment_status}</td>";
        echo "<td>Some Title</td>";
        echo "<td>{$comment_date}</td>";
        echo "<td><a href='posts.php?source=edit_posts&p_id='>Approve</a></td>";
        echo "<td><a href='posts.php?source=edit_posts&p_id='>Unapprove</a></td>";
        echo "<td><a href='posts.php?source=edit_posts&p_id='>Edit</a></td>";
        echo "<td><a href='posts.php?delete='>Delete</a></td>";
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