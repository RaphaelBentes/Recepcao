<?php

include("./backend/Atendimento.php");
session_start();
$proximo = Atendimentos::get_proximo();
if(count($proximo) > 0){
?>
<hr>
    <h4>Atendimento chamado</h4>
<hr>
<div class="row">
    <?php
    foreach($proximo as $p){
    ?>
        <div class="col-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <p><?=$p['nome_pessoa']?></p>
                </div>
                <div class="card-footer btn-group">
                    <?php if($_SESSION['atendente']['tipo'] == '2'){ ?>
                        <button class="btn btn-primary form-control" onclick="concluirProximo(<?=$p['id'];?>,<?=$p['id_atendimento'];?>)"><img style="filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);" src="./style/img/thumbs-up-solid.svg" width="20px;"></button>
                    <?php } else { ?>
                        <button class="btn btn-danger form-control" onclick="modalCancelarProximo(<?=$p['id'];?>,<?=$p['id_atendimento'];?>)"  data-bs-toggle="modal" data-bs-target="#cancelarProximoModal" ><img style="filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);" src="./style/img/ban-solid.svg" width="20px;"></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
function concluirProximo(id, id_ate){
    $.post(
        "./concluirProximo.php",
        {id:id, id_ate: id_ate},
        function(response){
            console.log(response);
            if(response == 1){
                $("#proximo").load("./proximo.php");
                $("#DivAtendimentos").load("./atendimentos.php");
                $("#DashboardDiaria").load("./dashboard.php");
            }
        }
    )

}

function modalCancelarProximo(id,id_ate){
    $('#cancelarIDProx').val(id);
    $('#cancelarIDProxAte').val(id_ate);
}
function cancelarProximo(){
    var id = $("#cancelarIDProx").val();
    var his = $("#cancelarHistoricoProx").val();
    var id_ate = $("#cancelarIDProxAte").val();
    $.post(
        "./cancelarProximo.php",
        {id:id, his: his, id_ate: id_ate},
        function(response){
            if(response == 1){
                $("#proximo").load("./proximo.php");
                $("#DivAtendimentos").load("./atendimentos.php");
                $("#DashboardDiaria").load("./dashboard.php");
            }
        }
    )
}
</script>


 <!-- Modal -->
    <div class="modal fade" id="cancelarProximoModal" tabindex="-1" aria-labelledby="cancelarAtendimentoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="padding: 10px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelarAtendimentoLabel">Cancelar atendimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="hidden" id="cancelarIDProx">
                        <input type="hidden" id="cancelarIDProxAte">
                        <select class="form-control" id="cancelarHistoricoProx" required >
                            <option >Selecione um motivo</option>
                            <option value="AUSENTE">AUSENTE</option>
                            <option value="DEMORA NO ATENDIMENTO">DEMORA NO ATENDIMENTO</option>
                            <option value="DESISTIU DO ATENDIMENTOS">DESISTIU DO ATENDIMENTOS</option>
                            <option value="EXPEDIENTE ENCERRADO">EXPEDIENTE ENCERRADO</option>
                        </select>
                    </div>
                   
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="cancelarProximo()" data-bs-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>