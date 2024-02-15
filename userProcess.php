<?php
require_once("globals.php");
require_once("db.php");
require_once("dao/UserDAO.php");
require_once("model/message.php");

$UserDao = new UserDAO($conn, $BASE_URL);
