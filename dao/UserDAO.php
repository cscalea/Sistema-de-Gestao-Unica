<?php
require_once("model/message.php");
require_once("model/user.php");
require_once("config/globals.php");

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
        $dominio = "ipem.sp"; //Dominio local ou global
        $user = $login;
        $ldap_porta = "389";
        $ldap_pass   = $password;
        $ldap_base_dn = "dc=ipem,dc=sp";
        $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server.");

        if ($ldapcon) {

            ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapcon, "$user@$dominio", $_POST['password']);

            // verify binding

            if ($ldapbind) {
                //SE AS CREDENCIAIS FOREM VÁLIDAS, DIRECIONA PARA INDEX.PHP
                $_SESSION['login'] = $login;
                // $this->verifyUser($_SESSION['login']); //FIRST ACCESS ???
                $filter = "(&(objectClass=user)(objectCategory=person)(sAMAccountName=$user))";
                $attributes = array("cn", "mail", "scriptPath", "title", "department", "distinguishedname");
                $search_result = ldap_search($ldapcon, $ldap_base_dn, $filter, $attributes);
                $entry = ldap_first_entry($ldapcon, $search_result);
                $fullname = ldap_get_values($ldapcon, $entry, "cn")[0];
                $email = ldap_get_values($ldapcon, $entry, "mail")[0];
                $sp = ldap_get_values($ldapcon, $entry, "scriptPath")[0];
                $cargo = ldap_get_values($ldapcon, $entry, "title")[0];
                $dpto = ldap_get_values($ldapcon, $entry, "department")[0];
                $uid = ldap_get_values($ldapcon, $entry, "distinguishedname")[0];

                $_SESSION['scriptPath'] = $sp;
                $_SESSION['mail'] = $email;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['cargo'] = $cargo;
                $_SESSION['dpto'] = $dpto;
                $_SESSION['uid'] = $uid;
                $this->updateUser($fullname, $email, $user);
                header('location: index.php');
            } else {
                $_SESSION['login'] = "";
                // $this->message->setMessage("Usuário não encontrado no AD / Senha inválida", "error", "auth.php");
?>
                <script>
                    alert('Usuário não encontrado no AD e/ou senha inválida');
                    history.back()
                </script>
<?php

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
        $stmt1 = $this->conn->prepare("SELECT * FROM users WHERE login = :login");
        $stmt1->bindParam(":login", $login);
        $stmt1->fetchAll();
        $stmt1->execute();
        if ($stmt1->rowCount() < 1) {


            $stmt = $this->conn->prepare("INSERT INTO users (name, login, email) VALUES (:name, :login, :email)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":login", $login);
            $stmt->execute();
        }
    }

     //FAZ LOGOUT
     public function logout()
     {
         session_destroy();
         $this->message->setMessage("Logout realizado com sucesso", "success", "auth.php");
     }
}
