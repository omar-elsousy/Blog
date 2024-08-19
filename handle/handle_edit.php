<?php
session_start();
require_once('../connection.php');
if(isset($_POST['submit'])&&isset($_GET['id'])){
    $id=$_GET['id'];
    $title=$_POST['title'];
    $body=$_POST['body'];
    $errors=[];
    $query="select * from posts where id = '$id' ";
    $runquery=mysqli_query($connect,$query);
    $post=mysqli_fetch_assoc($runquery);
    $old_img=$post['image'];
    if(empty($title)){
        $errors[]="title is required";
    }
    if(empty($body)){
        $errors[]="body is required";
    }
    if( isset($_FILES['image']) && $_FILES['image']['name'] ){
        $img=$_FILES['image'];
        $img_name=$img['name'];
        $img_tmp_name=$img['tmp_name'];
        $img_error=$img['error'];
        $ext=pathinfo($img_name, PATHINFO_EXTENSION);
        $new_name=uniqid().".".$ext;
        if(empty($img)){
            $errors[]="Please uploud photo";
        }
        elseif($img_error>0){
            $errors[]="file is broken";
        }
        elseif(!in_array($ext,['jpg','png'])){
            $errors[]="file must be jpg or png";
        }
    }else{
        $new_name=$old_img;
    }
    if(empty($errors)){
        $query="update posts set title='$title' , body='$body' , image='$new_name' where id ='$id' ";
        $runquery=mysqli_query($connect,$query);
        if($runquery){
            $_SESSION['success']="post is updated successfully";
            move_uploaded_file($img_tmp_name,"../assets/images/postImage".$new_name);
            unlink("../assets/images/postImage".$old_img);
            header("location:../index.php");
            exit();
        }
    }else{
        $_SESSION['errors']=$errors;
        header("location:../index.php");
    }
}


