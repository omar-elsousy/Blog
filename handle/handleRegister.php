<?php
require_once('../connection.php');
session_start();
if(isset($_POST['submit'])){
    extract($_POST);
    $errors=[];
    if(empty($name)){
        $errors[]="name is required";
    }
    elseif(!is_string($name)){
        $errors[]="name must be string";
    }
    elseif(strlen($name)< 3){
        $errors[]="name must be more than 3 chars";
    }
    if(empty($email)){
        $errors[]="email is required";
    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[]="email is not valid";
    }
    if(empty($password)){
        $errors[]="password is required";
    }
    elseif(strlen($password)< 5){
        $errors[]="password must be more than 5 chars";
    }
    if(empty($phone)){
        $errors[]="phone is required";
    }
    elseif(!is_numeric($phone)){
        $errors[]="phone must be number";
    }
    if(empty($errors)){
        $new_password=password_hash($password,PASSWORD_BCRYPT);
        $query="insert into users (`name`,`email`,`password`,`phone`) values ('$name','$email','$new_password','$phone') " ;
        $runquery=mysqli_query($connect,$query);
        if($runquery){
            header("location:../login.php");
            exit();
        } else{
            header("location:../register.php");
        }
    }else{
        $_SESSION['errors']=$errors;
        header("location:../register.php");
    }

    

}