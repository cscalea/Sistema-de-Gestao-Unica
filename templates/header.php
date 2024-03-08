<?php
require_once("config/globals.php");
require_once("config/db.php");
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
if(isset($_SESSION['fullname'])){
    $n = explode(" ", $_SESSION['fullname']);
    $nome = $n[0];
}

$permissionDao = new PermissionsDAO($conn, $BASE_URL);
if(isset($_SESSION['login'])){
$permissionDao->verifyIfUserHasAdm($_SESSION['login']);
}
$MenuDAO = new MenuDAO($conn, $BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

if (isset($_SESSION['login'])) {
    
    // $menuarrays = $MenuDAO->getMenusByUserLogin($_SESSION['login']);
    $menuarrays = $MenuDAO->listMenus();
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Único de Gestão</title>
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


<header id="headerTop">
     <!-- MENU BUTTON -->
     <div class="menu-btn">

        
<i id="openMenu" class="fas fa-bars"></i>
</div>


<div class="navbar-container">
        <nav>
          <a href="#">
            <img src="img/ipem.png" alt="hDC Host" class="logo" />
          </a>
          <ul class="navbar-items">
            <li>
              <a href="home.php">Home</a>
            </li>
            <?php if(!isset($_SESSION['auth_token'])):?>
            <li>
              <a href="<?php $BASE_URL ?>auth.php" class="default-btn">Entrar</a>
            </li>
            <?php else: ?>
            <li>
              <a href="<?php $BASE_URL ?>logout.php" class="default-btn">Sair</a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>


<!-- <nav id="main-navbar" class="navbar navbar-expand-lg">
<ul class="navbar-nav">
          
           
            <li class="nav-item">
              <a target="_blank" href="<?=$BASE_URL?>img/pmd.png" class="nav-link">Plano de Metas DTIN - 2024</a>
            </li>
            
            
            
            
       
        </ul>
        <a href="<?php $BASE_URL?>editProfile.php"><p id="nameHeader" style="color: white; display: flex; text-align: center; margin-right: 8px; margin-top: 16px;"><?php echo $nome?></p></a>
        <a id="quit" style="color: white; display: flex; text-align: center;" href="logout.php"><i class="fas fa-sign-out-alt"></i>Sair</a>
        
</nav> -->

</header>
       
        <div class="side-bar">
            <!-- HEADER SECTION -->
            <header>
                <!-- close button-->
                <div class="close-btn">
                    <i id="closeMenu"class="fas fa-times"></i>
                </div>
                <!-- image -->
                <img id="imgHeader" src="img/ipem.png" alt="IPEM">
                <!-- logo -->
                <h1>Sistema Único de Gestão</h1>
            </header>
            <div id="profileMenu">
             <h2>Bem-Vindo(a) <?= $nome ?> -  <a href="<?php $BASE_URL ?>editProfile.php">   <i class="fas fa-edit" title="Editar Perfil"></i></a></h2>
             
             </div>
            <!-- MENU ITENS -->
            <div class="menu">
                <div class="item"><a href="<?php $BASE_URL ?>index.php"><i class="fa fa-home"></i>Home</a></div>

                <?php if($_SESSION['userIsAdm'] != 0): ?>
                        
                        <?php endif; ?>
                        <div class="item"><a href="addPermission.php"><i class="fas fa-unlock-alt"></i>Autorizador</a></div>
                        
                <?php foreach ($menuarrays as $menu) : ?>       
                        <div class="item"><a target="_blank" href="<?=$menu->link?>"><i class="<?=$menu->class?>"></i><?=$menu->menu?></a></div>
                <?php endforeach; ?>

                <!-- <div class="item"><a target="_blank" href="http://10.15.16.211/antivirus/"><i class="fas fa-shield-alt"></i>Monitoramento de Segurança</a></div>

                <div class="item"><a target="_blank" href="<?php $BASE_URL ?> /index.php"><i class="fas fa-address-book"></i>CPP</a></div>

                <div class="item"><a target="_blank" href="https://programacao.ipem.sp.gov.br/"><i class="far fa-calendar-alt"></i>Programação de Trabalho</a></div>

                <div class="item"><a target="_blank" href="<?php $BASE_URL ?> /index.php"><i class="fas fa-dollar-sign"></i>Gestão da Fonte 4</a></div>
                
                <div class="item"><a target="_blank" href="#"><i class="fas fa-clipboard-check"></i>Módulo da Qualidade</a></div>

                <div class="item"><a target="_blank" href="#" ><i class="fas fa-atom"></i>Gestão de Laboratórios</a></div>

                <div class="item"><a target="_blank" href="#"><i class="fas fa-truck "></i>Apoio à gestão de VTR</a></div>

                <div class="item"><a target="_blank" href="#"><i class="far fa-address-card"></i>Módulo do RH</a></div>

                <div class="item"><a target="_blank" href="#"><i class="far fa-file-alt"></i>Boletim de Tráfego</a></div>

                <div class="item"><a target="_blank" href="https://chamados.ipem.sp.gov.br/"><i class="far fa-keyboard"></i>Helpdesk</a></div>

                <div class="item"><a target="_blank" href="#"><i class="fas fa-tag"></i>Gestão do Patrimônio</a></div>

                <div class="item"><a target="_blank" href="#"><i class="fas fa-chart-bar"></i>Ferramenta de BI</a></div>

                <div class="item"><a target="_blank" href="https://fiscaliza.ipem.sp.gov.br/"><i class="fas fa-phone-volume"></i>Ouvidoria</a></div> -->

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