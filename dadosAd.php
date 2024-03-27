<?php require_once("templates/header.php"); ?>

   
    <div style="margin-top: 35px; margin-left: 35px; background-color: brown; font-size: 12px; color: white; font-weight: bold; text-align: left" id="oi">
    
    <?php
      // echo '<hr>';
      echo 'ID do USUÁRIO no banco: ' . $_SESSION['userid']; 
      echo '<br>'; 
      echo 'Dados do AD:';
      echo '<br>';
      echo 'Login - ' . $_SESSION['login'];
      echo '<br>';
      echo 'E-mail - ' . $_SESSION['mail'];
      echo '<br>';
      echo 'Nome Completo - ' . $_SESSION['fullname'];
      echo '<br>';
      // echo 'Usuário é ADM [1]sim [0]não - ' . $_SESSION['userIsAdm'];
      // echo '<br>';
      echo  'Login VBS: ' . $_SESSION['scriptPath'];
      echo '<br>';
      echo  'Cargo: ' . $_SESSION['cargo'];
      echo '<br>';
      echo  'Setor: ' . $_SESSION['dpto'];
      echo '<br>';
      echo 'token para autenticar em outros sistemas: ' . $_SESSION['auth_token'];
    
       ?>
      