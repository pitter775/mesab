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
     
?>
<style>
    #example_empreend_length{display: none;}
    #example_empreend_first{display: none;}
    #example_empreend_previous{display: none;}
    #example_empreend_next{display: none;}
    #example_empreend_last{display: none;}
    .divgrafico{ margin: 0; padding: 0; margin-top: -50px;}
    .nav-horas { padding: 3px 10px !important; font-size: 12px; border: none !important; font-weight: 400;}    
</style>
 <!-- data-aos=fade-left data-aos-delay=250 -->


    <div class="info-card" style="perspective: 1800px; " data-aos=fade-left data-aos-delay=250 data-aos-anchor="#filtrosfull">
        <div class="front card" id="front01user" style="height:  550px">
            <div class="" style="position: relative;">
                <div class="card-header">                      
                    <div class="row">
                        <div class="col-12">
                            <div style="float: left;">
                                <h5><i class="far fa-building"  style="color: #777;"></i> <span class="titiinfemp">Total de Horas por Empreendimento </span></h5>
                            </div>
                            <div style="float: right; margin-left: 20px">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item ">
                                        <a class="nav-link nav-horas active" id="pills-hs-tab" data-toggle="pill" href="#pills-hs" role="tab" aria-controls="pills-hs" aria-selected="true">hs</a>
                                    </li>
                                    @if(Auth::user()->perfil == 2) 
                                    <li class="nav-item ">
                                        <a class="nav-link nav-horas" id="pills-rs-tab" data-toggle="pill" href="#pills-rs" role="tab" aria-controls="pills-rs" aria-selected="false">R$</a>
                                    </li>  
                                    @endif                                  
                                </ul>
                            </div>
                        </div>
    
                    </div>
                </div>

               
                <div class="tab-content" id="pills-tabContent" style="margin-top: -30px;">
                    <div class="tab-pane fade show active" id="pills-hs" role="tabpanel" aria-labelledby="pills-hs-tab">
                        @include('pages.home.grafico_empreendimento_hs')                        
                    </div>
                    <div class="tab-pane fade show active" id="pills-rs" role="tabpanel" aria-labelledby="pills-rs-tab">
                        @include('pages.home.grafico_empreendimento_rs')
                    </div>
                    
                   
                </div>               


                
            </div>  
        </div>
        <div class="back" id="back01user">
            <div class="card" style="position: relative;">
                <div class="card-header"> 
                    <h5><i class="far fa-building"  style="color: #777;"></i> Empreendimentos </h5>                    
                </div>
                <div class="card-body" style=" height: 447px; margin-top: -10px">
                    <div class="row">
                        <table id="example_empreend" class="table table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Empreendimentos</th>   
                                    @if(Auth::user()->perfil == 2)
                                    <th ></th>    
                                    <th >R$</th>    
                                    @endif
                                    <th >Horas</th>    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                            @foreach($lista_empreendimentos_horas22 as $key => $value)
                            <?php $porcentag = $value['total'] * 100 / $total_segundos;  ?>
                                <tr class="shadomtable">
                                    <td>{{$value['id']}}</td>
                                    <td style="position: relative; padding:2px">
                                        <div style="z-index: 9; position: relative">{{$value['epdescricao']}} </div>
                                        <?php array_push($cores, novacor());  ?>
                                        <!-- <div style="position: absolute; z-index: 1; top: 2px; left: 0px; background-color: rgb(<?php// echo $cores[$cont_tab]?> 0.2); border: solid 1px rgb(<?php// echo $cores[$cont_tab]?> 0.5); height: 88%; width: <?php// echo round($porcentag)?>%"></div> -->
                                        <div style="position: absolute; z-index: 1; top: 2px; left: 0px; height: 88%; width: 100%"></div>
                                    </td>
                                    @if(Auth::user()->perfil == 2) 
                                    <td>{{$value['totaluser']}}</td> 
                                    <td class="text-right"><span  class="valor">{{$value['custo']}}</span></td> 
                                   
                                    @endif
                                    <td class="text-right"><span class="txordem" style="font-size: 1px; color:#fff"><?php echo addseg($value['total']) ?></span><?php echo horas_segundos($value['total']); $cont_tab = $cont_tab + 1 ?>hs</td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table> 
                    </div>                        
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-sm-12">
                        <button type="button" id="btvirab01user" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i> voltar</button>       
                        <!-- <button type="button" class="btn btn-outline-primary btn-sm btn-rounded waves-effect expand"><i class="fas fa-expand"></i></button>                    -->
                  </div>
                </div>
            </div>
        </div>
    </div>                         
 

<?php
// echo '<pre>';
// var_dump($lista_empreendimentos_horas22);
// echo '</pre>';
?>

<script>
    $(document).ready(function($){
        $('.valor').mask('#.##0,00', {reverse: true});
    });
    $('.expand').on('click',function(){        
        $( '#card_empreendimentos' ).toggleClass( "divexpand_emprend" );      
    });

    $('#pills-hs-tab').on('click',function(){        
        $( '.titiinfemp' ).html('Total de Horas por Empreendimento');      
        $('#pills-rs').css('display', 'none');  
    });
    $('#pills-rs-tab').on('click',function(){        
        $( '.titiinfemp' ).html('Total Financeiro por Empreendimento');       
        $('#pills-rs').css('display', 'table');  
    });
    $('#example_empreend').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [9,-1],
                [9]
                ],
            responsive: true,
            order: [[  <?php if(Auth::user()->perfil == 2){ echo 4; }else{echo 2; } ?>, 'desc' ]],
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
        $('#pills-rs').removeClass('show', 'active');  
        $('#pills-rs').css('display', 'none');
    },  100);
    $('#btvirab01user').on('click',function(){        
        $('#front01user').removeClass('virar-front');            
        $('#back01user').removeClass('virar-back');            
    });

</script>