<?php
require_once("model/message.php");
require_once("model/user.php");
require_once("model/menu.php");
require_once("globals.php");

class MenuDAO implements MenuDAOInterface
{
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }


    public function getMenusByUserLogin($login)
    {
        $menus = [];
        $stmt = $this->conn->prepare("select m.id, m.menu, m.link, u.name from menus m 
            INNER JOIN permissions p
            on m.id = p.fk_idmenus
            INNER JOIN users u
            on p.fk_idusers = u.id            
            WHERE u.login = :login ORDER BY m.menu ASC");
        $stmt->bindParam(":login", $login);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $menusArray = $stmt->fetchAll();
            foreach ($menusArray as $menu) {
                $menus[] = $this->buildMenu($menu);
            }
        }
        return $menus;
    }

    //FUNCTION QUE INSTANCIA UM OBJETO E ATRIBUI OS DADOS AO OBJETO INSTANCIADO
    //EXEMPLO, SELECT NO BANCO DA FUNCTION LISTMENUS2 CRIA UM ARRAY ATRAVÉS DO fetchAll(), e chama a function Build que pega cada um desses valores e instancia o objeto MENU
    public function buildMenu($data)
    {
        $menu = new Menu();
        $menu->id = $data["id"];
        $menu->menu = $data["menu"];
        $menu->link = $data["link"];
        $menu->class = $data["class"];
        return $menu;
    }


    //FUNCTION QUE LISTA TODOS OS MENUS DO SISTEMA
    public function listMenus()
    {
        $stmt = $this->conn->prepare("SELECT * FROM menus");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $menusArray = $stmt->fetchAll();
            foreach ($menusArray as $menu) {
                $menus[] = $this->buildMenu($menu);
            }
        }
        return $menus;
    }


    //FUNCTION QUE LISTA TODOS OS MENUS DO SISTEMA SE O USUÁRIO FOR ADM
    public function listMenus2($login)
    {
        $stmt = $this->conn->prepare(" SELECT m.menu, m.id, m.link, m.class FROM menus m 
        INNER JOIN permissions p 
        ON m.id = p.fk_idmenus
        INNER JOIN users u
        ON p.fk_idusers = u.id
        WHERE p.adm = 1 AND u.login = :login AND m.menu != 'autorizador';");
        $stmt->bindParam(":login", $login);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $menusArray = $stmt->fetchAll();
            foreach ($menusArray as $menu) {
                $menus[] = $this->buildMenu($menu);
            }
        }
        return $menus;
    }


    //FUNCTION QUE LISTA OS MENUS QUE O USUÁRIO JÁ POSSUI NA COMBOBOX DE REMOVER MENUS DO ACESSO DO USUÁRIO
    //     public function listMenusRemove($fk_idusers)
    //     {
    //         $stmt = $this->conn->prepare("SELECT m.menu, m.id FROM menus m
    //         INNER JOIN permissions p
    //         on m.id = p.fk_idmenus
    //         where p.fk_idusers = :fk_idusers");
    //         $stmt->bindParam(":fk_idusers", $fk_idusers);
    //         $stmt->execute();
    //         if($stmt->rowCount() > 0) {
    //             $arrayRemove = $stmt->fetchAll();
    //             foreach($arrayRemove as $menu) {
    //               $menus[] = $this->buildMenu($menu);
    //             }   
    //           return $menus;
    //     }    
    // }
}
