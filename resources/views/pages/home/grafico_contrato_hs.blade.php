@if(Auth::user()->perfil == 2) 
<div class="nocelular" style="float: right; margin-top: -40px; margin-right: 15px">
    <h6 ><span style="color: #5ec762; font-weight: 600; ">{{$contrato_ativo}}: <i class="far fa-clock"></i>  <?php echo horas_segundos($tipo_hora); ?> HS</span>  
            <span style="margin-left: 20px;color: #08650b; font-weight: 600; "> Total: <i class="far fa-clock"></i> <?php echo horas_segundos($total_horas[0]->total); ?> HS</span>
    </h6>
</div>
@endif
<div class="card-body txtcenter" style="padding:0; margin:0; width:100%; "> 
    <div class="row">
        <div class="col-md-8" >
            <div id="grafico_contrato_hs" class="divgrafico" style="height: 550px; margin-left:-20px "></div> 
        </div>                          
        <div class="col-md-4 chardcardrigh" style="text-align: left; ">
            <div style="margin-top: -20px;">
                <?php $total_segundos = $total_horas[0]->total; $contlist = 0 ?>
                @foreach($lista_contratos as $key => $value)                
                    @if($value['id'] !== 70 )
                        @if($contlist < 3)
                            <?php 
                                $porcentag = $value['total'] * 100 / $total_segundos; 
                                $porcentag2 = $value['total'] * 100 / $tipo_hora;                            
                            ?>
                            <div class="card cadintc" data-aos=fade-left data-aos-delay=200 data-aos-anchor="#filtrosfull">
                                <span class="nomecardp">{{$value['ctnome']}}</span>
                                
                                <div class="row" style="margin:0; padding:0">
                                    <div class="col-md-6" style=" padding-top:20px">
                                        <h5 style="font-weight: 500; color: #5ec762; font-size: 15px"><i class="far fa-clock"></i> <?php echo horas_segundos($value['total']) ?></h5>                           
                                        <h5 style="font-weight: 500; color: #777; font-size: 16px; margin-top:-10px; margin-bottom: 0; padding-bottom:0"><i class="fas fa-running"></i>  {{$value['totaluser']}} </h5>       
                                        <span style="font-weight: 700; font-size:10px; color: #5ec762;">TIPO</span> <span style="font-weight: 700; font-size:10px; color: #08650b;">TOTAL</span>                       
                                    </div>
                                    <div class="col-md-6"  style="margin:0; padding:0">
                                        <div id="hora{{$value['id']}}" style="width: 100%; height: 100px"></div>
                                    </div>
                                    <script>
                                            var dom<?php echo$value['id'] ?> = document.getElementById("hora{{$value['id']}}");
                                            var myChart<?php echo$value['id'] ?> = echarts.init(dom<?php echo$value['id'] ?>);
                                            var app = {};

                                            var option<?php echo$value['id'] ?>;
                                            option<?php echo$value['id'] ?> = {
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
                                                        itemStyle: { color: '#08650b' }
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
                                                        itemStyle: { color: '#5ec762' }
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

                                            if (option<?php echo$value['id'] ?> && typeof option<?php echo$value['id'] ?> === 'object') {
                                                myChart<?php echo$value['id'] ?>.setOption(option<?php echo$value['id'] ?>);
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
        <button type="button" id="btvolta_contato" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> lista completa</button>   
    </div>
</div>
<script>

    var chartContrato_hs  = echarts.init(document.querySelector('#grafico_contrato_hs'), null);	
    var app = {};
    var option_hs;
    option_hs = {
        title: {
            show: false,
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            },    

            formatter: function (params) {
                // return `<pre class="pretoltip"><span class="tolname">${params[0].data.name}</span><br><div class="divvalores"><span class="tolcusto">R$ ${params[0].data.custo}</span><br><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${params[0].data.value} hs</span><br><span class="tolhora"> <i class="fas fa-walking" style="color: #727f93;"></i> ${params[0].data.pess} </span></div></pre>`
                return `<pre class="pretoltip"><span class="tolname">${params[0].data.name}</span><br><div class="divvalores"><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${params[0].data.value} hs</span><br><span class="tolhora"> <i class="fas fa-walking" style="color: #727f93;"></i> ${params[0].data.pess} </span></div></pre>`
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
                        if($cont01 < 10){
                            if($value['id'] !== 70 && $value['id'] !== 148){
                                echo '"'.horas_segundos2($value['total']).'hs",';
                                $cont01 = $cont01 + 1;
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
                                echo '{value: '. horas_segundos2($value['total']).', pess: "'. $value['totaluser'].'",   custo: "'. $value['custo'].'", name: "'.$value['ctnome'].'", itemStyle: { color: "rgb( 94, 199, 98, 0.'.$cont_cor.'8)" }},'; 
                                $cont02 = $cont02 + 1;
                                $cont_cor = $cont_cor - 1;
                            }
                            
                        }
                        
                    }    
                    ?>
                    
                ]
            }

        ]
    };
    chartContrato_hs.setOption(option_hs);
    window.addEventListener('resize',function(){
        chartContrato_hs.resize();
    });

    $('#btvolta_contato').on('click',function(){        
        $('#front_contrato1').addClass('virar-front');            
        $('#back_contrato1').addClass('virar-back');            
    });

    

</script>