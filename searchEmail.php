<?php
    require_once('db.php');
   

    if(isset($_POST['email'])){
        $busca = $_POST['email'];
        $stmt = "select * from users where email like '%".$busca."%' order by email";
    }
    else{
        $stmt = "select * from users order by email";
    }
    $statement = $conn->prepare($stmt);
    $statement->execute();
    $result = $statement->fetchAll();
    $rowCount = $statement->rowCount();

    if($rowCount > 0){
        $data = '<div class="table-responsive">
        <table class="table bordered">
        <tr>
        <th> email </th>
        </tr>
        ';

        foreach($result as $row){
            $data .= '
            <tr>
            <td>'.$row["email"].'</td>
            </tr>
            ';
        }
        $data .='</table></div>';
    }
    else{
        $data = "Nenhum registro localizado.";
    }

    echo $data;

?>