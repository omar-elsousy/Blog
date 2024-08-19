<?php
session_start();
if(isset($_GET['lang'])){
    $lang=$_GET['lang'];
}else{
    $lang="en";
}

if($lang=="en"){
    $_SESSION['lang']="en";
}
elseif($lang=="ar"){
    $_SESSION['lang']="ar";
}
header("location:".$_SERVER["HTTP_REFERER"]);
