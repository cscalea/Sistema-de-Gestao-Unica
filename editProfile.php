<?php
require_once("templates/header.php");
?>


<div id="main-container" class="container-fluid">
   
    <form id="create-form-edit" action="<?= $BASE_URL ?>auth_process.php" method="POST">
        <input type="hidden" name="type" value="updateUser">

        <br>
        <div class="form-group">
            <h1>Editar perfil:</h1>
            <hr>
            <label for="name">Nome:</label>
            <input type="text" id="inputName" name="name" value="<?php echo $_SESSION['username'] ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="inputEmail" name="email" value="<?php echo $_SESSION['useremail'] ?>">
        </div>

        <div class="form-group">
            <label for="Telefone">Telefone:</label>
            <input type="Telefone" id="inputTelefone" name="Telefone" value="(11)96063-5323">
        </div>
        <div class="form-group">
            <label for="setor">Setor:</label>
            <input type="Telefone" id="inputSetor" name="setor" value="setor">

        </div>
        <button type="submit" class="card-btn">Alterar</button>

</form>
</div>
</div>


<?php
require_once("templates/footer.php");
?>