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



<?php if (!isset($_SESSION['login']) || $_SESSION['login'] === "") : ?>
    <!-- CONTAINER PRINCIPAL DAS PÁGINAS - MAIN CONTAINER -->

    <div class="navbar-container">
        <nav>
          <a href="#">
            <img src="img/ipem.png" alt="hDC Host" class="logo" />
          </a>
          <ul class="navbar-items">
            <li>
              <a href="home.php">Home</a>
            </li>
            <li>
              <a href="<?php $BASE_URL ?>auth.php" class="default-btn">Entrar</a>
            </li>
          </ul>
        </nav>
      </div>
    <div id="main-container" class="container-fluid">

    
        <!--CLASSE GERAL ONDE DENTRO ESTARÁ O FORMULÁRIO DE LOGIN ??? 12 COLUNAS -->
        <div class="col-md-12">
            <!-- CLASSE ROW - LINHA - ONDE DENTRO ESTARÁ O FORMULÁRIO DE LOGIN ???-->
            <div class="row" id="auth-row">
                <!-- CONTAINER DO LOGIN FORM -->
                <div class="col-md-4">
                    <!-- TEXTO DE LOGAR EM CIMA DO FORM DE LOGIN -->

                    <!-- FORMULÁRIO DE LOGIN COM METHOD POST, ACTION QUE DIRECIONA-->
                   
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
    function alertaAcesso(){

    
                    alert('acessos de rede para acessar');
                    history.back()
                
    }
    </script>
<script>
        function verificarCapsLock(event) {
            var capsLockAtivado = event.getModifierState && event.getModifierState('CapsLock');
            var mensagemCapsLock = document.getElementById('mensagemCapsLock');

            if (capsLockAtivado) {
                mensagemCapsLock.style.display = 'block';
            } else {
                mensagemCapsLock.style.display = 'none';
            }
        }
    </script>