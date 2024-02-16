<?php
require_once("model/message.php");
require_once("model/user.php");
require_once("globals.php");

class UserDAO implements UserDAOInterface
{
    private $conn;
    private $url;
    private $message;
    //MÉTODO CONSTRUTOR DO USERDAO PARA INSTANCIAR O OBJETO EM OUTRAS CLASSES
    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    

    //FUNCTION DE AUTENTICAR O USUÁRIO NO AD, RECEBE VIA FORMULÁRIO POST LOGIN E SENHA DA TELA DE LOGIN
    public function AuthenticateUser($login, $password)
    {
        $ldap_server = "10.15.16.191";
        $dominio = "@ipem.sp"; //Dominio local ou global
        $user = $login . $dominio;
        $ldap_porta = "389";
        $ldap_pass   = $password;
        $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server.");
        if ($ldapcon) {

            // binding to ldap server
            //$ldapbind = ldap_bind($ldapconn, $user, $ldap_pass);

            $bind = ldap_bind($ldapcon, $user, $ldap_pass);

            // verify binding

            if ($bind) {
                //SE AS CREDENCIAIS FOREM VÁLIDAS, DIRECIONA PARA INDEX.PHP
                $_SESSION['login'] = $login;
                // $this->verifyUser($_SESSION['login']); //FIRST ACCESS ???


            } else {
                $_SESSION['login'] = "";
                $this->message->setMessage("Usuário não encontrado no AD / Senha inválida", "error", "auth.php");
                
            }
        }
    }

    
    //FUNCTION QUE SETA O ID DO USUÁRIO LOGADO PARA A SESSION
    public function setIdUserToSession($login)
    {
        $stmt = $this->conn->prepare("select u.id from users u 
          WHERE u.login = :login");
        $stmt->bindParam(":login", $login);
        $stmt->execute();
        $str = $stmt->fetch();

        $id = $str[0];
        $_SESSION['userid'] = $id;
    }

    public function setUserNameToSession($login)
    {
        $stmt = $this->conn->prepare("SELECT u.name FROM users u WHERE u.login = :login");
        $stmt->bindParam(":login", $login);
        $stmt->execute();
        $str = $stmt->fetch();

        $name = $str[0];
        $_SESSION['username'] = $name;
    }

    public function setEmailUserToSession($login)
    {
        $stmt = $this->conn->prepare("SELECT email FROM users WHERE login = :login");
        $stmt->bindParam(":login", $login);
        $stmt->execute();

        $str = $stmt->fetch();

        $email = $str[0];
        $_SESSION['useremail'] = $email;
    }

    public function verifyUser($login)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->bindParam(":login", $login);
        $stmt->execute();
        if ($stmt->rowCount() < 1) {
            $this->message->setMessage("Seja Bem-vindo. Este é seu primeiro acesso, conclua seu cadastro.", "success", "firstAccess.php");
        } 
        else {        
            $this->message->setMessage("Seja Bem-vindo.", "success", "index.php");
        }
    }

    //FUNCTION BUILDUSER, INSTANCIA O USUÁRIO E ATRIBUI OS DADOS RECEBIDOS VIA FORMULÁRIO POST AOS ATRIBUTOS DO OBJETO
    public function buildUser($data)
    {
        $user = new User();
        $user->id = $data["id"];
        $user->login = $data["login"];
        $user->name = $data["name"];
        $user->email = $data["email"];
        return $user;
    }

    //FUNCTION QUE LISTA OS USUÁRIOS - UTILIZADO NO MÓDULO DE ADICIONAR MÓDULO
    public function listUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login != :login ORDER BY name ASC");
        $stmt->bindParam(':login', $_SESSION['login']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $usersArray = $stmt->fetchAll();

            foreach ($usersArray as $user) {
                $users[] = $this->buildUser($user);
            }
        }
        return $users;
    }

    //FAZ LOGOUT
    public function logout()
    {
        session_destroy();
        $this->message->setMessage("Logout realizado com sucesso", "success", "auth.php");
    }

    //FUNCTION QUE DIRECIONA O USUÁRIO PARA TELA DE LOGIN CASO NÃO EXISTA LOGIN NA SESSION
    public function verifyAuth($login)
    {
        if ($login = "" || $login == "" || $login === "") {
            $this->message->setMessage("Faça LOGIN no sistema para acessar a página.", "error", "auth.php");
        }
    }

    public function redirectPermissionPage()
    {
        if ($_SESSION['userIsAdm'] != 1) {
            $this->message->setMessage("Você não tem permissão para acessar a página.", "error", "index.php");
        }
    }

    public function updateUser($name, $email, $login)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = :name, email = :email where login = :login");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":login", $login);
        $stmt->execute();

       
    }
}
