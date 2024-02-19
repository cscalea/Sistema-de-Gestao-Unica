<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("model/message.php");
$userDao = new UserDAO($conn, $BASE_URL);
$message = new Message($BASE_URL);
// if(isset($_SESSION['login'])){
// $userDao->verifyAuth2($_SESSION['login']);
// }

//adicionei um coment no arquivo auth.php
?>



<?php if(!isset($_SESSION['login']) || $_SESSION['login'] === ""): ?>
<!-- CONTAINER PRINCIPAL DAS PÁGINAS - MAIN CONTAINER -->
<div id="main-container" class="container-fluid">
    
   
    <!--CLASSE GERAL ONDE DENTRO ESTARÁ O FORMULÁRIO DE LOGIN ??? 12 COLUNAS -->
    <div class="col-md-12">
        <!-- CLASSE ROW - LINHA - ONDE DENTRO ESTARÁ O FORMULÁRIO DE LOGIN ???-->
        <div class="row" id="auth-row">
            <!-- CONTAINER DO LOGIN FORM -->
            <div class="col-md-4">
                <!-- TEXTO DE LOGAR EM CIMA DO FORM DE LOGIN -->
                
                <!-- FORMULÁRIO DE LOGIN COM METHOD POST, ACTION QUE DIRECIONA-->
                <form id="create-form-login" action="<?= $BASE_URL ?>auth_process.php" method="POST">
                
                <img src="<?= $BASE_URL ?>img/ipemetro.png" alt="IPEM" id="img-ipem-login">
    
                <h2 id="txt-form-login" >Sistema Único de Gestão</h2>
               <hr>
                    <!-- INPUT "ESCONDIDO" PARA ENVIAR O VALOR LOGIN PARA AUTH_PROCESS RECEBER VIA TYPE -->
                    <input type="hidden" name="type" value="login">                    
                    <div class="form-group">
                        <!-- CAMPO LOGIN TELA DE LOGIN -->
                        <label for="login">Login</label>
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <i class="fa fa-exclamation-circle" title="Digite seu login de rede" aria-hidden="true"></i>
                       

                        <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Digite seu login">
                    </div>
                    <div class="form-group">
                        <!-- CAMPO SENHA TELA DE LOGIN -->
                        <label for="password">Senha</label>
                        <i class="fa fa-key"  aria-hidden="true"></i>


                        <div id="psw">
                        <input type="password" class="form-control" id="inputPass" name="password" placeholder="Digite seu senha">
                        <i id="openeye" onclick="mostrarSenha()" class="fa fa-eye" aria-hidden="true"></i>
                        
                        </div>

                            

                    </div>
                    <!-- BOTÃO SUBMIT QUE ACIONA A AÇÃO DO FORM E JOGA PARA AUTH_PROCESS.PHP -->
                    <input type="submit" id="loginBtn" value="Entrar">
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="logo-sp">
                <img src="img/logo-sp.png">
                
            </div> -->
</div>

<?php endif; ?>
