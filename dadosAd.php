<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");

//SESSION LOGIN NÃO EXISTE = NÃO ACESSA A PÁGINA -> DIRECIONA PARA AUTH.PHP
$userDao = new UserDAO($conn, $BASE_URL);
$userDao->verifyAuth($_SESSION['login']);
?>

<div style="margin-top: 35px; margin-left: 35px; background-color: brown; font-size: 12px; color: white; font-weight: bold; text-align: left" id="oi">
  <?php
  // echo '<hr>';
  echo 'Dados do AD:';
  echo '<br>';
  echo 'Login - ' . $_SESSION['login'];
  echo '<br>';
  echo 'E-mail - ' . $_SESSION['mail'];
  echo '<br>';
  echo 'Nome Completo - ' . $_SESSION['fullname'];
  echo '<br>';
  echo  'Primeiro Nome: ' . $_SESSION['nome'];
  echo '<br>';
  echo  'Login VBS: ' . $_SESSION['scriptPath'];
  echo '<br>';
  echo  'Cargo: ' . $_SESSION['cargo'];
  echo '<br>';
  echo  'Setor: ' . $_SESSION['setor'];
  echo '<br>';
  echo 'token para autenticar em outros sistemas: ' . $_SESSION['auth_token'];
  echo '<br>';

  // $database = "oci:dbname=fpwipem";
  // $username = "fpw";
  // $password = "Ip3m5pfpw";
  // $hostname = "(DESCRIPTION=
  // (ADDRESS_LIST=
  //   (ADDRESS=(PROTOCOL=TCP) 
  //     (HOST=10.15.16.92)(PORT=1521)
  //   )
  // )
  // (CONNECT_DATA=(SERVICE_NAME=fpwipem))
  // )";
  // $connection = new PDO($database, $username, $password);

  // $stmt = $connection->prepare('select fuidentfun from funciona where funomfunc = "CARLOS ALBERTO SCALEA JUNIOR"');
  // $stmt->bindParam(":fullname", $_SESSION['fullname']);
  // $stmt->execute();
  // $_SESSION['matricula'] = $stmt->fetchAll();
  ?>