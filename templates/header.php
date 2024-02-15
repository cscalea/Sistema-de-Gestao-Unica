<?php
require_once("globals.php");
require_once("db.php");
require_once("dao/UserDAO.php");
require_once("model/message.php");
require_once("model/menu.php");
require_once("dao/MenuDAO.php");
require_once("dao/PermissionsDAO.php");

function getUserLogin(){
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $command = exec('wmic /node:"'.$hostname.'" computersystem get username', $displayInfo);
    $arrayInfo = explode("\\",$displayInfo[1]);
    return $arrayInfo;
    }
    
    $display = getUserLogin();
   
    $wuser = $user = $display[1];
    $_SESSION['windowsuser'] = $wuser;

// pega o primeiro nome do usuário logado para mostrar no MENU
if(isset($_SESSION['username'])){
    $n = explode(" ", $_SESSION['username']);
    $nome = $n[0];
}

$permissionDao = new PermissionsDAO($conn, $BASE_URL);
if(isset($_SESSION['login'])){
$permissionDao->verifyIfUserHasAdm($_SESSION['login']);
}
$MenuDAO = new MenuDAO($conn, $BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

if (isset($_SESSION['login'])) {
    
    $menuarrays = $MenuDAO->getMenusByUserLogin($_SESSION['login']);
}
// print_r($menuarrays);
// $_SESSION['login'] === "";

$message = new Message($BASE_URL);
$flassMessage = $message->getMessage();

if (!empty($flassMessage["msg"])) {
    $message->clearMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão Corporativa</title>
    <link class="circuito" rel="short icon" href="<?= $BASE_URL ?>img/logo-branco.png" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
    <!-- Font Awesome -->

        <!-- JAVASCRIPT -->
    <script src="js/password.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <!-- CSS do projeto -->

    <!-- SEARCH FORM -->

    <link rel="stylesheet" href="<?= $BASE_URL ?>css/styles.css">
</head>

<body>


    <?php if (isset($_SESSION['login']))
        if (!empty($_SESSION['login']) || $_SESSION['login'] != "") : ?>



        <!-- MENU BUTTON -->
        <div class="menu-btn">
            <i class="fas fa-bars"></i>
        </div>
        <div class="side-bar">
            <!-- HEADER SECTION -->
            <header>
                <!-- close button-->
                <div class="close-btn">
                    <i class="fas fa-times"></i>
                </div>
                <!-- image -->
                <img src="img/ipem.png" alt="IPEM">
                <!-- logo -->
                <h1>Sistema único de Gestão</h1>
            </header>
            <div id="profileMenu">
             <h2>Bem-Vindo <?= $nome ?> -  <a href="<?php $BASE_URL ?>editProfile.php">   <i class="fas fa-edit" title="Editar Perfil"></i></a></h2>
             
             </div>
            <!-- MENU ITENS -->
            <div class="menu">
                <div class="item"><a href="<?php $BASE_URL ?>index.php"><i class="fa fa-home"></i>Home</a></div>

                <?php if($_SESSION['userIsAdm'] != 0): ?>
                        <div class="item"><a href="addPermission.php">Autorizador</a></div>
                        <?php endif; ?>
                <?php foreach ($menuarrays as $menu) : ?>
                  

                    <?php if ($menu->menu == "Gestão da Fonte 4") : ?>
                        <div class="item"><a target="_blank" href="<?php $BASE_URL ?> /index.php">Gestão da Fonte 4</a></div>

                    <?php elseif ($menu->menu == "Programação de Trabalho") : ?>
                        <div class="item"><a target="_blank" href="https://programacao.ipem.sp.gov.br/">Programação de Trabalho</a></div>

                    <?php elseif ($menu->menu == "Centro de Processos Permanentes") : ?>
                        <div class="item"><a target="_blank" href="<?php $BASE_URL ?> /index.php">Centro de Processos Permanentes</a></div>

                    <?php elseif ($menu->menu == "Monitoramento Segurança") : ?>
                        <div class="item"><a target="_blank" href="http://10.15.16.211/antivirus/">Monitoramento de Segurança</a></div>

                        
                    
                        
                        
                    <?php endif; ?>
                    <!-- aaa -->
                <?php endforeach; ?>
                
                <div class="item"><a target="_blank" href="https://chamados.ipem.sp.gov.br/">Helpdesk</a></div>

                <div class="item"><a target="_blank" href="http://10.15.16.213/">Ouvidoria</a></div>

                <div class="item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Sair</a></div>
            </div>


        </div>


        <div>
        </div>




    <?php endif; ?>
    <!-- JQuery CDN link -->
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

            // jquery for toggle sub menus
            $('.sub-btn').click(function() {
                $(this).next('.sub-menu').slideToggle();
                $(this).find('.dropdown').toggleClass('rotate');
            });
        })
    </script>

<!-- 
    <script type="text/javascript">
        function buscaEmail(email){
            $.ajax({
                url: "searchEmail.php",
                method: 'POST',
                data: {email:email},
                success: function(data){
                    $('#resultado').html(data);
                }
            });
        }

        $(document).ready(function(){
            buscarEmail();
            $('#buscar').keyup(function(){
                var email = $(this).val();
                if(email!=''){
                    buscarEmail(email);
                }
                else
                {
                    buscarEmail();
                }
            })
        })
        </script> -->



    <script>
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function() {
            history.pushState(null, null, document.URL);
        });
    </script>

    <?php if (!empty($flassMessage["msg"])) : ?>
        <div class="msg-container">
            <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
        </div>
    <?php endif; ?>