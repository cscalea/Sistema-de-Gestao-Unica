<?php
require_once("config/globals.php");
require_once("config/db.php");
require_once("dao/UserDAO.php");
require_once("model/menu.php");
require_once("dao/MenuDAO.php");
require_once("dao/PermissionsDAO.php");

/* Pega o nome completo do usuárioe utiliza a function explode para separar o primeiro NOME */
if (isset($_SESSION['fullname'])) {
    $n = explode(" ", $_SESSION['fullname']);
    $nome = $n[0];
    $_SESSION['nome'] = $nome;
}

/* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */
$permissionDao = new PermissionsDAO($conn, $BASE_URL);
if (isset($_SESSION['login'])) {
    $permissionDao->verifyIfUserHasAdm($_SESSION['login']);
}
/* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */

$MenuDAO = new MenuDAO($conn, $BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

if (isset($_SESSION['login'])) {
    $menuarrays = $MenuDAO->listMenus();
}

/* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */
$message = new Message($BASE_URL);
$flassMessage = $message->getMessage();

if (!empty($flassMessage["msg"])) {
    $message->clearMessage();
}
/* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Único de Gestão</title>
     <link class="circuito" rel="short icon" href="<?= $BASE_URL ?>img/logo-branco.png" /> <!-- Ícone da aba do navegador -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
    <!-- Font Awesome - ícones gerais -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- JAVASCRIPT -->
    <script src="js/password.js"></script> <!-- Mostrar senha ao clicar no eye icon -->
    <!-- CSS -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>

<body>
    <?php
    if (isset($_SESSION['login']))
        if (!empty($_SESSION['login']) || $_SESSION['login'] != "") : ?>
        <header>
            <!-- MENU BUTTON -->
            <div class="menu-btn">
                <i id="openMenu" class="fas fa-bars"></i>
            </div>
            <div class="navbar-container">
                <nav>
<!-- ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- -->                    
                    <!-- <a href="#">
                <img src="img/ipem.png" alt="ipem sp" class="logo" />
            </a> -->
<!-- ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- -->        
                    <ul class="navbar-items">

                        <li>
                            <a href="index.php">Home</a>
                        </li>

                        <li>
                            <a href="allUsersFromAd.php">AD - All Users</a>
                        </li>

                        <li>
                            <a href="allUsersFromFpw.php">FPW - All Users</a>
                        </li>

                        <li>
                            <a href="dadosAd.php">Userdata</a>
                        </li>

                        <li>
                            <button id="btnEnviarToken">Enviar Token</button>
                        </li>

                    </ul>

                    <ul class="navbar-items-right">

                        <?php if (!isset($_SESSION['auth_token'])) : ?>
                            <li>
                                <a href="<?php $BASE_URL ?>auth.php" class="default-btn">Entrar</a>
                            </li>
                        <?php else : ?>

                            <li>
                                <a href="<?php $BASE_URL ?>editProfile.php"> <i class="fa fa-user" aria-hidden="true"></i>
                                    <?php echo $nome ?></a>
                            </li>

                            <li>
                                <a href="<?php $BASE_URL ?>logout.php" class="default-btn">Sair</a>
                            </li>                           
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </header>

        <div class="side-bar">
            <!-- HEADER SECTION -->
            <header>
                <!-- close button-->
                <div class="close-btn">
                    <i id="closeMenu" class="fas fa-times"></i>
                </div>
                <!-- image -->
                <img id="imgHeader" src="img/ipem.png" alt="IPEM">
                <!-- logo -->
                <h1>Sistema Único de Gestão</h1>
            </header>
            <div id="profileMenu">
                <h2>Bem-Vindo(a) <?= $nome ?> - <a href="<?php $BASE_URL ?>editProfile.php"> <i class="fas fa-edit" title="Editar Perfil"></i></a></h2>
            </div>
            <!-- MENU ITENS -->
            <div class="menu">
                <div class="item"><a href="<?php $BASE_URL ?>index.php"><i class="fa fa-home"></i>Home</a></div>
                <?php if ($_SESSION['userIsAdm'] != 0) : ?>
                <?php endif; ?>
                <div class="item"><a href="addPermission.php"><i class="fas fa-unlock-alt"></i>Autorizador</a></div>
                <?php foreach ($menuarrays as $menu) : ?>
                    <div class="item"><a target="_blank" href="<?= $menu->link ?>"><i class="<?= $menu->class ?>"></i><?= $menu->menu ?></a></div>
                <?php endforeach; ?>
                <div class="item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Sair</a></div>
            </div>
        </div>
        <div>
        </div>
    <?php endif; ?>


                                        <!-- JS Menu Lateral -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            //JQUERY FOR EXPAND AND COLLAPSE THE SIDEBAR
            $('.menu-btn').click(function() {
                $('.side-bar').addClass('active');
                $('.menu-btn').css("visibility", "hidden")
            });

            //for close button
            $('.close-btn').click(function() {
                $('.side-bar').removeClass('active');
                $('.menu-btn').css("visibility", "visible");
            });

            /* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */
            //jquery for toggle sub menus
            $('.sub-btn').click(function() {
                $(this).next('.sub-menu').slideToggle();
                $(this).find('.dropdown').toggleClass('rotate');
            });
            /* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */
        })
    </script>


                                <!-- JS Usuário Não Volta Página -->
    <script>
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.pushState(null, null, document.URL);
        });
    </script>

    <!-- ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- -->
    <?php if (!empty($flassMessage["msg"])) : ?>
        <div class="msg-container">
            <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
        </div>
    <?php endif; ?>
    <!-- ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- -->