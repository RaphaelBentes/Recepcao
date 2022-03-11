<?php 
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

if(isset($_SESSION['atendente'])){
    header('Location: http://localhost/recepcao');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("./header.php"); ?>
<style>
.blue{
    color: blue;
}
.red{
    color: red;
}
</style>
<script>
        
    $( document ).ready(function() {
        $("#DivAtendimentos").load("./atendimentos.php");
        $("#DashboardDiaria").load("./dashboard.php");
        $("#proximo").load("./proximo.php");
        $("#findCPF").mask('000.000.000-00');
        $("#pessoaCPF").mask('000.000.000-00');
                
    });
    setInterval(() => {
        $("#DivAtendimentos").load("./atendimentos.php");
        $("#DashboardDiaria").load("./dashboard.php");
        $("#proximo").load("./proximo.php");
        $("#exampleModal").modal('hide');
        $("#cancelarModal").modal('hide');
    }, 60000);
</script>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Atendimento</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="./relatorios.php">Relatório</a>
            </li>
        </ul>
        </div>
        <div class="me-2">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <button class="btn btn-outline-danger nav-link me-2" onclick="Logout()">Sair</button>
                </li>
            </ul>
        </div>
    </div>
    </nav>
        <br>
    <div class="container">
        
        <div class="row text-center" id="DashboardDiaria"></div>
        
        <div id="proximo"></div>
        <hr>
        <h4> Agendados do dia <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;">Agendar Atendimento</button></h4>
        <hr>
       

        <div class="list-group" id="DivAtendimentos">
            

        </div>
    </div>

<script>
    function Logout(){
        var x;
        var r=confirm("Deseja encecrra sessão?");
        if (r==true)
        {
            window.location = "./logout.php";
        }
        else
        {
        x="Você pressionou Cancelar!";
        }
    }
    function findPessoa(){
        var cpf = $('#findCPF').val();
        $.post(
            './findpessoas.php',
            {cpf: cpf},
            function(response){
                if(response != 0){
                    response = JSON.parse(response);
                    $("#pessoaID").val(response.id);
                    $("#pessoaCPF").val(response.cpf);
                    $("#pessoaNome").val(response.nome);
                    $("#pessoaTelefone").val(response.telefone);
                    $("#pessoaEmail").val(response.email);
                    
                    $("#findCPF").css('border-color','#999');
                }else{
                    $("#findCPF").css('border-color','red');
                    $("#pessoaID").val("");
                    $("#pessoaCPF").val(cpf);
                    $("#pessoaNome").val("");
                    $("#pessoaTelefone").val("");
                    $("#pessoaEmail").val("");
                
                }
            }
        )
    } 
    
    function agendarAtendimento(){
        var id = $("#pessoaID").val();
        var cpf = $("#pessoaCPF").val();
        var nome = $("#pessoaNome").val();
        var telefone = $("#pessoaTelefone").val();
        var email = $("#pessoaEmail").val();
        var data = $("#pessoaData").val();  
        var assunto = $("#pessoaAssunto").val();
        if(nome == ""){
            alert("Preecha o Nome da pessoa");
            return;
        }
        if( assunto == ""){
            alert("Informe um assunto");
            return;
        }


        $.post(
            "agendaratendimento.php",
            {id: id, cpf: cpf, nome: nome, telefone: telefone, email: email, data: data, assunto: assunto},
            function(response){
                if(response){
                    $("#DivAtendimentos").load("./atendimentos.php");
                    $("#DashboardDiaria").load("./dashboard.php");
                    $("#pessoaID").val("");
                    $("#pessoaCPF").val(cpf);
                    $("#pessoaNome").val("");
                    $("#pessoaTelefone").val("");
                    $("#pessoaEmail").val("");
                    $("#exampleModal").modal('hide');
                }
            }
            );

    }
</script>

    <!-- Modal -->
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 10px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marcar atendimento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="input-group mb-3">
                <input type="text" id="findCPF" class="form-control" placeholder="Informe o CPF" aria-label="Example text with button addon" aria-describedby="button-addon1">
                <button  class="btn btn-outline-primary" onclick="findPessoa()" id="button-addon1">Buscar</button>
               
            </div>
            
            Dados pessoais
            <hr>
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="hidden" id="pessoaID">
                    <input class="form-control" id="pessoaCPF" placeholder="Informe o CPF">
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" id="pessoaNome" placeholder="Infome o nome completo">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input class="form-control" id="pessoaTelefone" placeholder="Informe o telefone">
                        </div>
                    </div>
                    <div class="col">    
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="pessoaEmail" placeholder="email@email.com">
                        </div>
                    </div>
                </div>
            Dados do atendimento
            <hr>
                <div class="input-group mb-3">
                    <input type="date" class="form-control" id="pessoaData"  value="<?php echo date('Y-m-d');?>">
                </div>
                
                <div class="input-group mb-3">
                    <textarea class="form-control" id="pessoaAssunto" placeholder="Informe um assunto"></textarea>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button id="buttonAgendar" type="button" class="btn btn-primary" onclick="agendarAtendimento()" >Confirmar</button>
            </div>
        </div>
    </div>
    </div>


</div>
<br<br><br>
</body>

</html>