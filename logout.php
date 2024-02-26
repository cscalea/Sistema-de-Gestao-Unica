<?php
    require_once("dao/UserDAO.php");
    require_once("config/globals.php");
    require_once("config/db.php");
    $userDao = new UserDAO($conn, $BASE_URL);
    $userDao->logout();      
?>


<!-- <p> Acesso rápido</p>
  <div id="acesso-rapido">
    
   
      <div class="cards">
        <a href="http://10.15.16.213"><p>Ouvidoria</p></a>
        
      </div>
      <div class="cards">
        <a href="http://10.15.16.211/antivirus/"><p>Monitoramento de Segurança</p></a>
        
      </div>
      <div class="cards">
      <a href="<?php $BASE_URL ?>addPermission.php"><p>Autorizador</p></a>
        
      </div>
      
       </div> -->
   