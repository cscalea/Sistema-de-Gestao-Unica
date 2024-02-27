<?php
    require_once("dao/UserDAO.php");
    require_once("config/globals.php");
    require_once("config/db.php");
    $userDao = new UserDAO($conn, $BASE_URL);
    $userDao->logout();      
?>

   