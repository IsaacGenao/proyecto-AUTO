<?php require  "./inc/session.php"?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include_once "./inc/head.php"?>
</head>

<body>
<?php
    if(!isset($_GET["vista"]) || empty($_GET["vista"])){
        $_GET["vista"]="Login";
        
    }
    if(is_file("./vistas/".$_GET["vista"].".php") && $_GET["vista"]!="Login" 
        && $_GET["vista"]!="404" ){
  
        include "./inc/navbar.php";
        include "./vistas/".$_GET["vista"].".php";
        include "./inc/script.php";

    }else{

        if($_GET["vista"]=="Login"){
            include "./vistas/Login.php";
        }else{
            include "./vistas/404.php";
        }

    }

?>
</body>
</html>