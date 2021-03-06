<?php include "includes/db.php"; ?>

<!-- header -->
<?php include "includes/header.php"; ?>

<!-- navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

<?php

if(isset($_GET['p_id'])){
    $post_id = $_GET['p_id'];
    $post_view_query = "UPDATE posts set post_views = post_views + 1 WHERE post_id = $post_id";
    $send_query = mysqli_query($connection, $post_view_query);

    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
    } else {
        $query = "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'published'";
    }
    $select_all_posts_query = mysqli_query($connection, $query);

    if(mysqli_num_rows($select_all_posts_query) < 1){
        echo "<h1> No posts currently available </h1>";
    } else {
        while($row = mysqli_fetch_assoc($select_all_posts_query)){
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
        ?>

<!--            <h1 class="page-header">-->
<!--                    Page Heading-->
<!--                    <small>Secondary Text</small>-->
<!--                </h1>-->

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>
<?php }

?>

<!-- Blog Comments -->

<?php
if(isset($_POST['create_comment'])){
    $post_id = $_GET['p_id'];
    $comment_author = mysqli_real_escape_string($connection,$_POST['comment_author']);
    $comment_email = mysqli_real_escape_string($connection,$_POST['comment_email']);
    $comment_content = mysqli_real_escape_string($connection,$_POST['comment_content']);
    if(!empty($comment_author) && !empty($comment_content) && !empty($comment_email)){
        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
        $query .= "VALUES ($post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
        $create_comment_query = mysqli_query($connection, $query);
        if(!$create_comment_query){
            die("QUERY FAILED" . mysqli_error($connection));
        }
    } else {
        echo "<script>alert('Fields Can Not Be Empty') </script>";
    }
}





?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action='' method='post'>
                        <div class="form-group">
                        <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                        <label for="comment_email">E-Mail</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                        <label for="">Your comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
<?php
$query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
$select_comment_query = mysqli_query($connection, $query);
if(!$select_comment_query){
    die("QUERY FAILED" . mysqli_error());
}
while($row = mysqli_fetch_assoc($select_comment_query)){
    $comment_date = $row['comment_date'];
    $comment_content = $row['comment_content'];
    $comment_author = $row['comment_author'];

?>
<!-- Comment -->
<div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>  
<?php } } } else {
    header("Location:index.php");
} ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>