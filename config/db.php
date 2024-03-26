<?php 
    //Parâmetros que vão para $conn e montam a conexão
    $dbname = "control";
    $user = "root";
    $pass = "1234";
    $host = "localhost";

    //conexão PDO criada utilizadas em diversas outras classes
    $conn = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $pass);
    
   
    //Habilitar erros PDO

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


   


?>