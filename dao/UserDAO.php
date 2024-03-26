<?php
require_once("model/message.php");
require_once("model/user.php");
require_once("config/globals.php");
require_once("config/ldapConfig.php");
require_once("ldap.php");


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
    public function AuthenticateUser($login, $password) //CONFIGURAÇÃO CONEXÃO LDAP
    {
        $ldap_server = "10.15.16.191";
        $dominio = "ipem.sp"; //Dominio local ou global
        $user = $login;
        $ldap_porta = "389";
        $ldap_pass   = $password;
        $ldap_base_dn = "dc=ipem,dc=sp";
        $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server."); //CONEXÃO LDAP

        if ($ldapcon) {

            ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapcon, "$user@$dominio", $_POST['password']);

            // verify binding

            if ($ldapbind) { //SUCESSO NA CONEXÃO
                $_SESSION['login'] = $login;
                // $this->verifyUser($_SESSION['login']); //FIRST ACCESS ???
                $filter = "(&(objectClass=user)(objectCategory=person)(sAMAccountName=$user))"; //CONFIGURAÇÃO PARA RESGATAR DADOS DO USUÁRIO LOGADO
                $attributes = array("cn", "mail", "scriptPath", "title", "department", "distinguishedname");
                $search_result = ldap_search($ldapcon, $ldap_base_dn, $filter, $attributes);
                $entry = ldap_first_entry($ldapcon, $search_result);
                $fullname = ldap_get_values($ldapcon, $entry, "cn")[0];
                $email = ldap_get_values($ldapcon, $entry, "mail")[0];
                $sp = ldap_get_values($ldapcon, $entry, "scriptPath")[0];
                $cargo = ldap_get_values($ldapcon, $entry, "title")[0];
                $dpto = ldap_get_values($ldapcon, $entry, "department")[0];
                $uid = ldap_get_values($ldapcon, $entry, "distinguishedname")[0];

                $token = bin2hex(random_bytes(16)); //GERA UM TOKEN 
                $_SESSION['auth_token'] = $token; //TOKEN ADICIONADO NA SESSION DO USUÁRIO
                $_SESSION['scriptPath'] = $sp; //SETA OS DADOS DO USUÁRIO LOGADO NA GLOBAL SESSION
                $_SESSION['mail'] = $email;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['cargo'] = $cargo;
                $_SESSION['dpto'] = $dpto;
                $_SESSION['uid'] = $uid;
                $this->updateUser($fullname, $email, $user);
                $this->setTokenToSession(); //INSERE O TOKEN DO USUÁRIO NO BANCO, É EXCLUÍDO AO FAZER LOGOUT
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

    //seta o token do usuário para a global session
    public function setTokenToSession()
    {
        $token = bin2hex(random_bytes(16));
        $_SESSION['auth_token'] = $token;
        $stmt = $this->conn->prepare("UPDATE users SET token = :token WHERE login = :login");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":login", $_SESSION['login']);
        $stmt->execute();
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
        $user->setor = $data["setor"];
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

    public function allUsersFromAd()
    {
        $ldap_server = "10.15.16.191";
        $dominio = "ipem.sp"; //Dominio local ou global
        $user = "casjunior";
        $ldap_porta = "389";
        $ldap_pass   = "King@2134";
        $ldap_base_dn = "dc=ipem,dc=sp";
        $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server."); //CONEXÃO LDAP

        if ($ldapcon) {

            ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapcon, "$user@$dominio", $ldap_pass);

            // verify binding

            if ($ldapbind) { //SUCESSO NA CONEXÃO
                // $this->verifyUser($_SESSION['login']); //FIRST ACCESS ???
                $filter = "(objectClass=user)"; //CONFIGURAÇÃO PARA RESGATAR DADOS DO USUÁRIO LOGADO
                $attributes = array("cn", "samaccountname", "mail", "department");
                $search_result = ldap_search($ldapcon, $ldap_base_dn, $filter, $attributes);
                $entry = ldap_first_entry($ldapcon, $search_result);
                $ldap_entries = ldap_get_entries($ldapcon, $search_result);
            }
            $usuarios = array();

            // Iterar pelos resultados e adicionar os usuários ao array
            $i = 0;
            foreach ($ldap_entries as $entry) {

                $usuario = array(
                    "nome_completo" => $entry["cn"][0],
                    "login" => $entry["samaccountname"][0],
                    "email" => $entry["mail"][0],
                    "setor" => $entry["department"][0]
                );
                $usuarios[] = $usuario;
            }
            foreach($usuarios as $usuarios){
                $name = $usuario['nome_completo'];
                $login = $usuario['login'];
                $email = $usuario['email'];
                $setor = $usuario['setor'];
                if(!isset($setor)){
                    $setor = "não tem";
                }
                if(!isset($email)){
                    $email = "não tem";
                }
                $stmt1 = $this->conn->prepare("SELECT * FROM users WHERE login = :login");
                $stmt1->bindParam(":login", $login);
                $stmt1->fetchAll();
                $stmt1->execute();
                if ($stmt1->rowCount() < 1) {
                    $stmt = $this->conn->prepare("INSERT into users (name, login, email, setor) VALUES (:name, :login, :email, :setor");
                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":login", $login);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":setor", $setor);
                    $stmt->fetchAll();
                    $stmt->execute();
                }
            }
                
            

            // Exibir o array de usuários


        }
    }

    //FAZ LOGOUT
    public function logout()
    {
        $stmt = $this->conn->prepare("UPDATE users SET token = NULL WHERE login = :login");
        $stmt->bindParam(":login", $_SESSION['login']);
        $stmt->execute();
        session_destroy();

        $this->message->setMessage("Logout realizado com sucesso", "success", "auth.php");
    }
}
