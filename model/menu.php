
<?php

    
    class Menu{      //CRIAÇÃO DA CLASSE USUÁRIO E ATRIBUTOS
        public $id;
        public $menu;
        public $link;
        public $class;

    }

    //CRIAÇÃO DA INTERFACE QUE SERÁ IMPLEMENTADA ONDE CONVÉM
    interface MenuDAOInterface{
        public function getMenusByUserLogin($id); // LISTA OS MENUS QUE O USUÁRIO TEM ACESSO
        public function buildMenu($data); // INSTANCIA UM OBJETO MENU COM OS ATRIBUTOS RESGATADOS NO MÉTODO EM QUE FOR CHAMADO
        public function listMenus(); // MÉTODO QUE LISTA TODOS OS MENUS DO SISTEMA
        // public function listMenus2($name); // MÉTODO QUE LISTA OS MENUS EM QUE O USUÁRIO LOGADO FOR ADM, UTILIZADO NA TELA DE ADICIONAR ACESSO AO MENU PARA OUTRO USUÁRIO     
    }

    

?>