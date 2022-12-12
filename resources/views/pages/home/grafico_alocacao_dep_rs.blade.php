<?php
    $totalvalores = (int)$soma_valor_t;
    $porcentagem2 = ($totaldepR / $totalvalores) * 100;
    $porcentagem2 = round ($porcentagem2);
    $texto2 = 'R$ '.number_format($totaldepR,2, ',', '.').'\n'.$porcentagem2.'% ';
    // $lista_alocacoes = collect($lista_alocacoes)->sortBy('custo')->reverse()->toArray();
    //  dd($lista_alocacoes); 

?> 

<div id="grafico_alocacao_dep_rs" style="height: 400px; width: 100%;"></div>

<script>
var chartalocacao_dep_rs  = echarts.init(document.querySelector('#grafico_alocacao_dep_rs'), null);	
    var app = {};
    var option_ALO_rs;
    option_ALO_rs = {
        title: {
            text: '<?php echo $texto2 ?>'+' do total',
            subtext: '',
            left: 'center',
            textStyle: {
                fontWeight: 'bold',
                fontSize: 14,
            },
            top: '45%'
        },
        tooltip: {
            trigger: 'item',
            formatter: function (params) {
                return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5"> ${params.name} </span><div class="divvalores"><span class="tolname" style="color:#002856"> R$ ${number_format(params.data.value, 0, ',', '.')   }</span><br><span class="tolhora"> <i class="fas fa-walking" style="color: #727f93;"></i> ${params.data.pess} </span></div></pre>`             
            } 
        },
        series: [
            {
                name: '',
                type: 'pie',
                radius: ['40%', '70%'],
                itemStyle: {
                    borderRadius: 10,
                    borderColor: '#fff',
                    borderWidth: 2
                },
                label: {
                    position: 'inner',
                    fontSize: 12,
                    color: "black",
                    formatter: function (params) {
                        return params.data.name+'\n\n'+params.percent+'%';                        
                    }
                },
                data: [
                    <?php
                    $cont_cor = 9;
                    foreach($lista_alocacoes as $value){
                        
                        if(isset($value['custo'])){

                        
                            // print_r($value['custo']);
                            // ${number_format(params[0].data.value, 0, ',', '.')   }
                        
                            echo '{';
                            // echo 'value: '.$value['custo'].', name: "'.$value['aldescricao'].'", pess: "'. $value['totaluser'].'",   horas: "'. horas_segundos2($value['total']).'", itemStyle: { color: "rgb( 72, 103, 146, 0.'.$cont_cor.'9)" }';
                            echo 'value: '.$value['custo'].', name: "'.$value['aldescricao'].'", pess: "'. $value['totaluser'].'",   horas: "'. horas_segundos2($value['total']).'", itemStyle: { color: "rgb( 72, 103, 146, 0.'.$cont_cor.'9)" }';
                            echo '},';
                            $cont_cor = $cont_cor - 2;
                        }
                    }    
                    ?>

                ],
                emphasis: {
                    itemStyle: {
                        shadowOffsetX: 0,
                        color: '#486792'
                    }
                }
            }
        ]
    };
    chartalocacao_dep_rs.setOption(option_ALO_rs);

 

    window.addEventListener('resize',function(){
        chartalocacao_dep_rs.resize();
    });
</script>