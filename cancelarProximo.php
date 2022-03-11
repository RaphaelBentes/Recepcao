<?php
require("./backend/Atendimento.php");
$id = $_POST['id'];
$his = $_POST['his'];
$id_ate = $_POST['id_ate'];
$c = Atendimentos::cancelar_atendimento($id_ate,$his);
$d = Atendimentos::concluir_proximo($id,$id_ate);
if($c){
    echo $d;
}

?>