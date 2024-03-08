<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/PermissionsDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
$userDao->verifyAuth($_SESSION['login']);
$userid = $userDao->setIdUserToSession($_SESSION['login']);
$permission = new PermissionsDAO($conn, $BASE_URL);
?>

<div id="main-container" class="container-fluid">
  <div class="col-md-12">
    <h5 id="h5index">Seja Bem-Vindo(a) - <?php echo ($_SESSION['fullname']) ?></h5>
    <div style="font-size: 12px; color: green; text-align: left" id="oi">
      <?php
      // echo '<hr>';
      echo 'Dados do AD:';
      echo '<br>';
      echo 'Login - ' . $_SESSION['login'];
      echo '<br>';
      echo 'email - ' . $_SESSION['mail'];
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
      echo 'Dados do user: ' . $_SESSION['uid'];
      echo '<br>';
      echo 'token para autenticar em outros sistemas: ' . $_SESSION['auth_token']
      ?>
    </div>
    <hr>

    <button id="btnEnviarToken">Enviar Token</button>

    <script>
        document.getElementById("btnEnviarToken").addEventListener("click", function() {
            // Token do usuário que está armazenado na variável global $_SESSION['token']
            var token = "<?php echo isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : ''; ?>";

            // URL do sistema de destino
            var urlDestino = "../pretty/index.php?token=" + encodeURIComponent(token);

            // Redirecionar para a nova URL com o token como parâmetro GET
            window.location.href = urlDestino;
        });
    </script>



    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2>Centro de Desenvolvimento</h2>
          <h5>Informações / gráficos sobre as atividades do setor</h5>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-12">
          <h2>Centro de Suporte</h2>
          <h5>Informações / gráficos sobre as atividades do setor</h5>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-12">
          <h2>Centro de Infraestrutura de TI</h2>
          <h5>Informações / gráficos sobre as atividades do setor</h5>
        </div>
      </div>
    </div>
    <!-- </div> -->
  </div>
  <!-- <div class="container">
  <div class="row">
      <div class="col-4">
    <h1>IPEM</h1>
    <img style="width: 120px" src="<?= $BASE_URL ?>img/ipem-azul.png">
      </div>
      <div class="col-4">
      <h1>IPEM</h1>
      <img style="width: 120px" src="<?= $BASE_URL ?>img/ipem-azul.png">
      </div>
      <div class="col-4">
      <h1>IPEM</h1>
      <img style="width: 120px" src="<?= $BASE_URL ?>img/ipem-azul.png">
      </div>
  </div>
  <hr>
  <div class="row">
      <div class="col-4">
    <h1>IPEM</h1>
    <img style="width: 120px" src="<?= $BASE_URL ?>img/ipem-azul.png">
      </div>
      <div class="col-4">
      <h1>IPEM</h1>
      <img style="width: 120px" src="<?= $BASE_URL ?>img/ipem-azul.png">
      </div>
      <div class="col-4">
      <h1>IPEM</h1>
      <img style="width: 120px" src="<?= $BASE_URL ?>img/ipem-azul.png">
      </div>
  </div> 
</div> -->
</div>
</div>
<?php
require_once("templates/footer.php");
?>




<?php
// if (isset($_GET['token'])) {
//     // Receber o token enviado via GET
//     $tokenRecebido = $_GET['token'];
//     $stmt = $conn->prepare("SELECT * FROM users WHERE token = :token");
// $stmt->bindParam(":token", $tokenRecebido);
// $stmt->execute();
// if($stmt->rowCount() > 0){
//   echo "Token válido. Usuário autenticado!";
// }

        
//      else {
//       echo "Token inválido. Acesso negado!";
//     }
// } else {
//     echo "Token não recebido.";
// }
?>