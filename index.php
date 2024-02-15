<?php
require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("dao/PermissionsDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
$userDao->verifyAuth($_SESSION['login']);
// $userid = $userDao->setIdUserToSession($_SESSION['login']);
$permission = new PermissionsDAO($conn, $BASE_URL);


?>

<!-- image -->
<div id="main-container" class="container-fluid">
<div id="topoindex">
<img id="imagem" src="img/IPEM2.png" alt="IPEM"><p>Instituto de Pesos e Medidas do Estado de São Paulo</p>
</div>
  
    <hr>
    
    <h5 id="h5index">Seja Bem-Vindo - <?php echo ($_SESSION['username']) ?></h5>
    
  

    

  <?php
  
   echo '<hr>';
  echo 'Dados para fins de testes';
  echo '<hr>';
  echo '<br>';
  echo '<br>';
echo '$_SESSION Login: ' . $_SESSION['login'];
echo '<br>';
echo '$_SESSION Nome: ' . $_SESSION['username'];
echo '<br>';
echo '$_SESSION E-mail: ' . $_SESSION['useremail'];
echo '<br>';
echo '$_SESSION ID do usuário: ' . $_SESSION['userid'];
echo '<br>';
echo '$_SESSION Usuário é Administrador - [1]sim [0]não: ' . $_SESSION['userIsAdm'];


    ?>
    
  
<hr>

  
</div>
</div>


<?php
require_once("templates/footer.php");
?>