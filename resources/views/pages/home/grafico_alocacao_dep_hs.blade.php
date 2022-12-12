<?php
    // dd($total_horas[0]->total);
  

    $totalhoras = (int)$total_horas[0]->total;
    $porcentagem1 = ($totaldepH / $totalhoras) * 100;
    $porcentagem1 = round ($porcentagem1);
    $texto = horas_segundos2($totaldepH).'hs'. '\n'.$porcentagem1.'%';
    
?> 

<div id="grafico_alocacao_dep_hs" style="height: 400px; width: 100%;"></div>


<script>

var chartalocacao_dep_hs  = echarts.init(document.querySelector('#grafico_alocacao_dep_hs'), null);	
    var app = {};
    var option_ALO_hs;
    option_ALO_hs = {
        title: {
            text: '<?php echo $texto ?>'+' do total',
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
                return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5"> ${params.name} </span><div class="divvalores"><span class="tolname" style="color:#002856"> <i class="far fa-clock" style="color: #727f93;"></i> ${params.value} hs</span></div></pre>`
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
                        return params.name+'\n\n'+params.percent+'%'                        
                    }
                },


                data: [
                    <?php
                    $cont_cor = 9;
                    foreach($lista_contratos_horas as $value){
                            echo '{';
                            echo 'value: '.horas_segundos2($value->total).', name: "'.$value->aldescricao.'", itemStyle: { color: "rgb( 67, 180, 71, 0.'.$cont_cor.'9)" }' ;
                            echo '},';
                            $cont_cor = $cont_cor - 2;
                        }    
                    ?>

                ],
                emphasis: {
                    itemStyle: {
                        // shadowBlur: 10,
                        shadowOffsetX: 0,
                        color: '#5ec762'
                        // shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    chartalocacao_dep_hs.setOption(option_ALO_hs);

    window.addEventListener('resize',function(){
        chartalocacao_dep_hs.resize();
    });
</script>