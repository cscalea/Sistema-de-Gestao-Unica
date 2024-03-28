<?php
require_once("model/user.php");
require_once("config/globals.php");

class UserDAO implements UserDAOInterface
{
    private $conn;
    private $url;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
    }


    public function AuthenticateUser($login, $password)
    {
        $ldap_server = "10.15.16.191";  //SET AND CONNECT LDAP
        $dominio = "ipem.sp";
        $user = $login;
        $ldap_porta = "389";
        $ldap_pass   = $password;
        $ldap_base_dn = "dc=ipem,dc=sp";
        $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server."); //CONEXÃO LDAP

        if ($ldapcon) {

            ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapcon, "$user@$dominio", $ldap_pass);
            // verify binding

            if ($ldapbind) { //SUCESSO NA CONEXÃO
                $_SESSION['login'] = $login;

                $filter = "(&(objectClass=user)(objectCategory=person)(sAMAccountName=$user))"; //CONFIGURAÇÃO PARA RESGATAR DADOS DO USUÁRIO LOGADO
                $attributes = array("cn", "mail", "scriptPath", "title", "department"); //ATRIBUTOS QUE SERÃO BUSCADOS NO AD PARA TRATATIVAS NO CÓDIGO
                $search_result = ldap_search($ldapcon, $ldap_base_dn, $filter, $attributes); //FUNÇÃO LDAP SEARCH COM PARÂMETROS DE CONEXÃO, FILTRO, ATRIBUTOS ETC

                $entry = ldap_first_entry($ldapcon, $search_result);

                $fullname = ldap_get_values($ldapcon, $entry, "cn")[0];
                $email = ldap_get_values($ldapcon, $entry, "mail")[0];
                $sp = ldap_get_values($ldapcon, $entry, "scriptPath")[0];
                $cargo = ldap_get_values($ldapcon, $entry, "title")[0];
                $setor = ldap_get_values($ldapcon, $entry, "department")[0];

                $token = bin2hex(random_bytes(16)); //GERA UM TOKEN 

                //SETA OS ATRIBUTOS NA SESSION DO USUÁRIO
                $_SESSION['auth_token'] = $token;
                $_SESSION['scriptPath'] = $sp;
                $_SESSION['mail'] = $email;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['cargo'] = $cargo;
                $_SESSION['setor'] = $setor;

                $this->updateUser($fullname, $email, $user, $setor);
                $this->setTokenInDatabase($token); //INSERE O TOKEN DO USUÁRIO NO BANCO, É EXCLUÍDO AO FAZER LOGOUT
                header('location: index.php');
            } else {
                $_SESSION['login'] = "";
?>
                <script>
                    alert('Usuário não encontrado no AD e/ou senha inválida');
                    history.back()
                </script>
<?php
            }
        }
    }


    //seta o token no BANCO para o usuário logado
    public function setTokenInDatabase($token)
    {
        $stmt = $this->conn->prepare("UPDATE users SET token = :token WHERE login = :login");
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":login", $_SESSION['login']);
        $stmt->execute();
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


    /* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */
    //FUNCTION PARA LISTAR OS USUÁRIOS DO BANCO
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
    /* ---------------------------------- AVALIAR PARA APAGAR ---------------------------------- */


    //FUNCTION QUE DIRECIONA O USUÁRIO PARA TELA DE LOGIN CASO NÃO EXISTA LOGIN NA SESSION
    public function verifyAuth($login)
    {
        if ($login = "" || $login == "" || $login === "") {
            header('location: auth.php');
        }
    }


    //NÃO ACESSA PÁGINA DE AUTORIZADOR CASO NÃO FOR ADMINISTRADOR
    public function redirectPermissionPage()
    {
        if ($_SESSION['userIsAdm'] != 1) {
            header('location: index.php');
        }
    }


    //Insere os dados do usuário que logar no BANCO, com base em seus dados buscados no AD
    public function updateUser($name, $email, $login, $setor)
    {
        $stmt1 = $this->conn->prepare("SELECT * FROM users WHERE login = :login");
        $stmt1->bindParam(":login", $login);
        $stmt1->fetchAll();
        $stmt1->execute();
        if ($stmt1->rowCount() < 1) {
            $stmt = $this->conn->prepare("INSERT INTO users (name, login, email, setor) VALUES (:name, :login, :email, :setor)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":login", $login);
            $stmt->bindParam(":setor", $setor);
            $stmt->execute();
        }
    }


    //FAZ LOGOUT
    public function logout()
    {
        $stmt = $this->conn->prepare("UPDATE users SET token = NULL WHERE login = :login");
        $stmt->bindParam(":login", $_SESSION['login']);
        $stmt->execute();
        session_destroy();
        header('location: auth.php');
    }
}
