<?php
include("./backend/Pessoas.php");

$cpf = $_POST['cpf'];
if($cpf != ""){
    $pessoa = Pessoas::find_pessoa($cpf);
    if($pessoa){
       echo json_encode($pessoa);
    }
}


?>

