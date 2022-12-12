
<div class="card-body txtcenter" style="padding:0; margin:0; width:100%; "> 
    <div class="row">
        <div class="col-md-12" style=" padding:0; margin:0; padding-right: 20px">        
            <div id="grafico_alocacao_hs" style="height: 600px; width: 100%;  "></div> 
        </div>                          
    </div>
</div>
<div class="row" style="padding: 10px; margin-top:-55px">
    <div class="col-sm-12" style="margin-top: 10px;">                   
        <button type="button" id="btvolta_alo" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> lista completa</button>   
    </div>
</div>




<script>

    var chartalocacao_hs  = echarts.init(document.querySelector('#grafico_alocacao_hs'), null);	
    var app = {};
    var option_hs;
    option_hs = {
         tooltip: {
             formatter: function (params) {
                 horas = number_format(params.data.horas, 0, ',', '.'); 
                 custo = number_format(params.data.custo, 0, ',', '.');
                //  return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5">${params.data.departamento}</span><div class="divvalores"><span class="tolname" style="color:#002856">${params.data.alocacao}</span><br><span class="tolcusto">R$ ${custo}</span><br><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${horas} hs</span></div></pre>`
                 return `<pre class="pretoltip"><span class="tolname" style="color:#3b95f5">${params.data.departamento}</span><div class="divvalores"><span class="tolname" style="color:#002856">${params.data.alocacao}</span><br><span class="tolhora"> <i class="far fa-clock" style="color: #727f93;"></i> ${horas} hs</span></div></pre>`
             },
        },
        grid: {
            left: '4%',
            width: '96%',
            containLabel: true
        },
        xAxis: {
            type: 'category', //departamentos
            data: [
                <?php
                    foreach($lista_dep as $value){  
                        // if($value->id !== 16 && $value->id !== 14){
                            $dpdescri = mb_strimwidth($value->depnome, 0, 10, "...");                   
                            // echo '"'.$dpdescri.'",'; 
                             echo '{ value:"'.$dpdescri.'", name2:"'.$value->depnome.'"},'; 
                            
                        // }                      
                    }
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
            type: 'category', // alocacaos
            inverse: true,
            axisLabel: {
                textStyle: {
                    color: '#002856',
                    
                }
            },
            data: [
                <?php
                    $cont_alv = 0;
                     foreach($lista_alocacaos as $key => $value){
                         if($cont_alv <= 10){
                            $atdescri = mb_strimwidth($value['aldescricao'], 0, 20, "...");  
                            echo '"'.$atdescri.'",';  
                         }
                         $cont_alv =  $cont_alv +1;
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
            max: <?php echo horas_segundos_sem($lista_alocacaos[0]['total'] /2) ?>,
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
                   
                    $cont_dp = 0;
                    $cont_al = 0;

                    foreach($lista_alocacaos as $key => $value){
                        $tipopro = $value['tipodep'];
                        $cont_dp = 0;    
                    
                        foreach($tipopro as $key2 => $value2){
                            $valseg = horas_segundos_sem($value2['hs']);
                            $valcust1 = explode(".", $value2['vl']);
                            echo '{value:['.$cont_dp.','. $cont_al.','.$valseg.'], alocacao:["'.$value['aldescricao'].'"], custo:["'.$valcust1[0].'"], horas:["'.$valseg.'"], departamento:["'.$value2['nome'].'"]},';
                            
                            $cont_dp = $cont_dp + 1;                            
                        }                        
                        $cont_al = $cont_al + 1;                  
                    }                     
                ?>
            ],
            label: {
                normal: {
                    show: true,
                    formatter: (param) => {
                        // console.log(param);
                        return number_format(param.data.value[2], 0, ',', '.'); 
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
    chartalocacao_hs.setOption(option_hs);
    // window.addEventListener('resize',function(){
    //     chartalocacao_hs.resize();
    // });

    $('#btvolta_alo').on('click',function(){        
        $('#front_alocacaos1').addClass('virar-front');            
        $('#back_alocacaos1').addClass('virar-back');        
        $('.bthorafin').hide();             
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

        chartalocacao_hs.resize();

}, 500);

</script>