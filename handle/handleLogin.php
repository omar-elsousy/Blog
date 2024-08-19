<?php
require_once("../connection.php");
session_start();
if(isset($_POST['submit'])){
    extract($_POST);
    $errors=[];
    if(!empty($email) && !empty($password)){
        $query="select * from users where email = '$email' ";
        $runquery=mysqli_query($connect,$query);
        if($runquery){
            $user=mysqli_fetch_assoc($runquery);
            $username=$user['name'];
            $user_id=$user['id'];
            $old_password=$user['password'];
            $passord_verify=password_verify($password,$old_password);
            if($passord_verify){
                $_SESSION['user_id']=$user_id;
                $_SESSION['success']="welcome ". $username;
                header("location:../index.php");
                exit();
            }else{
                $_SESSION["error"]="wrong password";
                header("location:../login.php");
                exit();
            }
    }else{
        $_SESSION["error"]="wrong email";
        header("location:../login.php");
        exit();
    }
    }else{
        $_SESSION['error']="email and password are required";
        header("location:../login.php");
        exit();
}
}