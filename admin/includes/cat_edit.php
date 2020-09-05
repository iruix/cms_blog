<form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Edit Category</label>
<?php
if(isset($_GET['edit'])){
    $cat_id = $_GET['edit'];
    $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";//You can limit it by adding LIMIT 3 to the end
    $select_categories_edit = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_categories_edit)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
?>
    <input value="<?php if(isset($cat_title)){ echo $cat_title; } ?>" class="form-control" type="text" name="cat_title">
<?php }
}
?>

<?php 
if(isset($_POST['update_cat'])){
    $cat_title_update = $_POST['cat_title'];
    $query = "UPDATE categories SET cat_title = '{$cat_title_update}' WHERE cat_id = {$cat_id}";
    $update_query = mysqli_query($connection, $query);
}

?>
                                
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_cat" value='Update'>
                            </div>
                        </form>