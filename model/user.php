
<?php
   
    class User{      //CRIAÇÃO DA CLASSE USUÁRIO E ATRIBUTOS
        public $id;
        public $name;
        public $login;
        public $email;
    }

    //CRIAÇÃO DA INTERFACE QUE SERÁ IMPLEMENTADA ONDE CONVÉM
    interface UserDAOInterface{

        public function AuthenticateUser($login, $password); // MÉTODO QUE RECEBE LOGIN E SENHA DO USUÁRIO E AUTENTICA NO AD PARA LIBERAR OU NÃO ACESSO AO SISTEMA

        public function verifyAuth($login); //IMPEDE QUE O USUÁRIO ACESSE UMA TELA DIRETAMENTE PELA URL SEM TER LOGADO NO SISTEMA

        //Chamar os 3 métodos abaixo em AuthenticateUser
        public function setIdUserToSession($login); // ESTE MÉTODO DEFINE O ID DO USUÁRIO LOGADO PARA A VARIÁVEL GLOBAL $_SESSION['USERID'];
        public function setUserNameToSession($login); //MÉTODO QUE DEFINE O NOME DO USUÁRIO PARA A VARIÁVEL GLOBAL $_SESSION[username];
        public function setEmailUserToSession($login); //MÉTODO PARA PEGAR O EMAIL DO USUÁRIO E SETAR O MESMO PARA A VARIÁVEL GLOBAL $_SESSION['email'];
        public function listUsers(); // FUNÇÃO QUE LISTA OS USUÁRIOS NA TELA DE ADICIONAR OU REMOVER ACESSOS AOS MÓDULOS PARA UM USUÁRIO
        public function buildUser($data); // FUNÇÃO QUE INSTANCIA O OBJETO USUÁRIO COM OS ATRIBUTOS RESGATADOS NA FUNÇÃO QUE O MESMO É CHAMADO        
        public function verifyUser($login); //VERIFICA SE É O PRIMEIRO ACESSO DO USUÁRIO PARA DIRECIONAR PARA A TELA DE CONCLUSÃO DE CADASTRO
        public function redirectPermissionPage(); // MÉTODO QUE DIRECIONA O USUÁRIO PARA A HOME CASO O MESMO TENTE ACESSAR A TELA DE ADICIONAR MENUS DIRETAMENTE PELA URL       
        public function logout(); // MÉTODO PARA FAZER O LOGOUT E DESTRUIR A SESSION
        public function updateUser($name, $email, $login); // MÉTODO PARA ALTERAR DADOS DO USUÁRIO                
    }
?>