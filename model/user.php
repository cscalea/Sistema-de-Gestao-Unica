
<?php
   
    class User{      //CRIAÇÃO DA CLASSE USUÁRIO E ATRIBUTOS
        public $id;
        public $name;
        public $login;
        public $email;
        public $setor;
    }

    //CRIAÇÃO DA INTERFACE QUE SERÁ IMPLEMENTADA ONDE CONVÉM
    interface UserDAOInterface{
        public function AuthenticateUser($login, $password); // MÉTODO QUE RECEBE LOGIN E SENHA DO USUÁRIO E AUTENTICA NO AD PARA LIBERAR OU NÃO ACESSO AO SISTEMA
        public function verifyAuth($login); //IMPEDE QUE O USUÁRIO ACESSE UMA TELA DIRETAMENTE PELA URL SEM TER LOGADO NO SISTEMA
        public function setTokenInDatabase($token);
        public function listUsers(); // FUNÇÃO QUE LISTA OS USUÁRIOS NA TELA DE ADICIONAR OU REMOVER ACESSOS AOS MÓDULOS PARA UM USUÁRIO
        public function buildUser($data); // FUNÇÃO QUE INSTANCIA O OBJETO USUÁRIO COM OS ATRIBUTOS RESGATADOS NA FUNÇÃO QUE O MESMO É CHAMADO        
        public function redirectPermissionPage(); // MÉTODO QUE DIRECIONA O USUÁRIO PARA A HOME CASO O MESMO TENTE ACESSAR A TELA DE ADICIONAR MENUS DIRETAMENTE PELA URL       
        public function logout(); // MÉTODO PARA FAZER O LOGOUT E DESTRUIR A SESSION
        public function updateUser($name, $email, $login, $setor); // MÉTODO PARA ALTERAR DADOS DO USUÁRIO  
    }
?>