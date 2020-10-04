<?php include "includes/db.php"; ?>

<!-- header -->
<?php include "includes/header.php"; ?>

<!-- navigation -->
<?php include "includes/navigation.php"; ?>
    <link href="css/style.css" rel="stylesheet">

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    CMS BLOG



<?php
$per_page = 5; //Posts displayed per page
    if(isset($_GET['page'])){
        $page = $_GET['page'];

    } else {
        $page = 1;
    }
    echo "<small>Page Number {$page}</small></h1>";

    if($page == "" || $page == 1){
        $page_1 = 0;
    } else {
        $page_1 = ($page * $per_page) - $per_page;
    }
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
        $query = "SELECT * FROM posts";
    } else {
        $query = "SELECT * FROM posts WHERE post_status = 'published'";
    }
    $find_count = mysqli_query($connection, $query);
    $count = mysqli_num_rows($find_count);

    if($count < 1){
        echo "<h1> No posts currently available </h1>";
    } else {

    $count = ceil($count / $per_page);

    $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
    $select_all_posts_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_all_posts_query)){
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = substr($row['post_content'], 0, 150);
            $post_status = $row['post_status'];


            
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
                <br>
                <br>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

<?php }  } ?>

        
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

    <ul class="pager">
        <h2><small>Page <?php echo $page; ?></small></h2>
        <?php
        for($i = 1; $i <= $count; $i++){
            if($i == $page){
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }

        ?>

    </ul>

<?php include "includes/footer.php"; ?>