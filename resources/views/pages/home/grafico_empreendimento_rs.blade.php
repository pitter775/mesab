

<div class="card-body txtcenter" style="padding:0; margin:0"> 
    <div class="row">
        <div class="col-md-8">
            <div id="grafico_empreendimento_rs" class="divgrafico" style="height: 500px; margin-left:-20px "></div> 
        </div>                          
        <div class="col-md-4 chardcardrigh" style="text-align: left;">
            <?php $total_segundos = $total_horas[0]->total; ?>
            @foreach(array_slice($lista_empreendimentos_horas22, 0, 3) as $key => $value)
                <?php
                    $somatotal = explode(",", $soma_valor);
                    $somatotalok = str_replace(".", "", $somatotal[0]);
                    
                    $somaind = explode(",", $value['custo']);
                    $somaindok = str_replace(".", "", $somaind[0]);
                    $porcentag = $somaindok * 100 / $somatotalok;                
                ?>
                <div class="card" style="margin:10px; padding: 10px; background:#c3d4e8">
                    <div class="row" >
                        <div class="col-md-9" style="margin:0; padding:0; padding-left:10px">
                            <h5 style="font-weight: 500;"> R$ <?php echo $value['custo'] ?> </h5>
                            {{$value['epdescricao']}}
                        </div>
                        <div class="col-md-3"  style="margin:0; padding:0">
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
                                        progress: {
                                            show: true,
                                            width: 5
                                        },
                                        axisLine: {
                                        
                                            lineStyle: {
                                                width: 5
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
                                            color: '#999',
                                            fontSize: 20,
                                            show: false,
                                        },
                                        pointer: {
                                            show: true,
                                            size: 1,
                                            itemStyle: {
                                                borderWidth: 1
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
                                            fontSize: 15,
                                            offsetCenter: [0, '70%'],
                                            formatter: '{value}%',
                                        },
                                        data: [{            
                                            value: <?php echo round($porcentag)?>
                                        }]
                                    }]
                                };

                                if (optionn<?php echo$value['id'] ?> && typeof optionn<?php echo$value['id'] ?> === 'object') {
                                    myChartt<?php echo$value['id'] ?>.setOption(optionn<?php echo$value['id'] ?>);
                                }
                        </script>
                    </div>                
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row" style="padding: 10px; margin-top:-55px">
    <div class="col-sm-12" style="margin-top: 10px;">                   
        <button type="button" id="btviraf01user1" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> lista completa</button>   
    </div>
</div>


<script>
    var chartEmprend_rs  = echarts.init(document.querySelector('#grafico_empreendimento_rs'), null);	
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
                    foreach($lista_empreendimentos_horas22 as $value){
                        $cont01 = $cont01 + 1;
                        if($cont01 < 11){
                            if($value['id'] !== 42 && $value['id'] !== 41 && $value['id'] !== 85){
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
                    foreach($lista_empreendimentos_horas22 as $value){                   
                        if($cont02 < 10){
                            if($value['id'] !== 42 && $value['id'] !== 41 && $value['id'] !== 85){
                                echo '{value: '. horas_segundos2($value['total']).', name: "'.$value['epdescricao'].'", itemStyle: { color: "rgb( 52, 110, 177, 0.'.$cont_cor.'8)" }},'; 
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
    chartEmprend_rs.setOption(option_rs);
    window.addEventListener('resize',function(){
        chartEmprend_rs.resize();
    });

    $('#btviraf01user1').on('click',function(){        
        $('#front01user').addClass('virar-front');            
        $('#back01user').addClass('virar-back');            
    });

</script>