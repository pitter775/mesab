<?php

  function converte_segundos($tempo){
    $segundos = 0;
    list( $h, $m, $s ) = explode( ':', $tempo ); 
    $segundos += $h * 3600; 
    $segundos += $m * 60;
    $segundos += $s;
    return $segundos;
}

function horas_segundos($total){
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
    if(strlen($horas) == 1){ $horas = '0'.$horas;}
    $horas = number_format($horas,0, ',', '.');
    return $horas . ":" . $minutos;
}



function horas_segundos2($total){
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    return $horas . "." . $minutos;
}
?>
<div class="row">
    <div class="col-md-9">
        <div class="navhoras">
            <ul class="nav nav-pills mb-3" id="pills_atividade-tab" role="tablist">
                <li class="nav-item ">
                    <a class="nav-link nav_horas active" id="pills_atividade-hs-tab" data-toggle="pill" href="#pills_atividade-hs" role="tab" aria-controls="pills_atividade-hs" aria-selected="true"> HORAS</a>
                </li>   
                @if(Auth::user()->perfil == 2)   
                <li class="nav-item ">
                    <a class="nav-link nav_financ" id="pills_atividade-rs-tab" data-toggle="pill" href="#pills_atividade-rs" role="tab" aria-controls="pills_atividade-rs" aria-selected="false"> FINANCEIRO </a>
                </li>
                @endif
            </ul>
        </div>

        <div class="tab-content" id="pills_atividade-tabContent" style="border: solid 0px #ccc; display:block; margin-top: 0px">
            <div class="tab-pane fade show active" id="pills_atividade-hs" role="tabpanel" aria-labelledby="pills_atividade-hs-tab" style=" width: 100%; border: solid 1px #fff; margin-top: -45px">
                @include('pages.home.grafico_atividade_hs')     
            </div>
            <div class="tab-pane fade show active" id="pills_atividade-rs" role="tabpanel" aria-labelledby="pills_atividade-rs-tab" style=" width: 100%; border: solid 1px #fff; margin-top: -45px">
                @include('pages.home.grafico_atividade_rs')
            </div>
        </div>
    </div>
    <div class="col-md-3 text-center" style="border-left: solid 1px #eee;">
        <h5 style="font-weight: 300; color: #777; font-size: 25px">{{$nometipo->prdescricao ?? 'Todos'}}</h5>
        <div style=" padding-top:10px">
            @if(Auth::user()->perfil == 2)   
                <h5 style="font-weight: 500; color: #6a82cf; font-size: 20px; margin-top:-0px"> R$ {{$tipo_valor}}</h5>  
            @endif
            <h5 style="font-weight: 500; color: #5ec762; font-size: 20px; margin-top:-15px"><i class="far fa-clock"></i> <?php echo horas_segundos($tipo_hora) ?></h5>    
            <h5 style="font-weight: 500; color: #999; font-size: 20px; margin-top:-15px"><i class="fas fa-running"></i>  {{$tipo_pess}} </h5>       

            <div id="horaint" style="width: 100%; height: 200px"></div>
            <?php                    
                $porc_tipo_hora = $tipo_hora * 100 / $tipo_horafull; 
                $porc_tipo_pess = $tipo_pess * 100 / $tipo_pessfull; 

                $limpacusto1 = explode(",", $tipo_valor);
                $limpacusto1 = str_replace(".", "", $limpacusto1[0]);
                
                $limpacusto2 = explode(",", $tipo_valorfull);
                $limpacusto2 = str_replace(".", "", $limpacusto2[0]);

                if($limpacusto1 !== "0"){
                    $porc_tipo_custo =  $limpacusto1 * 100 / $limpacusto2; 
                }else{
                    $porc_tipo_custo = 0;
                }
            ?>
                          
            <script>
                    var domint = document.getElementById("horaint");
                    var myChartint = echarts.init(domint);
                    var app = {};

                    var optionint;
                    optionint = {
                        series: [{
                            type: 'gauge',
                            startAngle: 90,
                            endAngle: -270,
                            pointer: {
                                show: false
                            },
                            progress: {
                                show: true,
                                overlap: false,
                                roundCap: true,
                                clip: false,
                                itemStyle: {
                                    borderWidth: 1
                                }
                            },
                            axisLine: {

                                lineStyle: {
                                    width: 20
                                    
                                }
                            },
                            splitLine: {
                                show: false,
                                distance: 0,
                                length: 10
                            },
                            axisTick: {
                                show: false
                            },
                            axisLabel: {
                                show: false,
                                distance: 50
                            },
                            data: [
                            
                            {
                                value: <?php echo round($porc_tipo_hora) ?>,
                                // name: 'azul',
                                title: {
                                    offsetCenter: ['0%', '-20%']
                                },
                                detail: {
                                    offsetCenter: ['0%', '-30%']
                                },
                                itemStyle: { color: '#7087d1' }
                            },
                            
                            {
                                value: <?php echo round($porc_tipo_custo) ?>,
                                // name: 'verde',
                                title: {
                                    offsetCenter: ['0%', '-30%']
                                },
                                detail: {
                                    offsetCenter: ['0%', '0%']
                                },
                                itemStyle: { color: '#64c968' }
                            },
                            {
                                value: <?php echo round($porc_tipo_pess) ?>,
                                // name: 'Good',
                                title: {
                                    offsetCenter: ['0%', '-20%']
                                },
                                detail: {
                                    offsetCenter: ['0%', '30%']
                                },
                                itemStyle: { color: '#999' }
                            }
                            ],
                            title: {
                                fontSize: 14
                            },
                            detail: {
                                width: 50,
                                height: 14,
                                fontSize: 18,
                                color: 'auto',
                                // borderColor: 'auto',
                                // borderRadius: 20,
                                // borderWidth: 1,
                                formatter: '{value}%'
                            }
                        }]
                    
                    };

                    if (optionint && typeof optionint === 'object') {
                        myChartint.setOption(optionint);
                    }
            </script>
                               
        </div>
    </div>

</div>


<script>
    $('#pills_atividade-hs-tab').on('click',function(){        
        $( '.titiintat' ).html('Total de Horas');      
        $('#pills_atividade-rs').css('display', 'none');  
    });
    $('#pills_atividade-rs-tab').on('click',function(){        
        $( '.titiintat' ).html('Total Financeiro');       
        $('#pills_atividade-rs').css('display', 'table');  
    });
    setTimeout(function(){ 
        $('#pills_atividade-rs').removeClass('show', 'active');  
        $('#pills_atividade-rs').css('display', 'none');
    },0);
</script>



