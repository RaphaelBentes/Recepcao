<?php 
 date_default_timezone_set('America/Belem');
 session_start();

include("./backend/Atendimento.php");
$atendimentos = Atendimentos::get_atendimentos();
foreach($atendimentos as $a){ 
    if($a['status'] == "ABERTO"){
    $data = date('d/m/Y');
    if($data == date_format(date_create($a['dataA']),'d/m/Y')){
    ?>
<div class="list-group-item" style="margin: 5px;" >
    <div style="width: 300px;float:left;">
        <span><?=$a['nome']?></span> 
    </div>
    
    <div style="width: 400px;float:left;">
        <p ><?=$a['assunto'];?></p>
    </div>
   
    <div style="float: right;  margin: 0 auto;">
        <?php if($_SESSION['atendente']['tipo'] == '2'){ ?>
            <button class="btn" onclick='chamarAtendimento(<?=$a["id"];?>)'><img style="filter: invert(40%) sepia(10%) saturate(9994%) hue-rotate(4000deg) brightness(100%) contrast(288%);" src="./style/img/bell-solid.svg" width="20px;"></button>
        <?php } ?>
        <button class="btn" onclick="concluirAtendimento(<?=$a['id']?>)"><img style="filter: invert(27%) sepia(84%) saturate(1566%) hue-rotate(222deg) brightness(88%) contrast(82%);" src="./style/img/thumbs-up-solid.svg" width="20px;"></button>
        <button class="btn" onclick="modalCancelar(<?=$a['id']?>)"  data-bs-toggle="modal" data-bs-target="#cancelarModal" ><img style="filter: invert(10%) sepia(64%) saturate(6441%) hue-rotate(349deg) brightness(135%) contrast(98%);" src="./style/img/ban-solid.svg" width="20px;"></button>
    </div> 
    <div style="float: right;">
        <span><?php echo date_format(date_create($a['dataC']),'d/m/Y H:i:s');?></span>
    </div>
</div>
<?php } } }?>
<script>
    
function chamarAtendimento(id){
    $.post(
        "./chamarAtendimento.php",
        {id:id},
        function(response){
            console.log(response);
            if(response == '1'){
                $("#DivAtendimentos").load("./atendimentos.php");
                $("#DashboardDiaria").load("./dashboard.php");
                $("#proximo").load("./proximo.php");
            }else if(response == '2'){
                alert("Aguardando, retorno da recepção");
            }
        }
    )

}

function concluirAtendimento(id){
    $.post(
        "./concluir.php",
        {id:id},
        function(response){
            if(response == 1){
                $("#DivAtendimentos").load("./atendimentos.php");
                $("#DashboardDiaria").load("./dashboard.php");
                $("#proximo").load("./proximo.php");
            }
        }
    )

}

function modalCancelar(id){
    $('#cancelarID').val(id);
}
function cancelarAtendimento(){
    var id = $("#cancelarID").val();
    var his = $("#cancelarHistorico").val();
    if(his == ""){
        alert("Informe um motivo.");
        return;
    }
    $.post(
        "./cancelar.php",
        {id:id, his: his},
        function(response){
            if(response == 1){
                $("#DivAtendimentos").load("./atendimentos.php");
                $("#DashboardDiaria").load("./dashboard.php");
                $("#proximo").load("./proximo.php");
                $("#cancelarModal").modal("hide");
            }
        }
    )
}
</script>


 <!-- Modal -->
    <div class="modal" id="cancelarModal" tabindex="-1" aria-labelledby="cancelarAtendimentoLabel">
        <div class="modal-dialog">
            <div class="modal-content" style="padding: 10px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelarAtendimentoLabel">Cancelar atendimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="hidden" id="cancelarID">
                        <select class="form-control" id="cancelarHistorico" required >
                            <option value="">Selecione um motivo</option>
                            <option value="AUSENTE">AUSENTE</option>
                            <option value="DEMORA NO ATENDIMENTO">DEMORA NO ATENDIMENTO</option>
                            <option value="DESISTIU DO ATENDIMENTO">DESISTIU DO ATENDIMENTO</option>
                            <option value="EXPEDIENTE ENCERRADO">EXPEDIENTE ENCERRADO</option>
                        </select>
                    </div>
                   
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="cancelarAtendimento()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>


    