<?php

    
    class Permissions{      //CRIAÇÃO DA CLASSE USUÁRIO E ATRIBUTOS
        public $id;
        public $fk_iduser;
        public $fk_idmenu;
        public $adm;
        
    }

    //CRIAÇÃO DA INTERFACE QUE SERÁ IMPLEMENTADA ONDE CONVÉM
    interface PermissionDAOInterface{
        public function buildPermission($data); // INSTANCIA UM OBJETO PERMISSION COM OS ATRIBUTOS RESGATADOS NO METODO EM QUE É UTILIZADO
        public function insertPermission(Permissions $permission); // MÉTODO QUE INSERE O ACESSO A UM MENU PARA O USUÁRIO
        public function deletePermission($fk_iduser, $fk_idmenu); // MÉTODO QUE REMOVE O ACESSO DO USUÁRIO AO MENU SELECIONADO
        public function verifyMenu($fk_idusers, $fk_idmenus); // VERIFICA SE O USUÁRIO JÁ POSSUI O MENU, PARA CONTROLAR AÇÃO DE ADICIONAR OU REMOVER MENU AO USUÁRIO SELECIONADO
        public function verifyIfUserHasAdm($fk_idusers); //ESSA FUNÇÃO VERIFICA SE O USUÁRIO É ADMINISTRADOR EM ALGUM MÓDULO      
    }

    

?>