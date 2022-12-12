<div id="grafico_alocacao_rs" style="height: 400px; width: 100%;"></div>


<?php
    // echo '<pre>';
    // var_dump($lista_alocacoes);
    // echo '</pre>';
    $lista_alocacoes = collect($lista_alocacoes)->sortBy('custo')->reverse()->toArray();
    //  dd($lista_alocacoes);
?> 

<script>

    var chartalocacao_rs  = echarts.init(document.querySelector('#grafico_alocacao_rs'), null);	
    var app = {};
    var option_ALO_rs;

    option_ALO_rs = {
        color: ['#2f558a'],
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            top: '0',
            containLabel: true
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {            // Use axis to trigger tooltip
                type: 'line'        // 'shadow' as default; can also be 'line' or 'shadow'
            },
            formatter: function (params) {
                return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5"> ${params[0].name} </span><div class="divvalores"><span class="tolname" style="color:#002856"> R$ ${number_format(params[0].data.value, 0, ',', '.')   } </span><br><span class="tolhora"> <i class="fas fa-walking" style="color: #727f93;"></i> ${params[0].data.pess} </span></div></pre>`             
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
                    echo '{value: "'. $value['custo'].'", pess: "'. $value['totaluser'].'",   horas: "'. horas_segundos2($value['total']).'", itemStyle: { color: "rgb( 47, 85, 138, 0.'.$cont_cor.'9)" }},'; 
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
                    val = number_format(d.data.value, 0, ',', '.'); 
                    return val;
                }
            }
        }]
    };
    chartalocacao_rs.setOption(option_ALO_rs);

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

    window.addEventListener('resize',function(){
        chartalocacao_rs.resize();
    });

</script>