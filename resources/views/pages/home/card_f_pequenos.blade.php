

<?php 
function horas_segundos2($total){
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    return $horas . "." . $minutos;
}

//  dd($soma_valor_t);

foreach($lista_funcaos as $value){ 
    $cargo = $value['fndescricao'];
    if( $cargo == 'Assistente Administrativo e Financeiro') { $cargo = 'Assistente Administrativo';}

    $custo = number_format($value['custo'],2, ',', '.');
    $horas = horas_segundos2($value['total']); 
    $horas = number_format($horas,0, ',', '.');

    if($soma_valor_t !== '0'){
        $obra_porc = $value['custo'] * 100 / $soma_valor_t; 
    }else{
        $obra_porc = 0;
    }

    
    ?>

 
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4" >
            <div class="card cardpeque caduserfun" style="position: relative; height: 110px" data-funcao = "{{$value['fndescricao']}}">
                <div class="card-header">
                    <h6 class="icohear" style="font-weight: 600; color: #777"><i class="fas fa-running"></i> {{$value['totaluser']}}</h6>
                    <div class="row">
                        <div class="col-8" style="margin: 0; padding:0; padding-left: 10px">
                            <h5 style="font-weight: 600; margin-top: -5px;" class="titipequeno">{{$cargo}}</h5>
                            <h6 style="font-weight: 600; color: #6a82cf; font-size: 12px;">R$ {{$custo}}</h6> 
                            <h6 style="font-weight: 600; color: #5ec762; font-size: 12px;"><i class="far fa-clock"></i> {{$horas}} hs</h6>
                        </div>
                        <div class="col-4" id="horas_f_{{$value['id']}}" style="margin: 0; padding:0;"></div>
                        <script>
                            var domm = document.getElementById("horas_f_{{$value['id']}}");
                            var myChart = echarts.init(domm);
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
                                myChart.setOption(optionn);
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    
<?php }?>



<script>

    $('.caduserfun').on('click',function(){        
        var str = $(this).data('funcao');
        $('.caduserfun').removeClass('active'); 
        $(this).addClass('active');
        carregar_cards('card_usuarios',str);       
        console.log(str);          
    });
</script>