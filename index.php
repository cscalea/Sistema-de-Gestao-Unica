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
<!-- Apenas preencher painel central para melhor visualização -->
  <?php for ($i = 0; $i < 4; $i++) : ?>
    <div class="box">
      <img src="img/logo-branco.png" style="width: 40px;">
      <p style="color: white;">seminário INOVAÇÃO - 2024</p>
      <hr style="background-color: white; margin-bottom: 5px;">
      <img src="img/site.png" style="width: 260px; margin-left: 24px; margin-top: 14px;">
      <div class="cardBox">
        <p>saiba mais</p>
      </div>
    </div>
  <?php endfor; ?>
<!-- Apenas preencher painel central para melhor visualização -->
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