
<?php
session_cache_expire(10);
    session_start();
    $BASE_URL = "http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"] . "?") . "/";
?>