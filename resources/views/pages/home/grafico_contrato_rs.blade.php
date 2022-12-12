<?php



?>
@if(Auth::user()->perfil == 2) 
<div style="float: right; margin-top: -40px; margin-right: 15px">
    <h6 ><span style="color: #6a82cf ; font-weight: 600; "> {{$contrato_ativo}}: R$ {{$tipo_valor}} </span>  
            <span style="margin-left: 20px;color: #2f558a; font-weight: 600; "> Total:  R$ {{$soma_valor}}</span>
    </h6>
</div>
@endif
<div class="card-body txtcenter" style="padding:0; margin:0; width:100%; "> 
    <div class="row">
        <div class="col-md-8" >
            <div id="grafico_contrato_rs" class="divgrafico" style="height: 500px; margin-left:-20px "></div> 
        </div>                          
        <div class="col-md-4 chardcardrigh" style="text-align: left; ">
            <div style="margin-top: -20px;">
                <?php $total_segundos = $total_horas[0]->total; $contlist = 0 ?>
                @foreach($lista_contratos as $key => $value)
                    @if($value['id'] !== 70 )
                        @if($contlist < 3)
                            <?php
                                $somatotal = explode(",", $soma_valor);
                                $somatotalok = str_replace(".", "", $somatotal[0]);

                                $somatotal2 = explode(",", $tipo_valor);
                                $somatotalok2 = str_replace(".", "", $somatotal2[0]);
                                
                                $somaind = explode(",", $value['custo']);
                                $somaindok = str_replace(".", "", $somaind[0]);

                                if($somatotalok !== '0' && $somatotalok2 !== '0'){
                                    $porcentag = $somaindok * 100 / $somatotalok;
                                    $porcentag2 = $somaindok * 100 / $somatotalok2;  
                                }else{
                                    $porcentag = 0;
                                    $porcentag2 = 0;
                                }
                            ?>
                            <div class="card cadintc" data-aos=fade-left data-aos-delay=200 data-aos-anchor="#filtrosfull">
                                <span class="nomecardp">{{$value['ctnome']}}</span>
                                <div class="row" style="margin:0; padding:0">
                                    <div class="col-md-6" style=" padding-top:20px">
                                        <h5 style="font-weight: 500; color: #6a82cf; font-size: 15px"> R$ <?php echo $value['custo'] ?> </h5>                           
                                        <h5 style="font-weight: 500; color: #777; font-size: 16px; margin-top:-10px; margin-bottom: 0; padding-bottom:0"><i class="fas fa-running"></i>  {{$value['totaluser']}} </h5>      
                                        <span style="font-weight: 800; font-size:10px; color: #6a82cf;">TIPO</span> <span style="font-weight: 800 !important; font-size:10px; color: #2f558a;">TOTAL</span>                     
                                    </div>
                                    <div class="col-md-6"  style="margin:0; padding:0">
                                        <div id="horaa{{$value['id']}}" style="width: 100%; height: 100px"></div>
                                    </div>
                                    <script>
                                            var domm<?php echo$value['id'] ?> = document.getElementById("horaa{{$value['id']}}");
                                            var myChartt<?php echo$value['id'] ?> = echarts.init(domm<?php echo$value['id'] ?>);
                                            var app = {};

                                            var optionn<?php echo$value['id'] ?>;
                                            optionn<?php echo$value['id'] ?> = {
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
                                                            width: 10
                                                            // ,color: [
                                                            //     [0.3, '#67e0e3'],
                                                            //     [0.7, '#ccc'],
                                                            //     [1, '#fd666d']
                                                            // ]
                                                            
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
                                                    data: [{
                                                        value: <?php echo round($porcentag)?>,
                                                        // name: 'Perfect',
                                                        title: {
                                                            offsetCenter: ['0%', '-30%']
                                                        },
                                                        detail: {
                                                            offsetCenter: ['0%', '-20%']
                                                        },
                                                        itemStyle: { color: '#2f558a' }
                                                    },
                                                    {
                                                        value: <?php echo round($porcentag2)?>,
                                                        // name: 'Good',
                                                        title: {
                                                            offsetCenter: ['0%', '-10%']
                                                        },
                                                        detail: {
                                                            offsetCenter: ['0%', '30%']
                                                        },
                                                        itemStyle: { color: '#6a82cf' }
                                                    }
                                                    ],
                                                    title: {
                                                        fontSize: 14
                                                    },
                                                    detail: {
                                                        width: 50,
                                                        height: 14,
                                                        fontSize: 14,
                                                        color: 'auto',
                                                        // borderColor: 'auto',
                                                        // borderRadius: 20,
                                                        // borderWidth: 1,
                                                        formatter: '{value}%'
                                                    }
                                                }]
                                            // series: [{
                                                //     type: 'gauge',
                                                //     progress: {
                                                //         show: true,
                                                //         width: 5
                                                //     },
                                                //     axisLine: {
                                                    
                                                //         lineStyle: {
                                                //             width: 5
                                                //         }
                                                //     },
                                                //     axisTick: {
                                                //         show: false
                                                //     },
                                                //     splitLine: {         
                                                //         show: false,

                                                    
                                                //     },
                                                //     axisLabel: {
                                                //         distance: 5,
                                                //         color: '#999',
                                                //         fontSize: 20,
                                                //         show: false,
                                                //     },
                                                //     pointer: {
                                                //         show: true,
                                                //         size: 1,
                                                //         itemStyle: {
                                                //             borderWidth: 1
                                                //         }
                                                //     },
                                                //     anchor: {
                                                //         show: false,
                                                //     },
                                                //     title: {
                                                //         show: false
                                                //     },
                                                //     detail: {
                                                //         valueAnimation: true,
                                                //         fontSize: 15,
                                                //         offsetCenter: [0, '70%'],
                                                //         formatter: '{value}%',
                                                //     },
                                                //     data: [{            
                                                //         value: <?php echo round($porcentag)?>
                                                //     }]
                                            // }]
                                            };

                                            if (optionn<?php echo$value['id'] ?> && typeof optionn<?php echo$value['id'] ?> === 'object') {
                                                myChartt<?php echo$value['id'] ?>.setOption(optionn<?php echo$value['id'] ?>);
                                            }
                                    </script>
                                </div>                
                            </div>
                            <?php $contlist = $contlist + 1 ?>
                        @endif
                    @endif                    
                @endforeach
            </div>            
        </div>
    </div>
</div>
<div class="row" style="padding: 10px; margin-top:-55px">
    <div class="col-sm-12" style="margin-top: 10px;">                   
        <button type="button" id="btvolta_contato1" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> lista completa</button>   
    </div>
</div>


<script>
    var chartContrato_rs  = echarts.init(document.querySelector('#grafico_contrato_rs'), null);	
    var app = {};
    var option_rs;
    option_rs = {
        title: {
            show: false,
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            },        
            formatter: function (params) {
                return `<pre class="pretoltip"><span class="tolname">${params[0].data.name}</span><br><div class="divvalores"><span class="tolcusto">R$ ${params[0].data.custo}</span><br><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${params[0].data.value} hs</span><br><span class="tolhora"> <i class="fas fa-walking" style="color: #727f93;"></i> ${params[0].data.pess} </span></div></pre>`
            },
            
        },
        
        legend: {
            data: []
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '50px',
            containLabel: true
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type:"category",
            inverse:true,
            data: [
                <?php
                $cont01 = 0;
                    foreach($lista_contratos as $value){
                        $cont01 = $cont01 + 1;
                        if($cont01 < 11){
                            if($value['id'] !== 70 && $value['id'] !== 148){
                                echo '"R$ '.$value['custo'].'",';
                            }
                        }
                    }    
                    ?>
            ]        
        },
        series: [
            {
                type: 'bar',
                label: {
                    show: true,
                    fontSize: 12,
                    position:"insideLeft",
                    color: "black",
                    borderColor : '#ccc',
                    formatter: function(d) {           
                        return d.name; //+ ' ' + d.data;
                    
                    }
                },
                data: [
                    <?php
                    $cont02 = 0;
                    $cont_cor = 9;
                    foreach($lista_contratos as $value){                   
                        if($cont02 < 10){
                            if($value['id'] !== 70 && $value['id'] !== 148){
                                echo '{value: '. horas_segundos2($value['total']).', pess: "'. $value['totaluser'].'",   custo: "'. $value['custo'].'", name: "'.$value['ctnome'].'", itemStyle: { color: "rgb( 52, 110, 177, 0.'.$cont_cor.'8)" }},'; 
                                }
                                $cont02 = $cont02 + 1;
                                $cont_cor = $cont_cor - 1;
                            }
                    }    
                    ?>
                    
                ]
            }

        ]
    };
    chartContrato_rs.setOption(option_rs);
    window.addEventListener('resize',function(){
        chartContrato_rs.resize();
    });

    $('#btvolta_contato1').on('click',function(){        
        $('#front_contrato1').addClass('virar-front');            
        $('#back_contrato1').addClass('virar-back');            
    });

</script>