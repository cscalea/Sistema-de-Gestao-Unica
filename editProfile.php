<?php
require_once("templates/header.php");
?>


<div id="main-container" class="container-fluid">
   
    <form id="create-form-edit" action="<?= $BASE_URL ?>auth_process.php" method="POST">
        <input type="hidden" name="type" value="updateUser">

        <br>
        <div class="form-group">
            <h1><a href="<?=$BASE_URL?>index.php"><i id="backHomeIcon"class="fa fa-home"></i></a>Dados de <?php echo $_SESSION['nome'] ?></h1>
            <hr>
            <label for="name">Nome:</label>
            <input type="text"  disabled required  title="Digite um nome válido" pattern="[A-Za-z, ]+" id="inputName" name="name" value="<?php echo $_SESSION['fullname'] ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email"  disabled required id="inputEmail" name="email" value="<?php echo $_SESSION['mail'] ?>">
        </div>
        
        <div class="form-group">
            <label for="setor">Setor:</label>
            <input type="Setor" disabled required pattern="[A-Za-z, ]+" title="Digite um setor válido" id="inputSetor" name="setor" value="<?php echo $_SESSION['setor'] ?>">

        </div>
        <div class="form-group">
            <label for="cargo">Cargo:</label>
            <input type="cargo" disabled required pattern="[A-Za-z, ]+" title="Digite um cargo válido" id="inputcargo" name="cargo" value=" <?php echo $_SESSION['cargo'] ?>">
        </div>
        <div class="form-group">
            <label for="matricula">matricula:</label>
            <input type="matricula" disabled required pattern="[A-Za-z, ]+" title="Digite um matricula válido" id="inputmatricula" name="matricula" value=" ts">
        </div>

        <!-- <button type="submit" class="card-btn">Alterar</button> -->

</form>
</div>
</div>


<?php
require_once("templates/footer.php");
?>