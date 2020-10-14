<?php session_start(); ?>
<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    login($_POST['username'], $_POST['password']);
}
?>
