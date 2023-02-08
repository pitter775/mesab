
<div class="card-body txtcenter" style="padding:0; margin:0; width:100%; "> 
    <div class="row">
        <div class="col-md-9" style=" padding:0; margin:0">
        
            <div id="grafico_atividade_hs" style="height: 600px; width: 100%;  "></div> 
        </div>                          
        <div class="col-md-3 chardcardrigh" style="text-align: left; ">
            <div style="margin-top: 65px;">
                <?php $total_segundos = $total_horas[0]->total; $contlistat = 0;?>
                @foreach($lista_atividades as $key => $value)  
                    @if($contlistat < 3)
                    <?php 
                        $porcentag = $value['total'] * 100 / $total_segundos; 
                    ?>
                    <div class="card cadintc" data-aos=fade-left data-aos-delay=200 data-aos-anchor="#filtrosfull">
                        <span class="nomecardp">{{$value['atdescricao']}}</span>
                        <div class="row" style="margin:0; padding:0">
                            <div class="col-md-6" style="padding:0; margin:0; padding-top:20px">
                                <h5 style="font-weight: 500; color: #08650b; font-size: 15px"><i class="far fa-clock"></i> <?php echo horas_segundos($value['total']) ?></h5>                           
                                <h5 style="font-weight: 500; color: #777; font-size: 16px; margin-top:-10px; margin-bottom: 0; padding-bottom:0"><i class="fas fa-running"></i>  {{$value['totaluser']}} </h5>                                       
                            </div>
                            <div class="col-md-6"  style="margin:0; padding:0">
                                <div id="hora{{$value['id']}}" style="width: 100%; height: 100px"></div>
                            </div>
                            <script>
                                var dom<?php echo$value['id'] ?> = document.getElementById("hora{{$value['id']}}");
                                var myChartat<?php echo$value['id'] ?> = echarts.init(dom<?php echo$value['id'] ?>);
                                var app = {};

                                var optionat<?php echo$value['id'] ?>;
                                optionat<?php echo$value['id'] ?> = {
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
                                                offsetCenter: ['0%', '0%']
                                            },
                                            itemStyle: { color: '#08650b' }
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
                                            formatter: '{value}%'
                                        }
                                    }]
                                
                                };

                                if (optionat<?php echo$value['id'] ?> && typeof optionat<?php echo$value['id'] ?> === 'object') {
                                    myChartat<?php echo$value['id'] ?>.setOption(optionat<?php echo$value['id'] ?>);
                                }
                            </script>
                        </div>
                    
                    </div>
                    <?php $contlistat = $contlistat + 1 ?>
                    @endif
                @endforeach
          
            </div>           
        </div>
    </div>
</div>
<div class="row" style="padding: 10px; margin-top:-55px">
    <div class="col-sm-12" style="margin-top: 10px;">                   
        <button type="button" id="btvolta_atv" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> lista completa</button>   
    </div>
</div>


<script>

    var chartatividade_hs  = echarts.init(document.querySelector('#grafico_atividade_hs'), null);	
    var app = {};
    var option_hs;
    option_hs = {
         tooltip: {
             formatter: function (params) {
                 horas = number_format(params.data.horas, 0, ',', '.'); 
                 custo = number_format(params.data.custo, 0, ',', '.');
                //  return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5">${params.data.produto}</span><div class="divvalores"><span class="tolname" style="color:#002856">${params.data.atividade}</span><br><span class="tolcusto">R$ ${custo}</span><br><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${horas} hs</span></div></pre>`
                 return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5">${params.data.produto}</span><div class="divvalores"><span class="tolname" style="color:#002856">${params.data.atividade}</span><br><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${horas} hs</span></div></pre>`
             },
        },
        grid: {
            left: '4%',
            width: '96%',
            containLabel: true
        },
        xAxis: {
            type: 'category', //produtos
            data: [
                <?php
                    // foreach($lista_prod as $value){  
                    //     if($value->id !== 16 && $value->id !== 14){
                    //         $prdescri = mb_strimwidth($value->prdescricao, 0, 10, "...");                   
                    //         // echo '"'.$prdescri.'",'; 
                    //          echo '{ value:"'.$prdescri.'", name2:"'.$value->prdescricao.'"},'; 
                            
                    //     }                      
                    // }
                    // echo '"Total"'; 
                    echo '{ value:"Total", name2:"Total"},'; 
                ?>
                ],
            position: 'top',
            splitArea: {
                show: true
            },
            axisLabel: {
                textStyle: {
                    color: '#3b95f5',
                }
            },
        },
        yAxis: {
            type: 'category', // atividades
            inverse: true,
            axisLabel: {
                textStyle: {
                    color: '#002856',
                    
                }
            },
            data: [
                <?php
                    $cont_atv = 0;
                     foreach($lista_atividades as $key => $value){
                         if($cont_atv <= 10){
                            $atdescri = mb_strimwidth($value['atdescricao'], 0, 20, "...");  
                            echo '"'.$atdescri.'",';  
                         }
                         $cont_atv =  $cont_atv +1;
                    }    
                ?>                
                ],
            splitArea: {
                show: true
            }
        },
        visualMap: {
            show: false,
            min: 0,
            max: <?php echo horas_segundos_sem($lista_atividades[0]['total'] /2) ?>,
            calculable: true,
            inRange: {
                color: ['#e7fbe8', '#8fd192', '#479a4a', '#08650b']
            }
        },
        series: [{
            name: 'Punch Card',
            type: 'heatmap',
            data: [
                <?php
                   
                    $cont_pr = 0;
                    $cont_at = 0;

                    foreach($lista_atividades as $key => $value){
                        $valseg = horas_segundos_sem($value2['hs']);
                        $valcust1 = explode(".", $value2['vl']);
                        echo '{value:['.$cont_pr.','. $cont_at.','.$valseg.'], atividade:["'.$value['atdescricao'].'"], custo:["'.$valcust1[0].'"], horas:["'.$valseg.'"], produto:["'.$value2['nome'].'"]},';
                       
                        // $tipopro = $value['tipoprod'];
                        // $cont_pr = 0;                 
                        // foreach($tipopro as $key2 => $value2){
                        //     $valseg = horas_segundos_sem($value2['hs']);
                        //     $valcust1 = explode(".", $value2['vl']);
                        //     echo '{value:['.$cont_pr.','. $cont_at.','.$valseg.'], atividade:["'.$value['atdescricao'].'"], custo:["'.$valcust1[0].'"], horas:["'.$valseg.'"], produto:["'.$value2['nome'].'"]},';
                            
                        //     $cont_pr = $cont_pr + 1;                            
                        // }                        
                        $cont_at = $cont_at + 1;                  
                    }                     
                ?>
            ],
            label: {
                normal: {
                    show: true,
                    formatter: (param) => {
                        val = number_format(param.data.value[2], 0, ',', '.'); 
                        if(val == 0){
                            val = '';
                        }
                        // console.log(param);
                        return val
                    }
                },
            },
            coordinateSystem: 'cartesian2d',
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }]
    };
    chartatividade_hs.setOption(option_hs);
    window.addEventListener('resize',function(){
        chartatividade_hs.resize();
    });

    $('#btvolta_atv').on('click',function(){        
        $('#front_atividade1').addClass('virar-front');            
        $('#back_atividade1').addClass('virar-back');   
        $('.bthorafin2').hide();          
    });
    function number_format (number, decimals, dec_point, thousands_sep) {
        // *     example 1: number_format(1234.56);
        // *     returns 1: '1,235'
        // *     example 2: number_format(1234.56, 2, ',', ' ');    // *     returns 2: '1 234,56'
        // *     example 3: number_format(1234.5678, 2, '.', '');
        // *     returns 3: '1234.57'
        // *     example 4: number_format(67, 2, ',', '.');
        // *     returns 4: '67,00'    // *     example 5: number_format(1000);
        // *     returns 5: '1,000'
        // *     example 6: number_format(67.311, 2);
        // *     returns 6: '67.31'
        // *     example 7: number_format(1000.55, 1);    // *     returns 7: '1,000.6'
        // *     example 8: number_format(67000, 5, ',', '.');
        // *     returns 8: '67.000,00000'
        // *     example 9: number_format(0.9, 0);
        // *     returns 9: '1'    // *     example 10: number_format('1.20', 2);
        // *     returns 10: '1.20'
        // *     example 11: number_format('1.20', 4);
        // *     returns 11: '1.2000'
        // *     example 12: number_format('1.2000', 3);    // *     returns 12: '1.200'
        var n = number, prec = decimals;
     
        var toFixedFix = function (n,prec) {
            var k = Math.pow(10,prec);        return (Math.round(n*k)/k).toString();
        };
     
        n = !isFinite(+n) ? 0 : +n;
        prec = !isFinite(+prec) ? 0 : Math.abs(prec);    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
        var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
     
        var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
         var abs = toFixedFix(Math.abs(n), prec);
        var _, i;
     
        if (abs >= 1000) {
            _ = abs.split(/\D/);        i = _[0].length % 3 || 3;
     
            _[0] = s.slice(0,i + (n < 0)) +
                  _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
            s = _.join(dec);    } else {
            s = s.replace('.', dec);
        }
     
        var decPos = s.indexOf(dec);    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
            s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
        }
        else if (prec >= 1 && decPos === -1) {
            s += dec+new Array(prec).join(0)+'0';    }
        return s;
    }

    setTimeout(function () {
        chartatividade_hs.resize();
    }, 500);

</script>