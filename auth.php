<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
?>

<!-- Header da tela de login - por enquanto, fixo -->
<div class="navbar-container">
    <nav>
        <!-- <a href="#">
            <img src="img/ipem.png" alt="hDC Host" class="logo" />
        </a> -->
        <ul class="navbar-items-right">
            <li>
                <a href="<?php $BASE_URL ?>auth.php" class="default-btn">Entrar</a>
            </li>
        </ul>
    </nav>
</div>

<?php if (!isset($_SESSION['login']) || $_SESSION['login'] === "") : ?>

    <!-- CONTAINER PRINCIPAL DAS PÁGINAS - MAIN CONTAINER -->
    <div id="main-container" class="container-fluid">
        <!--CLASSE GERAL ONDE DENTRO ESTARÁ O FORMULÁRIO DE LOGIN - 12 COLUNAS -->
        <div class="col-md-12">
            <!-- CLASSE ROW - LINHA - ONDE DENTRO ESTARÁ O FORMULÁRIO DE LOGIN -->
            <div class="row" id="auth-row">
                <!-- CONTAINER DO LOGIN FORM -->
                <div class="col-md-4">
                    <!-- FORMULÁRIO DE LOGIN COM METHOD POST, ACTION QUE DIRECIONA-->
                    <form id="create-form-login" action="<?= $BASE_URL ?>auth_process.php" method="POST" onsubmit="return validarCampo()">
                        <img src="<?= $BASE_URL ?>img/ipemetro.png" alt="IPEM" id="img-ipem-login">
                        <h2 id="txt-form-login">Sistema Único de Gestão</h2>
                        <hr>
                        <!-- INPUT "ESCONDIDO" PARA ENVIAR O VALOR LOGIN PARA AUTH_PROCESS RECEBER VIA TYPE -->
                        <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <!-- CAMPO LOGIN TELA DE LOGIN -->
                            <label for="login">Login</label>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <i class="fa fa-exclamation-circle" title="Digite seu login de rede" aria-hidden="true"></i>
                            <input type="text" required class="form-control" title="Preencha este campo" onkeyup="validarTexto(this)" id="inputLogin" name="login" placeholder="Digite seu login">
                        </div>
                        <div class="form-group">
                            <!-- CAMPO SENHA TELA DE LOGIN -->
                            <label for="password">Senha</label>
                            <i class="fa fa-key" aria-hidden="true"></i>
                            <div id="psw">
                                <input type="password" required class="form-control" onkeypress="verificarCapsLock(event)" id="inputPass" name="password" placeholder="Digite seu senha">
                                <i id="openeye" onclick="mostrarSenha()" class="fa fa-eye" aria-hidden="true"></i>
                            </div>
                            <div id="mensagemCapsLock" style="display: none; color: black; margin-left: 28px; margin-top: 10px;">Capslock ativado</div>
                        </div>
                        <input type="submit" id="loginBtn" value="Entrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    function validarTexto(input) {
        var regex = /^[a-zA-Z]*$/; // Expressão regular para aceitar apenas letras
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z]/g, ''); // Remove números do valor
            alert("Este campo aceita apenas letras.");
        }
    }
</script>

<script>
    function verificarCapsLock(event) { //INFORMA CAPSLOCK LIGADO NA TELA DE LOGIN PARA O USUÁRIO
        var capsLockAtivado = event.getModifierState && event.getModifierState('CapsLock');
        var mensagemCapsLock = document.getElementById('mensagemCapsLock');

        if (capsLockAtivado) {
            mensagemCapsLock.style.display = 'block';
        } else {
            mensagemCapsLock.style.display = 'none';
        }
    }
</script>