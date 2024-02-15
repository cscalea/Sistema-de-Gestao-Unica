<?php
/* IMPORTS */
require_once("templates/header.php"); // PARA IMPORTAR O MENU
require_once("dao/UserDAO.php"); // PARA INSTANCIAR UM OBJETO USUÁRIO DAO (DATA ACCESS OBJECT) E INSTANCIAR SEUS MÉTODOS 
require_once("dao/MenuDAO.php");
require_once("model/message.php");

$message = new Message($BASE_URL);
if(isset($_SESSION['userIsAdm']) && $_SESSION['userIsAdm'] == 0){
    $message->setMessage("Você não tem permissão para acessar essa página.", "error", "index.php");
} 
/* INSTANCIAÇÃO DOS OBJETOS User e Menu, para podermos fazer a utilização dos métodos dessas classes */
$userDao = new UserDAO($conn, $BASE_URL);
$menuDao = new MenuDAO($conn, $BASE_URL);

/* MÉTODO DE VERIFICAÇÃO DE AUTENTICAÇÃO - IMPEDE QUE O USUÁRIO ACESSE A PÁGINA DIRETAMENTE PELA URL SEM LOGAR */
$userDao->verifyAuth($_SESSION['login']);
$userDao->redirectPermissionPage();
/* METODOS QUE LISTAM OS MENUS E OS USERS CONFORME PERMISSÃO PARA O USUÁRIO ADMINISTRADOR DO MÓDULO ADICIONAR OU REMOVER ACESSO DO FUNCIONÁRIO */
$arrayUsers = $userDao->listUsers();

/* MÉTODO PARA LISTAR APENAS OS MENUS EM QUE O USUÁRIO LOGADO É ADMINISTRADOR, PARA REMOVER OU ADICIONAR ACESSO DO FUNCIONÁRIO */
$arrayMenus2 = $menuDao->listMenus2($_SESSION['login']);
?>

<div id="main-container" class="container-fluid">
    <div id="back-home">
<a href="<?php $BASE_URL?>index.php"><i class="fa fa-home"></i></a>
</div>
    <h1 id="main-title">Alterar Permissões </h1>
    <hr>
    <h1> <?php $_SESSION['login']; ?> </h1>
    <form id="create-form" action="<?= $BASE_URL ?>addPermission_process.php" method="POST">
        <input type="hidden" name="type" value="create">
        <h2>Adicionar acesso</h2>
        <div class="form-group">
            <label for="user">Usuário:</label>
            <select name="fk_idusers" id="listUser">
                <option>Selecione o usuário</option>
                <?php foreach ($arrayUsers as $user) : ?>

                    <option value="<?php echo $user->id ?>"><?php echo $user->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="modulo">Menu:</label>
            <select name="fk_idmenus" id="listMenu">
            <option>Selecione o menu</option>
                <?php foreach ($arrayMenus2 as $menu) : ?>
                    <option value="<?php echo $menu->id ?>"><?php echo $menu->menu?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="adm">Nível de acesso:</label>
            <select name="adm" id="listAdm">
            <option value="0">Não é administrador</option>
            <option value="1">É administrador</option>
                
            </select>
        </div>
        <button type="submit" id="btnCadastro" class="card-btn">Adicionar</button>
    </form>
    <hr>         
    <form id="create-form" action="<?= $BASE_URL ?>addPermission_process.php" method="POST">
        <input type="hidden" name="type" value="delete">
        <h2>Remover acesso</h2>
        <div class="form-group">
            <label for="user">Usuário:</label>
            <select name="fk_idusers" id="listUser">
            <option>Selecione o usuário</option>
                <?php foreach ($arrayUsers as $user) : ?>
                    <option value="<?php echo $user->id ?>"><?php echo $user->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="modulo">Menu:</label>
            <select class="meuselect" name="fk_idmenus" id="listMenu">
            <option>Selecione o menu</option>
                <?php foreach ($arrayMenus2 as $menu) : ?>
                    <option value="<?php echo $menu->id ?>"><?php echo $menu->menu ?></option>
                    <?php $_SESSION['idmenu'] = $menu->id; ?>
                <?php endforeach; ?>
            </select>
           
        </div>

        

        <button type="submit" id="btnCadastro" class="card-btn">Remover</button>
    </form>
</div>


<?php
require_once("templates/footer.php");
?>