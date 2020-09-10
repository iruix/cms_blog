<form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Edit Category</label>
<?php
if(isset($_GET['edit'])){
    $cat_id = $_GET['edit'];
    
?>
    <input value="<?php if(isset($cat_title)){ echo $cat_title; } ?>" class="form-control" type="text" name="cat_title">
<?php }

?>

<?php 
if(isset($_POST['update_cat'])){
    $cat_title_update = mysqli_real_escape_string($connection,$_POST['cat_title']);
    $query = "UPDATE categories SET cat_title = '{$cat_title_update}' WHERE cat_id = {$cat_id}";
    $update_query = mysqli_query($connection, $query);
}

?>
                                
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_cat" value='Update'>
                            </div>
                        </form>