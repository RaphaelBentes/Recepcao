<?php 
date_default_timezone_set('America/Belem');
include('./backend/Atendimento.php');
$ate = Atendimentos::get_atendimentos();
$abertos = 0;
$concluidos = 0;
$cancelados = 0;

$dataH = date('d/m/Y');
foreach($ate as $a){ 
    
    if($dataH == date_format(date_create($a['dataA']),'d/m/Y')){
        
        if($a['status'] == "ABERTO"){
            $abertos++;
        }
        if($a['status'] == "CONCLUÍDO"){
            $concluidos++;
        }
        if($a['status'] == "CANCELADO"){
            $cancelados++;
        }
    
    }
}
?>

<div class="col-6 col-lg-3">
<div class="card">
    <div class="card-title"><b>ABERTOS</b></div>
    <div class="card-body"><span class="display-4"><?=$abertos;?></span></div>
</div>
</div>
<div class="col-6 col-lg-3">
    <div class="card">
        <div class="card-title"><b>CONCLUÍDOS</b></div>
        <div class="card-body"><span class="display-4 blue"><?=$concluidos;?></span></div>
    </div>
</div>
<div class="col-6 col-lg-3">
    <div class="card">
        <div class="card-title"><b>CANCELADOS</b></div>
        <div class="card-body"><span class="display-4 red"><?=$cancelados;?></span></div>
    </div>
</div>
<div class="col-6 col-lg-3">
    <div class="card">
        <div class="card-title"><b>TOTAL</b></div>
        <div class="card-body"><span class="display-4"><?=$abertos+$concluidos+$cancelados;?></span></div>
    </div>
</div>