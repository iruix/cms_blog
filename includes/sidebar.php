<div class="col-md-4">
    <div class="well">
    <?php if(isset($_SESSION['user_role'])): ?>
    <h4>Logged in as <?php echo $_SESSION['username'];?></h4>
        <a class="btn btn-primary" href="includes/logout.php">Log Out</a>
    <?php else: ?>

                    <h4>Login</h4>
                    <form action="includes/login.php" method="post">
                        <div class="form-group">
                            <input name="username" placeholder="Enter Username" type="text" class="form-control">
                        </div>
                        <div class="input-group">
                            <input name="password" placeholder="Enter Password" type="password" class="form-control">
                            <span class="input-group-btn">
                                                <button class="btn btn-primary" name="login" type="submit">Login</button>
                                            </span>
                        </div>
                    </form> <!-- search form -->
    <?php endif; ?>
                </div>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form> <!-- search form -->
                    <!-- /.input-group -->
                </div>
                <!-- Blog Categories Well -->
                <div class="well">
                <?php
                $query = "SELECT * FROM categories";//You can limit it by adding LIMIT 3 to the end
                $select_categories_sidebar = mysqli_query($connection, $query);

                ?>
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                        $cat_title = $row['cat_title'];
                                        $cat_id = $row['cat_id'];
                                        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";

                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php"; ?>

            </div>