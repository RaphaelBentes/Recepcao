<?php
include('./header.php');
?>
<div class="container">
<input type="date" id="dataBuscar">
<button onclick="setData()">BUscar</button>
        <br>
        <h4 class="text-center">Relatório de atendimento</h4>
    <div class="row text-center" style=" margin: 0 auto;">
        <div class="col-12">
            <div style="width: 100%; height:auto;">
                <canvas id="myChart" height="50"></canvas>
            </div>
        </div>
        <br>
        <div class="col-6">
            <div style="width: 100%; height:auto;">
                <br>
                <h4 class="text-center">Semana do dia <span class="spanDia"></span> de <span class="spanMes"></span> de <span class="spanAno"></span></h4>
                <canvas id="relatorioSemana" height="150" ></canvas>
            </div>
        </div>
        <div class="col-4">
            <div style="width: 100%; height:auto;">
                <br>
                <h4 class="text-center"><span class="spanMes"></span> de <span class="spanAno"></span></h4>
                <canvas id="relatorioMes"height="50"></canvas>
            </div>
        </div>
        <div class="col-12">
            <div style="width: 100%; height:auto;">
                <br>
                <h4 class="text-center">Atendimentos de <span class="spanAno"></span></h4>
                <canvas id="relatorioAno" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
    <script>
        function setData(){
        var data;
        var meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
        var val = $("#dataBuscar").val();
        data = new Date(val.substring(0,4),(val.substring(5,7)-1),val.substring(8,10));
       
        $('.spanDia').text((data.getDate() < 10 ? '0' : '') + data.getDate());
        $('.spanMes').text(meses[data.getMonth()]);
        $('.spanAno').text(data.getFullYear());
        
        var totalAno=0, totalMes=0, totalSemana = [0,0,0,0,0,0,0], totalDia = 0;

        var canceladoAno = [0,0,0,0,0,0,0,0,0,0,0,0], canceladoMes=0, canceladoSem = [0,0,0,0,0,0,0] , canceladoDia = 0;

        var concluidoAno = [0,0,0,0,0,0,0,0,0,0,0,0], concluidoMes= 0, concluidoSem = [0,0,0,0,0,0,0], concluidoDia = 0;

        var abertoAno, abertoMes, abertoDia = 0;

        var cancelados=0, concluidos=0, abertos=0, total=0;

        $.post(
            "./backend/relatorios.php", 
            function(res){
                res = JSON.parse(res);

                var dataProx  = new Date(data); 
                var dataSemana, indice;
                for(var j = dataProx.getDay(); j <= 7; j++){
                    
                    dataSemana= dataProx.getFullYear()+"-"+ ((dataProx.getMonth()+1) < 10 ? '0' : '') + (dataProx.getMonth()+1) +"-"+  (dataProx.getDate() < 10 ? '0' : '') + dataProx.getDate() ;
                    
                    for (let i = 0; i < res.length; i++) {
                        indice = j;
                        if(j == 7)
                            indice = 0;
                        if(res[i].status == "CONCLUÍDO"  && res[i].dataA == dataSemana)
                            concluidoSem[indice]+=1;
                        if(res[i].status == "CANCELADO" && res[i].dataA == dataSemana)
                            canceladoSem[indice]+=1;
                        if(res[i].dataA == dataSemana)
                            totalSemana[indice] += 1;
                    }
                    
                    dataProx.setDate(dataProx.getDate()+1);
                    
                }
                
                var dataAnt = new Date(data); 
                for(var j = dataAnt.getDay()-1; j > 0; j--){
                    dataAnt.setDate(dataAnt.getDate()-1);
                    dataSemana= dataAnt.getFullYear()+"-"+ ((dataAnt.getMonth()+1) < 10 ? '0' : '') + (dataAnt.getMonth()+1) +"-"+  (dataAnt.getDate() < 10 ? '0' : '') + dataAnt.getDate() ;
                    
                    for (let i = 0; i < res.length; i++) {
                        if(res[i].status == "CONCLUÍDO"  && res[i].dataA == dataSemana)
                            concluidoSem[j]+=1;
                        if(res[i].status == "CANCELADO" && res[i].dataA == dataSemana)
                            canceladoSem[j]+=1;
                        if(res[i].dataA == dataSemana)
                            totalSemana[j] += 1;
                    }
                    
                    
                }


                var dataProx  = new Date(data); 
                var dataSemana, indice;
                for(var j = (dataProx.getMonth()); j < 11; j++){
                    
                    dataProx.setMonth((dataProx.getMonth()+1));
                    dataSemana= dataProx.getFullYear()+"-"+ ((dataProx.getMonth()+1) < 10 ? '0' : '') + (dataProx.getMonth()) +"-"+  (dataProx.getDate() < 10 ? '0' : '') + dataProx.getDate() ;
                    
                    for (let i = 0; i < res.length; i++) {
                        if(res[i].status == "CONCLUÍDO"  && res[i].dataA.substring(0,4) == dataProx.getFullYear() && res[i].dataA.substring(5,7) == (dataProx.getMonth() < 10 ? '0' : '') + dataProx.getMonth())
                            concluidoAno[dataProx.getMonth()-1] +=1; 
                        if(res[i].status == "CANCELADO" && res[i].dataA.substring(0,4) == dataProx.getFullYear() && res[i].dataA.substring(5,7) == (dataProx.getMonth() < 10 ? '0' : '') + dataProx.getMonth())
                            canceladoAno[dataProx.getMonth()-1] +=1; 
                    }
                    
                    
                    console.log(dataProx.getMonth()+" - "+concluidoAno);
                }

                
                var dataAnt  = new Date(data); 
                var dataSemana, indice;
                for(var j = dataAnt.getMonth(); j >= 0; j--){
                    console.log(dataAnt.getMonth());
                    dataSemana= dataAnt.getFullYear()+"-"+ (dataAnt.getMonth() < 10 ? '0' : '') + (dataAnt.getMonth()) +"-"+  (dataAnt.getDate() < 10 ? '0' : '') + dataAnt.getDate() ;
                    
                    for (let i = 0; i < res.length; i++) {
                        if(res[i].status == "CONCLUÍDO"  && res[i].dataA.substring(0,4) == dataAnt.getFullYear() && res[i].dataA.substring(5,7) == (dataAnt.getMonth() < 10 ? '0' : '') + dataAnt.getMonth())
                            concluidoAno[dataAnt.getMonth()-1] +=1; 
                        if(res[i].status == "CANCELADO" && res[i].dataA.substring(0,4) == dataAnt.getFullYear() && res[i].dataA.substring(5,7) == (dataAnt.getMonth() < 10 ? '0' : '') + dataAnt.getMonth())
                            canceladoAno[dataAnt.getMonth()-1] +=1; 
                    }
                    
                    console.log(dataAnt.getMonth()+" - "+concluidoAno);
                    dataAnt.setMonth((dataAnt.getMonth()-1));
                    
                }
                

                var dataH = data; 
                var dataFormat = dataH.getFullYear()+"-"+((dataH.getMonth()+1) < 10 ? '0' : '') + (dataH.getMonth()+1)+"-"+((dataH.getDate()) < 10 ? '0' : '') + (dataH.getDate());
                for (let i = 0; i < res.length; i++) {
                    //dia
                    if(res[i].status == "ABERTO" && res[i].dataA == dataFormat )
                        abertoDia+=1;
                    if(res[i].status == "CONCLUÍDO"  && res[i].dataA == dataFormat)
                        concluidoDia+=1;
                    if(res[i].status == "CANCELADO" && res[i].dataA == dataFormat)
                        canceladoDia+=1;
                    if(res[i].dataA == dataFormat)
                        totalDia+=1;

                    
                    

                    //Mês
                    if(res[i].status == "CONCLUÍDO" && res[i].dataA.substring(5,7) == ((dataH.getMonth()+1) < 10 ? '0' : '') + (dataH.getMonth()+1) && res[i].dataA.substring(0,4) == dataH.getFullYear())
                        concluidoMes+=1;
                    if(res[i].status == "CANCELADO" && res[i].dataA.substring(5,7) == ((dataH.getMonth()+1) < 10 ? '0' : '') + (dataH.getMonth()+1) && res[i].dataA.substring(0,4) == dataH.getFullYear())
                        canceladoMes+=1;
                    if(res[i].dataA.substring(5,7) == ((dataH.getMonth()+1) < 10 ? '0' : '') + (dataH.getMonth()+1) && res[i].dataA.substring(0,4) == dataH.getFullYear() )    
                        totalMes++;

                    
                }
                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Cancelados: '+canceladoDia, 'Concluídos: '+concluidoDia, 'Total: '+totalDia],
                            datasets: [{
                                label: 'Data: '+data.getDate()+"/"+(data.getMonth()+1)+"/"+data.getFullYear() ,
                                data: [canceladoDia, concluidoDia, totalDia],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    
                    const dataLine = {  
                        labels: ['Segunda','Terça','Quarta','Quinta','Sexta'], 
                        datasets: [{
                            label: 'Concluídos',
                            data: [concluidoSem[1],concluidoSem[2],concluidoSem[3],concluidoSem[4],concluidoSem[5]],
                            borderWidth: 1,
                            fill: false,
                            borderColor: 
                            'rgba(54, 162, 235, 1)'
                        },
                        {
                            label: 'Cancelados',
                            data: [canceladoSem[1], canceladoSem[2], canceladoSem[3], canceladoSem[4], canceladoSem[5]],
                            borderWidth: 2,
                            fill: false,
                            borderColor: 
                            'rgba(255, 99, 132, 1)'
                        }
                        /*,
                        {
                            label: 'Total',
                            data: [totalSemana[1],totalSemana[2],totalSemana[3],totalSemana[4],totalSemana[5]],
                            borderWidth: 1,
                            fill: false,
                            borderColor: 'Green'
                        }*/
                        ] 
                    };
                    const configLine = {
                    type: 'line',
                    data: dataLine,
                    };

                    const line = document.getElementById('relatorioSemana').getContext('2d');
                    const relatorioSemana = new Chart(line, configLine);

                
                    const dataCircle = {
                    labels: [
                        'Concluídos: '+concluidoMes,
                        'Cancelados: '+canceladoMes
                    ],
                    datasets: [{
                        label: 'My First Dataset',
                        data: [concluidoMes, canceladoMes],
                        backgroundColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        hoverOffset: 2
                    }]
                    };

                    const configCircle = {
                    type: 'doughnut',
                    data: dataCircle,
                    };

                    const circle = document.getElementById('relatorioMes').getContext('2d');
                    const relatorioMes = new Chart(circle, configCircle);



                    const dataLineAno = {  
                        labels: meses, 
                        datasets: [{
                            label: 'Concluídos',
                            data: [concluidoAno[0],concluidoAno[1],concluidoAno[2],concluidoAno[3],concluidoAno[4],concluidoAno[5],concluidoAno[6],concluidoAno[7],concluidoAno[8],concluidoAno[9],concluidoAno[10],concluidoAno[11]],
                            borderWidth: 1,
                            fill: false,
                            borderColor: 
                            'rgba(54, 162, 235, 1)'
                        },
                        {
                            label: 'Cancelados',
                            data: [canceladoAno[0],canceladoAno[1],canceladoAno[2],canceladoAno[3],canceladoAno[4],canceladoAno[5],canceladoAno[6],canceladoAno[7],canceladoAno[8],canceladoAno[9],canceladoAno[10],canceladoAno[11]],
                            borderWidth: 2,
                            fill: false,
                            borderColor: 
                            'rgba(255, 99, 132, 1)'
                        }
                        /*,
                        {
                            label: 'Total',
                            data: [totalSemana[1],totalSemana[2],totalSemana[3],totalSemana[4],totalSemana[5]],
                            borderWidth: 1,
                            fill: false,
                            borderColor: 'Green'
                        }*/
                        ] 
                    };
                    const configLineAno = {
                    type: 'line',
                    data: dataLineAno,
                    };

                    const lineAno = document.getElementById('relatorioAno').getContext('2d');
                    const relatorioAno = new Chart(lineAno, configLineAno);
        });
}

</script>