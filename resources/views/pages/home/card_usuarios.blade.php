<?php
    function novacor(){
        $r[0] = rand(0,255);
        $r[1] = rand(0,255);
        $r[2] = rand(0,255);
        return $r[0].','.$r[1].','.$r[2].',';
    }
    $ordem = addordem(100);
function addordem($quant){
    $array = array();
    for ($x = 0; $x <= $quant; $x++)
    {
        $numero =  $x;
        if($x <= 999){$numero = '0'.$x; }
        if($x <= 99){$numero = '00'.$x; }
        if($x <= 9){$numero = '000'.$x; }       
        
        array_push($array, $numero);
    }
    return $array;
}

function addseg($segundos){
   
        $numero =  '';
        if($segundos <= 999999999){$numero = '0'.$segundos; }
        if($segundos <= 99999999){$numero = '00'.$segundos; }
        if($segundos <= 9999999){$numero = '000'.$segundos; }
        if($segundos <= 999999){$numero = '0000'.$segundos; }
        if($segundos <= 99999){$numero = '00000'.$segundos; }
        if($segundos <= 9999){$numero = '000000'.$segundos; }
        if($segundos <= 999){$numero = '0000000'.$segundos; }
        if($segundos <= 99){$numero = '00000000'.$segundos; }
        if($segundos <= 9){$numero = '000000000'.$segundos; }  
        

    return $numero;
}
    $cores=[];

    $dias=[];
    foreach ($datas_segundos_empreendimentos as $key => $value){    
        $explo1 = explode("<>", $value);
        $explo2 = explode("-", $explo1[0]);
        $dia = $explo2[1].'/'. $explo2[2];
        array_push($dias, $dia);   
    }
    $dias1 = array_unique($dias);
    asort($dias1);
    $dias = [];
    foreach($dias1 as $val){
        $explo1 = explode("/", $val); 
        $dia_k = $explo1[1].'/'. $explo1[0];
        array_push($dias, $dia_k); 
    }

    // echo '<pre>';
    // var_dump($dias);
    // echo '</pre>';


    function separa_datas($dateStart, $dateEnd){
        $dateRange = array();
        $mes = 0;
        $dateStart 	= new DateTime($dateStart);      
        $dateEnd 	= new DateTime($dateEnd);
        $dateRange = array();
        $mes = 0;
        while($dateStart <= $dateEnd){    
            $mes = $dateStart->format('m');    
            $dateRange[] = $dateStart->format('Y-m-d');  
            if($dateStart->format('N') > 5 ){
              return 5;
            }
            $dateStart = $dateStart->modify('+1day');             
             if($dateEnd->format('m') !== $mes ){
              return 5;
             }            
        }
        return $dateRange;
    }

    function converte_segundos($tempo){
        $segundos = 0;
        list( $h, $m, $s ) = explode( ':', $tempo ); 
        $segundos += $h * 3600; 
        $segundos += $m * 60;
        $segundos += $s;
        return $segundos;
    }

    function horas_segundos($total){
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
        if(strlen($horas) == 1){ $horas = '0'.$horas;}
        return $horas . ":" . $minutos;
    }
    
    function horas_segundos2($total){
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        // if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
        // if(strlen($horas) == 1){ $horas = '0'.$horas;}
        return $horas . "." . $minutos;
    }
    if($tipo_produto == 'Todos'){ $tipo_produto = '';}
?>
<style>
    #example_users_length{display: none;}
    #example_users_first{display: none;}
    #example_users_previous{display: none;}
    #example_users_next{display: none;}
    #example_users_last{display: none;}
    
</style>
 <!-- data-aos=fade-left data-aos-delay=250 -->
<div class="col-md-12" >
    <div class="info-card" style="perspective: 1800px; " data-aos=fade-left data-aos-delay=320 data-aos-anchor="#filtrosfull">
        <div class="front " id="front01" >
            <div class="" style="position: relative;">
                <div class="card-header">                      
                    <div class="row">
                        <div class="col-8">
                            <h5><i class="fas fa-users"  style="color: #777;"></i> Usuários {{$tipo_produto}}</h5>
                        </div>
                        <div class="col-4" style="text-align: right;">
                            <h5 style="font-size: 25px;">{{count($totaluser)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body txtcenter"> 
                    <canvas id="chartHours2user" height="400"></canvas>                    
                </div>
                <div class="row" style="padding: 10px;">
                  <div class="col-sm-12">
                   
                        <button type="button" id="btviraf01" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i></button>   
                
                  </div>
                </div>
            </div>  
        </div>
        <div class="back" id="back01">
            <div class="" style="position: relative;">
                <div class="card-header"> 
                    <h5><i class="fas fa-users"  style="color: #777;"></i> <span class="titiuser"> {{count($totaluser)}} Usuários {{$tipo_produto}} </span>
                    <div class="switch switchacord" style=" float:right">
                        <label><span style="color: #ccc;">Inativo</span><input type="checkbox" value="01"  class="checkprod" id="checkprod01" checked ><span class="lever"></span>Ativo</label>
                    </div> </h5> 
                                     
                </div>
                <div class="card-body" >
                    <div class="row" id='tabela1'>
                        <table id="example_users" class="table table-bordered" style="width:100%">
                        <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuário</th>   
                                    @if(Auth::user()->perfil == 2)
                                    <th >R$</th>    
                                    @endif
                                    <th >Horas</th>    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                            @foreach($lista_empreendimentos_horas22 as $key => $value)
                            <?php $porcentag = $value['total'] * 100 / $total_segundos;  ?>
                                <tr class="shadomtable" data-toggle="modal" data-target="#myModalCalend" onclick="exibir_calend(<?php echo $value['id']?>)" style="cursor: pointer;">
                                    <td>{{$value['id']}}</td>
                                    <td style="position: relative; padding:2px">
                                        <div style="z-index: 9; position: relative">{{$value['name']}} </div>
                                        <?php array_push($cores, novacor());  ?>                                        
                                    </td>
                                    @if(Auth::user()->perfil == 2) 
                                    <td class="text-right"><span  class="valor">{{$value['custo']}}</span></td> 
                                   
                                    @endif
                                    <td class="text-right"><?php echo horas_segundos($value['total']); $cont_tab = $cont_tab + 1 ?></td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table> 
                    </div>   
                    
                    
                    <div class="row" id='tabela2'>
                        <table id="example_users2" class="table table-bordered" style="width:100%">
                        <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuário</th>   
                                    <th>Email</th>    
                                </tr>
                            </thead>
                            <tbody>
                           
                            @foreach($userinativo2 as $key => $value)       
                                <tr class="shadomtable">
                                    <td>{{$value['id']}}</td>
                                    <td>{{$value['name']}}</td>
                                    <td>{{$value['email']}}</td>                                   
                                </tr>
                            @endforeach 
                            </tbody>
                        </table> 
                    </div>
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-12">
                        <button type="button" id="btvirab01" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i></button>                   
                  </div>
                </div>
            </div>
        </div>
    </div>                         
</div>   
<?php

// echo '<pre>';
// echo var_dump($userinativo2);
// echo '</pre>';

?> 

<script>
    $('#front01').addClass('virar-front');            
        $('#back01').addClass('virar-back');  

    $(document).on('change', '.checkprod', function() {
        if($(this).is(":checked")){
            console.log('ligado')
            $('.titiuser').text('{{count($totaluser)}} Usuários {{$tipo_produto}}')
            $('#tabela1').show();
            $('#tabela2').hide();
        }else{
            console.log('desligado')
            $('.titiuser').text('Todos os Usuários inativos')
            $('#tabela2').show();
            $('#tabela1').hide();
        }
    });
    $('#example_users').DataTable({ 
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [20,-1],
                [20]
                ],
            responsive: true,
            order: [[ 3, 'desc' ]],
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar", 
            "decimal": ",",
            "thousands": "."
            },
            "columnDefs": [{"targets": [ 0 ],"visible": false,"searchable": false},{ type: 'time-uni', targets: 3 }]            
    });



    $('#example_users2').DataTable({ 
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [20],
            responsive: true,
             order: [[ 1, 'asc' ]],
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar", 
            },
            "columnDefs": [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }]         
    });
    setTimeout(function(){ 
        $('.buttons-excel').html('<i class="fas fa-file-excel"></i>');
        $('.buttons-excel').addClass('btn btn-outline-success btn-rounded btclear waves-effect');
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        $('.buttons-print').addClass('btn btn-outline-info btn-rounded btclear waves-effect');
        $('#tabela2').hide();
    },  100); 

    $('#btviraf01').on('click',function(){        
        $('#front01').addClass('virar-front');            
        $('#back01').addClass('virar-back');            
    });

    $('#btvirab01').on('click',function(){        
        $('#front01').removeClass('virar-front');            
        $('#back01').removeClass('virar-back');            
    });


    // grafico de Area
    var ctx = document.getElementById('chartHours2user').getContext("2d");
    var myChart = new Chart(ctx, {
      type: 'line',

      data: {
        labels: [
            <?php
                foreach($dias as $value){
                    echo '"'.$value.'",';
                }
                ?>
            ],

        datasets: [
            <?php    
                
                $cont_cores = 0;  
                asort($datas_segundos_empreendimentos);
                foreach ($lista_empreendimentos as $value_pri){            
                    $hora_e_dia = [];
                    $dias_horas_somadas = [];
                    $script = '{';
                    $script .= 'label: "'.$value_pri->name.'",';
                    $script .= 'borderColor: "rgba('.$cores[$cont_cores].' 0.8)",';
                    $script .= 'backgroundColor: "rgba('.$cores[$cont_cores].' 0.1)",';
                    $script .= 'pointRadius: 1,';
                    $script .= 'borderWidth: 1,';
                    $script .= 'data: [';

                    $dados_separados_keys = [];
                    $dados_separados = [];
                    $data_temp = '';
                    $soma_segundos = 0;
                    //separa os empreendimento por data 
                    foreach ($datas_segundos_empreendimentos as $key => $value){  
                        $explo1 = explode("<>", $value);
                        $emprend = $explo1[1];
                        $data = $explo1[0];
                        $segundos = $explo1[2];
                        //verifica se é o mesmo empreendimento
                        if($value_pri->name ==  $emprend){
                            if (array_key_exists($data, $dados_separados_keys)) {
                                $ultimoarray = array_pop($dados_separados_keys);
                                $dados_separados_keys[$data] = $ultimoarray + $segundos;         
                            }else{
                                $dados_separados_keys[$data] = intval($segundos);
                            }            
                        }
                        $data_temp = $data;
                    }
                    // transformar a data do dados_separados_keys
                    foreach ($dados_separados_keys as $key2 => $value){ 
                        $explo1 = explode("-", $key2); 
                        $dia_k = $explo1[2].'/'. $explo1[1];
                        $dados_separados[$dia_k] = $value;
                    }  
                    $valores = '';
                    $cont_valores = 0;
                    foreach ($dias as $val){
                        $valor_atu = '0,';
                        foreach ($dados_separados as $key3 => $value3){ 
                            if($key3 == $val){
                                $valor_atu = $valor_atu = horas_segundos2($value3).',';
                            }       
                        }
                        $valores .= $valor_atu;
                    }
                    $script .=  $valores;            
                    $script .= '],';
                    $script .= '},'; 
                
                    $cont_cores = $cont_cores +1;   
                    echo  $script;  
                }
                ?>
        ], borderWidth: 1
      },
      options: {
        responsive: true,
        animation: false,
        maintainAspectRatio: false,
        legend: {
          display: false
        },

        tooltips: {
          enabled: true
        },

        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                    
                },
                gridLines: {
                    drawBorder: false,
                    zeroLineColor: "#fff",
                    color: 'rgba(255,255,255,0.05)'
                }
            }],
            xAxes: [{
            barPercentage: 1.6,
            gridLines: {
              drawBorder: false,
              zeroLineColor: "transparent",
              display: false,
            },
            ticks: {
              padding: 20,
              fontColor: "#9f9f9f"
            }
          }]
        },

        
      }
    });
</script>