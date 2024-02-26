<?php
require_once("config/globals.php");
require_once("config/db.php");
require_once("dao/UserDAO.php");
require_once("model/message.php");
require_once("model/menu.php");
require_once("dao/MenuDAO.php");
require_once("dao/PermissionsDAO.php");


$userDao = new UserDAO($conn, $BASE_URL);
?>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão Corporativa</title>
    <link class="circuito" rel="short icon" href="<?= $BASE_URL ?>img/erp.png" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
    <!-- Font Awesome -->

    





    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- CSS do projeto -->

    <!-- SEARCH FORM -->

    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">

<div style="height: 100%;"class="container-fluid" id="main-container">
    
    <form style="margin-top: 250px; background-color: white" id="create-form" action="<?= $BASE_URL ?>auth_process.php" method="POST">
        <input type="hidden" name="type" value="insertUser">

        <br>
        <div class="form-group">
            <h5>Concluir cadastro:</h5>
            <label for="name">Nome:</label>
            <input type="text" id="inputName" name="name" placeholder="Digite seu nome completo" placeholder="Digite seu nome completo">
        </div>
        <div class="form-group">
            <label id="lblEmail" for="email">Email:</label>
            <input type="text" id="inputEmail" name="email" placeholder="Digite seu e-mail corporativo" value="<?php echo $_SESSION['windowsuser']?>@ipem.sp.gov.br">
            <div id="resultado"></div>

        </div>

        <button type="submit" class="card-btn">Salvar</button>

</div>
</form>

