
<div id="grafico_alocacao_hs" style="height: 400px; width: 100%;"></div>


<?php
    // echo '<pre>';
    // var_dump($lista_alocacoes);
    // echo '</pre>';
?> 

<script>

var chartalocacao  = echarts.init(document.querySelector('#grafico_alocacao_hs'), null);	
    var app = {};
    var option_ALO;

    option_ALO = {
        // color: ['#2f558a'],
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            top: '0',
            containLabel: true
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {           
                type: 'line'      
            },
            formatter: function (params) {
                return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5"> ${params[0].name} </span><div class="divvalores"><span class="tolname" style="color:#002856"> <i class="far fa-clock" style="color: #727f93;"></i> ${params[0].data.value} hs</span><br><span class="tolhora"> <i class="fas fa-walking" style="color: #727f93;"></i> ${params[0].data.pess} </span></div></pre>`             
            },
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            inverse:true,
            data: [
                <?php
                    foreach($lista_alocacoes as $value){
                        echo '"'.$value['aldescricao'].'",';
                    }    
                ?>
                ]
        },
        series: [{
            data: [
                <?php
                $cont_cor = 9;
                foreach($lista_alocacoes as $value){
                    echo '{value: '. horas_segundos2($value['total']).', pess: "'. $value['totaluser'].'",   custo: "'. $value['custo'].'", itemStyle: { color: "rgb( 67, 180, 71, 0.'.$cont_cor.'9)" }},'; 
                    $cont_cor = $cont_cor - 1;
                }    
            ?>
            ],
            type: 'bar',
            label: {
                show: true,
                fontSize: 12,
                position: 'right',
                color: "black",
                formatter: function(d) {
                    return d.data.value+"hs";
                }
            }
        }]
    };
    chartalocacao.setOption(option_ALO);

    setTimeout(function () {
        chartalocacao.resize();
    }, 500);

    window.addEventListener('resize',function(){
        chartalocacao.resize();
    });

</script>