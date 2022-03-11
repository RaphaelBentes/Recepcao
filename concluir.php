<?php
require("./backend/Atendimento.php");
$id = $_POST['id'];
$c = Atendimentos::concluir_atendimento($id);
echo $c;

?>