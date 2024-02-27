<?php
require_once("model/permissions.php");
require_once("model/message.php");


class PermissionsDAO implements PermissionDAOInterface
{
    private $conn;
    private $url;
    private $message;
    //MÉTODO CONSTRUTOR DO OBJETO PERMISSIONS PARA PODER INSTANCIA-LO EM OUTRAS CLASSES
    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    //FUNCTION BUILDUSER, INSTANCIA A PERMISSION E ATRIBUI OS DADOS RECEBIDOS AOS ATRIBUTOS DO OBJETO
    public function buildPermission($data)
    {
        $permissions = new Permissions();

        $permissions->fk_iduser = $data["fk_idusers"];
        $permissions->fk_idmenu = $data["fk_idmenus"];
        $permissions->adm = $data["adm"];
    }
    //FUNCTION COM INSERT PARA ADICIONAR PERMISSÃO AO PERFIL DO USUÁRIO
    public function insertPermission(Permissions $permission)
    {
        $stmt = $this->conn->prepare("INSERT INTO permissions(fk_idusers, fk_idmenus, adm) VALUES (:fk_idusers, :fk_idmenus, :adm)");
        $stmt->bindParam(":fk_idusers", $permission->fk_iduser);
        $stmt->bindParam(":fk_idmenus", $permission->fk_idmenu);
        $stmt->bindParam(":adm", $permission->adm);
        $stmt->execute();

        // Mensagem de sucesso por adicionar o filme
        $this->message->setMessage("Permissão concedida! ", "success", "addPermission.php");
    }
    //FUNCTION QUE DELETA A PERMISSÃO DO PERFIL DO USUÁRIO
    public function deletePermission($fk_iduser, $fk_idmenu)
    {
        $stmt = $this->conn->prepare("DELETE FROM permissions WHERE fk_idusers = :fk_idusers AND fk_idmenus = :fk_idmenus");
        $stmt->bindParam(":fk_idusers", $fk_iduser);
        $stmt->bindParam(":fk_idmenus", $fk_idmenu);
        
        
        $stmt->execute();
        if($stmt->rowCount() === 0){
            $this->message->setMessage("O usuário não possui acesso ao módulo.", "error", "addPermission.php");
        }else{
            $this->message->setMessage("Acesso removido com sucesso.", "success", "addPermission.php");
        }
    }
    //FUNCTION QUE VERIFICA SE O USUÁRIO JÁ POSSUI MENU OU NÃO, PARA PERMITIR OU NÃO A INSERÇÃO / REMOÇÃO DE MENU DO ACESSO DO USUÁRIO
    public function verifyMenu($fk_idusers, $fk_idmenus)
    {
        $stmt = $this->conn->prepare("SELECT m.menu from menus m  
        INNER JOIN permissions p
        on m.id = p.fk_idmenus
        WHERE p.fk_idusers = :fk_idusers AND p.fk_idmenus = :fk_idmenus; ");

        $stmt->bindParam(":fk_idusers", $fk_idusers);
        $stmt->bindParam(":fk_idmenus", $fk_idmenus);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $menusArray = $stmt->fetchAll();

            foreach ($menusArray as $menu) {
                $menus[] = $this->buildPermission($menu);
            }
        }
        return $menus;
    }

    public function verifyIdUser($fk_idusers, $fk_idmenus){
        $stmt = $this->conn->prepare("select p.id from permissions p
        where fk_idusers = :fk_idusers AND fk_idmenus = :fk_idmenus;");
        $stmt->bindParam(":fk_idusers", $fk_idusers);
        $stmt->bindParam(":fk_idmenus", $fk_idmenus);
        $stmt->execute();
    }
    
    public function verifyIfUserHasAdm($login){
        $stmt = $this->conn->prepare("SELECT adm FROM permissions p INNER JOIN users u ON p.fk_idusers = u.id WHERE u.login = :login AND p.adm = '1'");
        $stmt->bindParam(':login', $login); //vai pegar o ID pela variável global $_SESSION
        $stmt->execute();

        if($stmt->rowCount() > 0)
            $_SESSION['userIsAdm'] = 1;
        else{
            $_SESSION['userIsAdm'] = 0;
        }
    }
}