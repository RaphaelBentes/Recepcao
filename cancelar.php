<?php
require("./backend/Atendimento.php");
$id = $_POST['id'];
$his = $_POST['his'];
$c = Atendimentos::cancelar_atendimento($id,$his);
echo $c;

?>