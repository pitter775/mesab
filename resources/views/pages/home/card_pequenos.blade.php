    
    <?php    
   
     $porcentagem = ($pessoas / $pessoas_full) * 100;
     $porcentagem = round ($porcentagem);

     $porcentagem_c = ($contratos / $contratos_full) * 100;
     $porcentagem_c = round ($porcentagem_c);

    //  $porcentagem_p = ($produtos / $produtos_full) * 100;
    //  $porcentagem_p = round ($porcentagem_p);

     $porcentagem_a = ($atividades / $atividades_full) * 100;
     $porcentagem_a = round ($porcentagem_a);


     $somatotal = explode(",", $totais['total_custo']);
     $somatotalok = str_replace(".", "", $somatotal[0]);


     $lista_contrato_tipo2['obra_hora'] = number_format($lista_contrato_tipo['obra_hora'],0, ',', '.');
     $lista_contrato_tipo2['apoio_hora'] = number_format($lista_contrato_tipo['apoio_hora'],0, ',', '.');
     $lista_contrato_tipo2['jica_hora'] = number_format($lista_contrato_tipo['jica_hora'],0, ',', '.');
     $lista_contrato_tipo2['automacao_hora'] = number_format($lista_contrato_tipo['automacao_hora'],0, ',', '.');
     $lista_contrato_tipo2['pura_hora'] = number_format($lista_contrato_tipo['pura_hora'],0, ',', '.');
     $lista_contrato_tipo2['sabesp_hora'] = number_format($lista_contrato_tipo['sabesp_hora'],0, ',', '.');

     
    ?>    
<style>
    .titipequeno{ font-size: 14px; font-weight: 500; color: #777}
    .titipequenof{ font-size: 16px; font-weight: 500; color: #777}
    .cardpeque.active { background-color: #dffcff !important;     box-shadow: 0 10px 20px 0px rgb(0 138 138 / 35%);}
    .cardpeque:hover { box-shadow: 0 10px 20px 0px rgb(0 138 138 / 35%);}
    .cardpeque { cursor: pointer;}
</style>




    <div class="col-md-2 " data-aos=fade-left data-aos-delay=0 data-aos-anchor="#filtrosfull" >
        <div class="card cardpeque active" data-id="Obra" style="position: relative;">
            <div class="card-header">
                <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$lista_contrato_tipo['obra_pess']}}</h6>
                <div class="row">
                    <div class="col-8" style="margin: 0; padding:0; padding-left: 10px">
                        <h5 style="font-weight: 500;" class="titipequeno">Obras</h5>
                        <?php                    
                            $porc_obra_hora = $lista_contrato_tipo['obra_hora'] * 100 / $totais['total_time']; 
                            $obra_custo = explode(",", $lista_contrato_tipo['obra_custo']);
                            $obra_custo = str_replace(".", "", $obra_custo[0]);
                            if($somatotalok !== '0'){
                                // echo '<pre>';
                                // var_dump($somatotalok);
                                // echo '</pre>';
                           
                                $obra_porc = $obra_custo * 100 / $somatotalok; 
                                // $obra_porc = 0;
                            }else{
                                $obra_porc = 0;
                            }
                        ?>
                         @if(Auth::user()->perfil == 2) <h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">$ {{$lista_contrato_tipo['obra_custo']}}</h6> @endif
                         <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$lista_contrato_tipo2['obra_hora']}} hs</h6>
                    </div>
                    @if(Auth::user()->perfil == 2) <div class="col-4" id="horas" style="margin: 0; padding:0;"></div> @endif
                </div>
                @if(Auth::user()->perfil == 2)
                <script>
                    var domm = document.getElementById("horas");
                    var myChartt2 = echarts.init(domm);
                    var app = {};
                    var optionn;
                    optionn = {
                        series: [{
                            type: 'gauge',
                            progress: {
                                show: true,
                                width: 4
                            },
                            axisLine: {
                            
                                lineStyle: {
                                    width: 4
                                }
                            },
                            axisTick: {
                                show: false
                            },
                            splitLine: {         
                                show: false,

                            
                            },
                            axisLabel: {
                                distance: 4,
                                color: '#6a82cf',
                                fontSize: 15,
                                show: false,
                            },
                            pointer: {
                                show: false,
                                size: 0,
                                itemStyle: {
                                    borderWidth: 0
                                }
                            },
                            anchor: {
                                show: false,
                            },
                            title: {
                                show: false
                            },
                            detail: {
                                valueAnimation: true,
                                color: '#6a82cf',
                                fontSize: 12,
                                offsetCenter: [0, '0%'],
                                formatter: '{value}%',
                            },
                            data: [{            
                                value: <?php echo round($obra_porc) ?>
                            }]
                        }]
                    };

                    if (optionn && typeof optionn === 'object') {
                        myChartt2.setOption(optionn);
                    }
                </script>
                @endif
            </div>
            <div class="card-body txtcenter" style="margin-top: -10px;"> 
                <div class="progress mb-1" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo round($porc_obra_hora) ?>%; background-color: #5ec762 !important;" aria-valuenow="<?php echo round($porc_obra_hora) ?>" aria-valuemin="<?php echo round($porc_obra_hora) ?>" aria-valuemax="<?php echo round($porc_obra_hora) ?>"></div>
                </div>
            </div>
        </div>        
    </div>

    <div class="col-md-2" data-aos=fade-left data-aos-delay=15 data-aos-anchor="#filtrosfull"  >
        <div class="card cardpeque"  data-id="Apoio" style="position: relative;">
            <div class="card-header">
                <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$lista_contrato_tipo['apoio_pess']}}</h6>
                <div class="row">
                    <div class="col-7" style="margin: 0; padding:0; padding-left: 10px">
                        <h5 style="font-weight: 500;" class="titipequeno">Apoio</h5>
                        <?php   $porc_apoio_hora = $lista_contrato_tipo['apoio_hora'] * 100 / $totais['total_time']; 
                                $apoio_custo = explode(",", $lista_contrato_tipo['apoio_custo']);
                                $apoio_custo = str_replace(".", "", $apoio_custo[0]);
                                if($apoio_custo !== "0"){
                                    $apoio_porc = $apoio_custo * 100 / $somatotalok; 
                                }else{
                                    $apoio_porc = 0;
                                }
                        ?>
                        @if(Auth::user()->perfil == 2)<h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">$ {{$lista_contrato_tipo['apoio_custo']}}</h6>@endif
                        <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$lista_contrato_tipo2['apoio_hora']}} hs</h6>
                    </div>
                    @if(Auth::user()->perfil == 2)<div class="col-5" id="horas_apoio" style="margin: 0; padding:0;"></div>@endif
                </div>
                @if(Auth::user()->perfil == 2)
                <script>
                    var domm = document.getElementById("horas_apoio");
                    var myChart_apoio = echarts.init(domm);
                    var app = {};
                    var option_apoio;
                    option_apoio = {
                        series: [{
                            type: 'gauge',
                            progress: {
                                show: true,
                                width: 4
                            },
                            axisLine: {
                            
                                lineStyle: {
                                    width: 4
                                }
                            },
                            axisTick: {
                                show: false
                            },
                            splitLine: {         
                                show: false,

                            
                            },
                            axisLabel: {
                                distance: 4,
                                color: '#6a82cf',
                                fontSize: 20,
                                show: false,
                            },
                            pointer: {
                                show: false,
                                size: 0,
                                itemStyle: {
                                    borderWidth: 0
                                }
                            },
                            anchor: {
                                show: false,
                            },
                            title: {
                                show: false
                            },
                            detail: {
                                valueAnimation: true,
                                color: '#6a82cf',
                                fontSize: 12,
                                offsetCenter: [0, '0%'],
                                formatter: '{value}%',
                            },
                            data: [{            
                                value: <?php echo round($apoio_porc) ?>
                            }]
                        }]
                    };

                    if (optionn && typeof optionn === 'object') {
                        myChart_apoio.setOption(option_apoio);
                    }
                </script>
                @endif
            </div>
            <div class="card-body txtcenter" style="margin-top: -10px;"> 
                <div class="progress mb-1" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo round($porc_apoio_hora) ?>%; background-color: #5ec762 !important;" aria-valuenow="<?php echo round($porc_apoio_hora) ?>" aria-valuemin="<?php echo round($porc_apoio_hora) ?>"
                     aria-valuemax="<?php echo round($porc_apoio_hora) ?>"></div>
                </div>
            </div>
        </div>        
    </div>

    <div class="col-md-2" data-aos=fade-left data-aos-delay=30 data-aos-anchor="#filtrosfull" >
        <div class="card cardpeque"  data-id="Jica" style="position: relative;">
            <div class="card-header">
                <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$lista_contrato_tipo['jica_pess']}}</h6>
                <div class="row">
                    <div class="col-7" style="margin: 0; padding:0; padding-left: 10px">
                        <h5 style="font-weight: 500;" class="titipequeno">Jica</h5>
                        <?php   $porc_jica_hora = $lista_contrato_tipo['jica_hora'] * 100 / $totais['total_time']; 
                                $jica_custo = explode(",", $lista_contrato_tipo['jica_custo']);
                                $jica_custo = str_replace(".", "", $jica_custo[0]);
                                if($jica_custo !== "0"){
                                    $jica_porc = $jica_custo * 100 / $somatotalok; 
                                }else{
                                    $jica_porc = 0;
                                }
                        ?>
                        @if(Auth::user()->perfil == 2)<h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">$ {{$lista_contrato_tipo['jica_custo']}}</h6>@endif
                        <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$lista_contrato_tipo2['jica_hora']}} hs</h6>
                    </div>
                    @if(Auth::user()->perfil == 2)<div class="col-5" id="horas_jica" style="margin: 0; padding:0;"></div>@endif
                </div>
                @if(Auth::user()->perfil == 2)
                <script>
                    var domm = document.getElementById("horas_jica");
                    var myChart_jica = echarts.init(domm);
                    var app = {};
                    var option_jica;
                    option_jica = {
                        series: [{
                            type: 'gauge',
                            progress: {
                                show: true,
                                width: 4
                            },
                            axisLine: {
                            
                                lineStyle: {
                                    width: 4
                                }
                            },
                            axisTick: {
                                show: false
                            },
                            splitLine: {         
                                show: false,

                            
                            },
                            axisLabel: {
                                distance: 4,
                                color: '#6a82cf',
                                fontSize: 20,
                                show: false,
                            },
                            pointer: {
                                show: false,
                                size: 0,
                                itemStyle: {
                                    borderWidth: 0
                                }
                            },
                            anchor: {
                                show: false,
                            },
                            title: {
                                show: false
                            },
                            detail: {
                                valueAnimation: true,
                                color: '#6a82cf',
                                fontSize: 12,
                                offsetCenter: [0, '0%'],
                                formatter: '{value}%',
                            },
                            data: [{            
                                value: <?php echo round($jica_porc) ?>
                            }]
                        }]
                    };

                    if (optionn && typeof optionn === 'object') {
                        myChart_jica.setOption(option_jica);
                    }
                </script>
                @endif
            </div>
            <div class="card-body txtcenter" style="margin-top: -10px;"> 
                <div class="progress mb-1" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo round($porc_jica_hora) ?>%; background-color: #5ec762 !important;" aria-valuenow="<?php echo round($porc_jica_hora) ?>" aria-valuemin="<?php echo round($porc_jica_hora) ?>"
                     aria-valuemax="<?php echo round($porc_jica_hora) ?>"></div>
                </div>
            </div>
        </div>        
    </div>

    <div class="col-md-2" data-aos=fade-left data-aos-delay=40 data-aos-anchor="#filtrosfull" >
        <div class="card cardpeque"  data-id="Automação" style="position: relative;">
            <div class="card-header">
                <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$lista_contrato_tipo['automacao_pess']}}</h6>
                <div class="row">
                    <div class="col-7" style="margin: 0; padding:0; padding-left: 10px">
                        <h5 style="font-weight: 500;" class="titipequeno">Automação</h5>
                        <?php   $porc_automacao_hora = $lista_contrato_tipo['automacao_hora'] * 100 / $totais['total_time']; 
                                $automacao_custo = explode(",", $lista_contrato_tipo['automacao_custo']);
                                $automacao_custo = str_replace(".", "", $automacao_custo[0]);
                                if($automacao_custo !== "0"){
                                    $automacao_porc = $automacao_custo * 100 / $somatotalok; 
                                }else{
                                    $automacao_porc = 0;
                                }
                                
                        ?>
                        @if(Auth::user()->perfil == 2)<h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">$ {{$lista_contrato_tipo['automacao_custo']}}</h6>@endif
                        <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$lista_contrato_tipo2['automacao_hora']}} hs</h6>
                    </div>
                    @if(Auth::user()->perfil == 2)<div class="col-5" id="horas_automacao" style="margin: 0; padding:0;"></div>@endif
                </div>
                @if(Auth::user()->perfil == 2)
                <script>
                    var domm = document.getElementById("horas_automacao");
                    var myChart_automacao = echarts.init(domm);
                    var app = {};
                    var option_automacao;
                    option_automacao = {
                        series: [{
                            type: 'gauge',
                            progress: {
                                show: true,
                                width: 4
                            },
                            axisLine: {
                            
                                lineStyle: {
                                    width: 4
                                }
                            },
                            axisTick: {
                                show: false
                            },
                            splitLine: {         
                                show: false,

                            
                            },
                            axisLabel: {
                                distance: 5,
                                color: '#6a82cf',
                                fontSize: 20,
                                show: false,
                            },
                            pointer: {
                                show: false,
                                size: 0,
                                itemStyle: {
                                    borderWidth: 0
                                }
                            },
                            anchor: {
                                show: false,
                            },
                            title: {
                                show: false
                            },
                            detail: {
                                valueAnimation: true,
                                color: '#6a82cf',
                                fontSize: 12,
                                offsetCenter: [0, '0%'],
                                formatter: '{value}%',
                            },
                            data: [{            
                                value: <?php echo round($automacao_porc) ?>
                            }]
                        }]
                    };

                    if (optionn && typeof optionn === 'object') {
                        myChart_automacao.setOption(option_automacao);
                    }
                </script>
                @endif
            </div>
            <div class="card-body txtcenter" style="margin-top: -10px;"> 
                <div class="progress mb-1" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo round($porc_automacao_hora) ?>%; background-color: #5ec762 !important;" aria-valuenow="<?php echo round($porc_automacao_hora) ?>" aria-valuemin="<?php echo round($porc_automacao_hora) ?>"
                     aria-valuemax="<?php echo round($porc_automacao_hora) ?>"></div>
                </div>
            </div>
        </div>        
    </div>

    <div class="col-md-2" data-aos=fade-left data-aos-delay=50 data-aos-anchor="#filtrosfull" >
        <div class="card"  style="position: relative;">
            <div class="card-header">
                <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$lista_contrato_tipo['pura_pess']}}</h6>
                <div class="row">
                    <div class="col-7" style="margin: 0; padding:0; padding-left: 10px">
                        <h5 style="font-weight: 500;" class="titipequeno">Pura</h5>
                        <?php   $porc_pura_hora = $lista_contrato_tipo['pura_hora'] * 100 / $totais['total_time']; 
                                $pura_custo = explode(",", $lista_contrato_tipo['pura_custo']);
                                $pura_custo = str_replace(".", "", $pura_custo[0]);

                                if($pura_custo !== "0"){
                                    $pura_porc = $pura_custo * 100 / $somatotalok; 
                                }else{
                                    $pura_porc = 0;
                                }
                     
                        ?>
                        @if(Auth::user()->perfil == 2)<h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">$ {{$lista_contrato_tipo['pura_custo']}}</h6>@endif
                        <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$lista_contrato_tipo2['pura_hora']}} hs</h6>
                    </div>
                    @if(Auth::user()->perfil == 2)<div class="col-5" id="horas_pura" style="margin: 0; padding:0;"></div>@endif
                </div>
                @if(Auth::user()->perfil == 2)
                <script>
                    var domm = document.getElementById("horas_pura");
                    var myChart_pura = echarts.init(domm);
                    var app = {};
                    var option_pura;
                    option_pura = {
                        series: [{
                            type: 'gauge',
                            progress: {
                                show: true,
                                width: 4
                            },
                            axisLine: {
                            
                                lineStyle: {
                                    width: 4
                                }
                            },
                            axisTick: {
                                show: false
                            },
                            splitLine: {         
                                show: false,

                            
                            },
                            axisLabel: {
                                distance: 5,
                                color: '#6a82cf',
                                fontSize: 20,
                                show: false,
                            },
                            pointer: {
                                show: false,
                                size: 0,
                                itemStyle: {
                                    borderWidth: 0
                                }
                            },
                            anchor: {
                                show: false,
                            },
                            title: {
                                show: false
                            },
                            detail: {
                                valueAnimation: true,
                                color: '#6a82cf',
                                fontSize: 12,
                                offsetCenter: [0, '0%'],
                                formatter: '{value}%',
                            },
                            data: [{            
                                value: <?php echo round($pura_porc) ?>
                            }]
                        }]
                    };

                    if (optionn && typeof optionn === 'object') {
                        myChart_pura.setOption(option_pura);
                    }
                </script>
                @endif
            </div>
            <div class="card-body txtcenter" style="margin-top: -10px;"> 
                <div class="progress mb-1" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo round($porc_pura_hora) ?>%; background-color: #5ec762 !important;" aria-valuenow="<?php echo round($porc_pura_hora) ?>" aria-valuemin="<?php echo round($porc_pura_hora) ?>"
                     aria-valuemax="<?php echo round($porc_pura_hora) ?>"></div>
                </div>
            </div>
        </div>        
    </div>

    <div class="col-md-2" data-aos=fade-left data-aos-delay=60 data-aos-anchor="#filtrosfull" >
        <div class="card" style="position: relative;">
            <div class="card-header">
                <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$lista_contrato_tipo['sabesp_pess']}}</h6>
                <div class="row">
                    <div class="col-7" style="margin: 0; padding:0; padding-left: 10px">
                        <h5 style="font-weight: 500;" class="titipequeno">Sabesp</h5>
                        <?php   $porc_sabesp_hora = $lista_contrato_tipo['sabesp_hora'] * 100 / $totais['total_time']; 
                                $sabesp_custo = explode(",", $lista_contrato_tipo['sabesp_custo']);
                                $sabesp_custo = str_replace(".", "", $sabesp_custo[0]);

                                if($sabesp_custo !== "0"){
                                    $sabesp_porc = $sabesp_custo * 100 / $somatotalok; 
                                }else{
                                    $sabesp_porc = 0;
                                }
                           
                        ?>
                        @if(Auth::user()->perfil == 2)<h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">$ {{$lista_contrato_tipo['sabesp_custo']}}</h6>@endif
                        <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$lista_contrato_tipo2['sabesp_hora']}} hs</h6>
                    </div>
                    @if(Auth::user()->perfil == 2)<div class="col-5" id="horas_sabesp" style="margin: 0; padding:0;"></div>@endif
                </div>
                @if(Auth::user()->perfil == 2)
                    <script>
                        var domm = document.getElementById("horas_sabesp");
                        var myChart_sabesp = echarts.init(domm);
                        var app = {};
                        var option_sabesp;
                        option_sabesp = {
                            series: [{
                                type: 'gauge',
                                progress: {
                                    show: true,
                                    width: 4
                                },
                                axisLine: {
                                
                                    lineStyle: {
                                        width: 4
                                    }
                                },
                                axisTick: {
                                    show: false
                                },
                                splitLine: {         
                                    show: false,

                                
                                },
                                axisLabel: {
                                    distance: 5,
                                    color: '#6a82cf',
                                    fontSize: 20,
                                    show: false,
                                },
                                pointer: {
                                    show: false,
                                    size: 0,
                                    itemStyle: {
                                        borderWidth: 0
                                    }
                                },
                                anchor: {
                                    show: false,
                                },
                                title: {
                                    show: false
                                },
                                detail: {
                                    valueAnimation: true,
                                    color: '#6a82cf',
                                    fontSize: 12,
                                    offsetCenter: [0, '0%'],
                                    formatter: '{value}%',
                                },
                                data: [{            
                                    value: <?php echo round($sabesp_porc) ?>
                                }]
                            }]
                        };

                        if (optionn && typeof optionn === 'object') {
                            myChart_sabesp.setOption(option_sabesp);
                        }
                    </script>
                @endif
            </div>
            <div class="card-body txtcenter" style="margin-top: -10px;"> 
                <div class="progress mb-1" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo round($porc_sabesp_hora) ?>%; background-color: #5ec762 !important;" aria-valuenow="<?php echo round($porc_sabesp_hora) ?>" aria-valuemin="<?php echo round($porc_sabesp_hora) ?>"
                     aria-valuemax="<?php echo round($porc_sabesp_hora) ?>"></div>
                </div>
            </div>
        </div>        
    </div>

    


<?php
    // echo '<pre>';
    // var_dump($totais);
    // echo '</pre>';
?>


<script>
    var cadrpativo = 'Obra';

$('.cardpeque').on('click',function(){   
   
    var str = $(this).data('id');
    if(cadrpativo === str){
        cadrpativo = 'Todos';
        str = 'Todos';   
    }else{
        $('.cardpeque').removeClass('active'); 
        cadrpativo = str;
        $(this).addClass('active');        
        carregar_cards('card_contratos',str); 

    }

});
</script>