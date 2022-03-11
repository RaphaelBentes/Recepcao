<?php
require("./backend/Atendimento.php");
$id = $_POST['id'];

$atendimentos = Atendimentos::get_atendimentos();
$nome = "";
foreach($atendimentos as $a){
    if($id == $a['id'])
        $nome = $a['nome'];
}


$proximos = Atendimentos::get_proximo();
$chamou = 0;
foreach($proximos as $p){
    if($p['id_atendimento'] == $id)
        $chamou = 1;
}
if($chamou == 0){
    $c = Atendimentos::chamar_atendimento($id,$nome);
    echo $c;
}else{
    echo '2';
}

?>