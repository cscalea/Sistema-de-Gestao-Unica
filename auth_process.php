<?php

require_once("globals.php");
require_once("db.php");
require_once("dao/UserDAO.php");
require_once("model/message.php");
require_once("dao/PermissionsDAO.php");
$permissionDao = new PermissionsDAO($conn, $BASE_URL);

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);



//IDENTIFICA O QUE FOI ACIONADO NO ARQUIVO AUTH.PHP E GUARDA EM $TYPE
$type = filter_input(INPUT_POST, "type");
$login = filter_input(INPUT_POST, "login");
$password = filter_input(INPUT_POST, "password");
$name = filter_input(INPUT_POST, "name");
$email = filter_input(INPUT_POST, "email");



if ($type === "insertUser") {
    $stmt = $conn->prepare("INSERT INTO users (name, login, email) VALUES (:name, :login, :email)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":login", $_SESSION['login']);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $userDao->setUserNameToSession($_SESSION['login']);
    $userDao->setEmailUserToSession($_SESSION['login']);
    $userDao->setIdUserToSession($_SESSION['login']);
    $message->setMessage("Seja bem-vindo! ", "success", "index.php");
}

//SE $TYPE === ? REALIZA TAL AÇÃO
if ($type === "login") {

    //GUARDA NAS VARIÁVEIS $LOGIN E $PASSWORD OS VALORES DOS INPUTS DE AUTH.PHP POR MEIO DO MÉTODO POST

    if (!empty($login && $password)) {
        $userDao->AuthenticateUser($login, $password);

        if (!empty($_SESSION['login']) && $_SESSION['login'] != "") {
            $userDao->verifyUser($_SESSION['login']);
            $userDao->setUserNameToSession($_SESSION['login']);
            $userDao->setEmailUserToSession($_SESSION['login']);
            $userDao->setIdUserToSession($_SESSION['login']);
            $userAdm = $permissionDao->verifyIfUserHasAdm($_SESSION['userid']);
        }


        //SE NÃO ESTIVEREM PREENCHIDOS, MOSTRA A MENSAGEM ABAIXO
    } else {
        $message->setMessage("Preencha os campos LOGIN e SENHA.", "error", "auth.php");
    }
    //CHAMA O MÉTODO AUTHENTICATEUSER CASO OS CAMPOS LOGIN E SENHA ESTEJAM PREENCHIDOS
    //O MÉTODO VERIFICA SE ESTÁ NO AD O USUÁRIO E LOGA OU MOSTRA A MENSAGEM QUE NÃO EXISTE NO AD
}

if ($type === "updateUser") {
    $userDao->updateUser($name, $email, $_SESSION['login']);
    $userDao->setUserNameToSession($_SESSION['login']);
    $userDao->SetEmailUserToSession($_SESSION['login']);
    $message->setMessage("Dados alterados com sucesso", "success", "index.php");
}
