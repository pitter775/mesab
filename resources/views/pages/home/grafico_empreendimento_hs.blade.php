

<div class="card-body txtcenter" style="padding:0; margin:0"> 
    <div class="row">
        <div class="col-md-8">
            <div id="chartHours2_hs" class="divgrafico" style="height: 500px; margin-left:-20px "></div> 
        </div>                          
        <div class="col-md-4 chardcardrigh" style="text-align: left;">
            <?php $total_segundos = $total_horas[0]->total; ?>
            @foreach(array_slice($lista_empreendimentos_horas22, 0, 3) as $key => $value)
                <?php $porcentag = $value['total'] * 100 / $total_segundos;  ?>

                <div class="card" style="margin:10px; padding: 10px; background:#c3d4e8">
                    <div class="row" >
                        <div class="col-md-9" style="margin:0; padding:0; padding-left:10px">
                            <h5 style="font-weight: 500;"><?php echo horas_segundos2($value['total']) ?> hs</h5>
                            {{$value['epdescricao']}}
                        </div>
                        <div class="col-md-3"  style="margin:0; padding:0">
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

                                if (option<?php echo$value['id'] ?> && typeof option<?php echo$value['id'] ?> === 'object') {
                                    myChart<?php echo$value['id'] ?>.setOption(option<?php echo$value['id'] ?>);
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
        <button type="button" id="btviraf01user" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> lista completa</button>   
    </div>
</div>
<style>
    .pretoltip{ padding: 0;margin:0; max-width: 300px; border: none; background-color: #fff;
     font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;  }
     .tolname{ font-size: 12px; font-weight: 500; color: #777}
     .tolcusto{ font-size: 14px;font-weight: 500;color: #333}
     .tolhora{ font-size: 13px;font-weight: 500; color: #555}
     .divvalores{ padding: 5px; background-color: #eee;}
</style>


<script>

    var chartEmprend_hs  = echarts.init(document.querySelector('#chartHours2_hs'), null);	
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
                        if($cont01 < 10){
                            if($value['id'] !== 42 && $value['id'] !== 41 && $value['id'] !== 85){
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
                    foreach($lista_empreendimentos_horas22 as $value){                   
                        if($cont02 < 10){
                            if($value['id'] !== 42 && $value['id'] !== 41 && $value['id'] !== 85){
                                echo '{value: '. horas_segundos2($value['total']).', pess: "'. $value['totaluser'].'",   custo: "'. $value['custo'].'", name: "'.$value['epdescricao'].'", itemStyle: { color: "rgb( 52, 110, 177, 0.'.$cont_cor.'8)" }},'; 
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
    chartEmprend_hs.setOption(option_hs);
    window.addEventListener('resize',function(){
        chartEmprend_hs.resize();
        console.log('tete');
    });

    $('#btviraf01user').on('click',function(){        
        $('#front01user').addClass('virar-front');            
        $('#back01user').addClass('virar-back');            
    });

</script>