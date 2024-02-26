<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/PermissionsDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
$userDao->verifyAuth($_SESSION['login']);
$userid = $userDao->setIdUserToSession($_SESSION['login']);
$permission = new PermissionsDAO($conn, $BASE_URL);
?>

<!-- image -->

<div id="main-container" class="container-fluid">
  <div id="topoindex">
    <img id="imagem" src="img/IPEM2.png" alt="IPEM">
    <p>Instituto de Pesos e Medidas do Estado de São Paulo</p>
  </div>

  <hr>

  <div class="offset-md-1 col-md-10">
    <div id="painel">


      <h5 id="h5index">Seja Bem-Vindo(a) - <?php echo ($_SESSION['cn']) ?></h5>




<div style="font-size: 12px; color: blue; text-align: center"id="oi">
      <?php
      echo '<hr>';
      echo 'Dados do AD:'; 
      echo '<br>';
      echo 'Login - '. $_SESSION['login'];
      echo '<br>';
      echo 'email - ' . $_SESSION['mail'];
      echo '<br>';
      echo 'Nome Completo - ' . $_SESSION['cn']; 
      echo '<br>';
      // echo 'Usuário é ADM [1]sim [0]não - ' . $_SESSION['userIsAdm'];
      // echo '<br>';
     echo  'Login VBS: '. $_SESSION['scriptPath'];
     echo '<br>';
     echo  'Cargo: '. $_SESSION['dp'];
     echo '<br>';
     echo  'Setor: '. $_SESSION['cp'];
     echo '<br>';
     echo 'ID do usuário: ' . $_SESSION['uid'];
      ?>
</div>

      <hr>

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

    </div>
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