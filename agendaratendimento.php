<?php
include("./backend/Atendimento.php");
include("./backend/Pessoas.php");


$id = $_POST['id'];
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$data = date($_POST['data']);
$assunto = $_POST['assunto'];

if($id != ""){
    //agenda
    $at = Atendimentos::post_atendimento($id,$nome,$data,$assunto);
    if($at){
        echo $at;
    }
}else if($cpf != "" ){
    //cadastra
        $p = Pessoas::post_pessoa($nome,$cpf,$telefone,$email);
    if($p){
        $at2 = Atendimentos::post_atendimento($id,$nome,$data,$assunto);
        if($at2){
            echo '2';
        }
    }
} else{
    //agenda sem cadastro
    $at3 = Atendimentos::post_atendimento($id,$nome,$data,$assunto);
    if($at3){
        echo '3';
    }
}

?>