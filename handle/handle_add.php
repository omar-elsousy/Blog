<?php
require_once('../connection.php');
session_start();
if(isset($_POST['submit'])){
    // catch data
    $title=$_POST['title'];
    $body=$_POST['body'];
    $img=$_FILES['image'];
    $img_name=$img['name'];
    $img_tmp_name=$img['tmp_name'];
    $img_error=$img['error'];
    $ext=pathinfo($img_name, PATHINFO_EXTENSION);
    $new_name=uniqid().".".$ext;
    // errors
    $errors=[];
    // validation
    if(empty($title)){
        $errors[]="title is required";
    }   
    if(empty($body)){
        $errors[]="body is required";
    }
    if(empty($img)){
        $errors[]="please uploud photo";
    }
    elseif($img_error>0){
        $errors[]="file is broken";
    }
    elseif(!in_array($ext,['jpg','png'])){
        $errors[]="your image should be jpg or png";
    }
    // check errors exist or not and react base on this
    if(empty($errors)){
        $query="insert into posts (`title`,`body`,`image`,`user_id`) values('$title','$body','$new_name','1')";
        $runquery=mysqli_query($connect,$query);
        if($runquery){
            $_SESSION['success']= "The post inserted successfully";
            move_uploaded_file($img_tmp_name,'../assets/images/postImage/'.$new_name);
            header('location:../index.php');
            exit();
    }
    }else{
    $_SESSION['errors']=$errors;
    header('location:../addPost.php');
}
}
