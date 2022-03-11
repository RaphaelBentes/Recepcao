<?php
require("./backend/Atendimento.php");
$id = $_POST['id'];
$id_ate = $_POST['id_ate'];
$c = Atendimentos::concluir_atendimento($id_ate);
$d = Atendimentos::concluir_proximo($id,$id_ate);
if($c){
    echo $d;
}

?>