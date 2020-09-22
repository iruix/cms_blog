
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">



            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Home Page</a>
            </div>



            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                    <?php
                        $query = "SELECT * FROM categories";
                        $select_all_categories_query = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($select_all_categories_query)){
                            $cat_title = $row['cat_title'];
                            echo "<li><a href='#'>{$cat_title}</a></li>";

                        }
                    if (session_status() === PHP_SESSION_NONE) session_start();
                        if(isset($_SESSION['user_role'])){
                            $user_role_confirm = $_SESSION['user_role'];
                            if($user_role_confirm == 'admin'){
                                if(isset($_GET['p_id'])) {
                                    $post_id = $_GET['p_id'];
                                    echo "<li><a href='admin/posts.php?source=edit_posts&p_id={$post_id}'>Edit Post</a></li>";
                                }
                            }
                        }

                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="contact.php">Contact us</a></li>
                    <li><a href="registration.php">Register</a></li>
                    <li><a href="admin">Admin</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>