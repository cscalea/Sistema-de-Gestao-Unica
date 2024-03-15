<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/PermissionsDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
$userDao->verifyAuth($_SESSION['login']);
$userid = $userDao->setIdUserToSession($_SESSION['login']);
$permission = new PermissionsDAO($conn, $BASE_URL);
?>




<div class="container">

<?php for($i = 0; $i<4; $i++):?>
  <div class="box">
    <img src="img/logo-branco.png" style="width: 40px;">
    <p style="color: white;">seminário INOVAÇÃO - 2024</p>
    <hr style="background-color: white; margin-bottom: 5px;">
  <img src="img/site.png" style="width: 350px; margin-left: -20px;">
    <div class="cardBox">
      <p>saiba mais</p>
    </div>
      
  </div>
  <?php endfor; ?>

</div>

<!-- <h4 id="txtgame"> <?php echo rand(1, 500); ?> </h4> -->




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