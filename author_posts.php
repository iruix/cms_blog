<?php include "includes/db.php"; ?>

    <!-- header -->
<?php include "includes/header.php"; ?>

    <!-- navigation -->
<?php include "includes/navigation.php";
if(isset($_GET['p_id'])){
    $post_id = $_GET['p_id'];
    $post_author = $_GET['author'];
}
?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                <?php echo $post_author;?> Posts
            </h1>

            <?php
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                $query = "SELECT * FROM posts WHERE post_author = '{$post_author}'";
            } else {
                $query = "SELECT * FROM posts WHERE post_author = '{$post_author}' AND post_status = 'published'";
            }
            $select_all_posts_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_all_posts_query)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 150);
                $post_status = $row['post_status'];
                if($post_status == 'published'){



                    ?>


                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

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
                <?php } } ?>



            <hr>




        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

<?php include "includes/footer.php"; ?>