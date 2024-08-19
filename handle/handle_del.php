<?php
require_once("../connection.php");
session_start();
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $query="delete from posts where id = '$id' ";
    $runquery=mysqli_query($connect,$query);
    if($runquery){
        $_SESSION['success'] = "post is deleted successfully";
        header("location:../index.php");
        exit();
    }else{
        $_SESSION['error']="post is not deleted";
        header("location:../index.php");
    }
}