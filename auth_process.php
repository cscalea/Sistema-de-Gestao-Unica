<?php
require_once("config/globals.php");
require_once("config/db.php");
require_once("dao/UserDAO.php");
require_once("dao/PermissionsDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
$type = filter_input(INPUT_POST, "type");
$login = filter_input(INPUT_POST, "login");
$password = filter_input(INPUT_POST, "password");

if ($type === "login") {
    $userDao->AuthenticateUser($login, $password);
}
