<?php
require_once("globals.php");
require_once("db.php");
require_once("model/permissions.php");
require_once("model/message.php");
require_once("dao/UserDAO.php");
require_once("dao/PermissionsDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$PermissionsDAO = new PermissionsDAO($conn, $BASE_URL);

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");


if ($type === "create") {

  //RECEBE OS DADOS DOS INPUTS ADDPERMISSONS.PHP

  $fk_idusers = filter_input(INPUT_POST, "fk_idusers");
  $fk_idmenus = filter_input(INPUT_POST, "fk_idmenus");
  $adm = filter_input(INPUT_POST, "adm");
  $permission = new Permissions();
  $permission->fk_iduser = $fk_idusers;
  $permission->fk_idmenu = $fk_idmenus;
  $permission->adm = $adm;

  $verify = $PermissionsDAO->verifyMenu($fk_idusers, $fk_idmenus);
  if (!isset($verify)) {
    $PermissionsDAO->insertPermission($permission);
  } else {
    $message->setMessage("O usuário já possui o menu.", "error", "addPermission.php");
  }
} else if ($type === "delete") {
  $fk_iduser = filter_input(INPUT_POST, "fk_idusers");
  $fk_idmenu = filter_input(INPUT_POST, "fk_idmenus");
 

  $PermissionsDAO->deletePermission($fk_iduser, $fk_idmenu);

  
}


