<?php
include("./Atendimento.php");

$res = Atendimentos::get_atendimentos();
if($res){
    echo json_encode($res);
}else{
    
echo json_encode($res);
}
?>