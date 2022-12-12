<style>
    #dexample_alo_dep_length{display: none;}
    #dexample_alo_dep_filter{display: none;}
    #dexample_alo_dep_info{display: none;}
    #dexample_alo_dep_first{display: none;}
    #dexample_alo_dep_previous{display: none;}
    #dexample_alo_dep_next{display: none;}
    #dexample_alo_dep_last{display: none;}
    /* #dexample_alo_dep_paginate{display: none;} */
</style>
<?php

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
    return $horas . "." . $minutos;
}
?>

<div class="" style="position: relative; width:100%" >
    <div class="info-card" style="perspective: 1800px; ">
    <i class="fas fa-globe-americas icohear2"></i>
        <div class="front card" id="front-alo_dep"style="height: 600px">         
            <div class="card-body txtcenter" style=" position: relative"> 
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h5 style="margin-top: 10px; text-align: left;" > <span id="titialocdep">Total em Horas por Alocação em</span> {{$tipo_produto}}</h5>
                    </div>
                    <div class="col-md-4">
                        <div style="margin-left: 0px;">
                            <ul class="nav nav-pills mb-3" id="pills_alocacao_dep-tab" role="tablist">
                                <li class="nav-item ">
                                    <a class="nav-link nav_horas active" id="pills_alocacao_dep-hs-tab" data-toggle="pill" href="#pills_alocacao_dep-hs" role="tab" aria-controls="pills_alocacao_dep-hs" aria-selected="true"> HORAS</a>
                                </li>
                                @if(Auth::user()->perfil == 2) 
                                <li class="nav-item ">
                                    <a class="nav-link nav_financ" id="pills_alocacao_dep-rs-tab" data-toggle="pill" href="#pills_alocacao_dep-rs" role="tab" aria-controls="pills_alocacao_dep-rs" aria-selected="false"> FINANCEIRO </a>
                                </li>  
                                @endif                                  
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="md-form">                                
                            <select searchable="Procurar..." class="mdb-select mdb-select_ed colorful-select dropdown-primary md-form" name="departamento_dep" id="departamento_dep" >
                                @foreach($departamentos as $key => $value)       
                                    @if($tipo_produto == $value->depnome)
                                        <option value="{{$value->id ?? ''}}" selected>{{$value->depnome ?? ''}}</option>
                                    @else
                                        <option value="{{$value->id ?? ''}}">{{$value->depnome ?? ''}}</option>
                                    @endif             
                                                
                                @endforeach                                                     
                            </select> 
                            <label for="departamento_dep" class="active"> </label> 
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="pills_alocacao_dep-tabContent" style="margin-top: -20px;">
                    <div class="tab-pane fade show active" id="pills_alocacao_dep-hs" role="tabpanel" aria-labelledby="pills_alocacao_dep-hs-tab" style=" width: 100%; ">
                        @include('pages.home.grafico_alocacao_dep_hs')   
                    </div>
                    <div class="tab-pane fade show active" id="pills_alocacao_dep-rs" role="tabpanel" aria-labelledby="pills_alocacao_dep-rs-tab" style=" width: 100%;">
                        @include('pages.home.grafico_alocacao_dep_rs')
                    </div>
                </div>               

            </div> 
            <div class="row" style="padding: 10px; position:absolute; top:540px">
                <div class="col-md-12">
                    <button type="button" id="btviraf-alo_dep" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> Lista Completa</button>                   
                </div>
            </div>
        </div>
        <div class="back" id="back-alo_dep">
            <div class="card" style="position: relative;">
                <div class="card-header"> 
                    <h5> Alocações por {{$tipo_produto ?? ''}} </h5>                    
                </div>
                <div class="card-body" style=" height: 480px; margin-top: 0px">
                    <div class="row">
                        <table id="dexample_alo_dep" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Alocações</th>  
                                    @if(Auth::user()->perfil == 2)
                                        <th ><i class="fas fa-running"></i></th>    
                                        <th >R$</th>    
                                    @endif
                                    <th style="width: 40px;"><i class="far fa-clock" style="color: #727f93;"></i></th>    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                            @foreach($lista_alocacoes as $key => $value)                        
                                <tr class="shadomtable">
                                    <td>{{$value['id']}}</td>
                                    <td style="position: relative; padding:2px">
                                        <div style="z-index: 9; position: relative">{{$value['aldescricao']}} </div>
                                    </td>
                                    @if(Auth::user()->perfil == 2) 
                                    <td>{{$value['totaluser']}}</td> 
                                    <td class="text-right"><span  class="valor">{{number_format($value['custo'],2, ',', '.')}}</span></td> 
                                    @endif
                                    <td class="text-right"><?php echo horas_segundos($value['total']); $cont_tab = $cont_tab + 1 ?></td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table> 
                    </div>                        
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-md-12">
                        <button type="button" id="btvirab-alo_dep" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i></button>                   
                  </div>
                </div>
            </div>
        </div>
    </div> 



</div> 



<script>
    $(function() {AOS.init();});
    $('#dexample_alo_dep').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [11,-1],
                [11]
                ],
            responsive: true,
            order: [[  <?php if(Auth::user()->perfil == 2){ echo 4; }else{echo 2; } ?>, 'desc' ]],
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar", 
            "decimal": ",",
            "thousands": "."
            },
            "columnDefs": [{"targets": [ 0 ],"visible": false,"searchable": false},{ type: 'time-uni', targets: 4 }]                             
    });

    setTimeout(function(){ 
        $('.buttons-excel').html('<i class="fas fa-file-excel"></i>');
        $('.buttons-excel').addClass('btn btn-outline-success btn-rounded btclear waves-effect');
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        $('.buttons-print').addClass('btn btn-outline-info btn-rounded btclear waves-effect');
        // $('#pills_atividade-rs').removeClass('show', 'active');  
        // $('#pills_atividade-rs').css('display', 'none');
    },  100);
    

    $('#btviraf-alo_dep').on('click',function(){        
        $('#front-alo_dep').addClass('virar-front');            
        $('#back-alo_dep').addClass('virar-back');            
    });

    $('#btvirab-alo_dep').on('click',function(){        
        $('#front-alo_dep').removeClass('virar-front');            
        $('#back-alo_dep').removeClass('virar-back');            
    });

    $(document).ready(function () {
        $('.mdb-select_ed').materialSelect(); 
        $('.dropdown-content, .select-dropdown').perfectScrollbar(); 
    });

    $( "#departamento_dep" ).change(function() {
        var str = "";
        $("#departamento_dep option:selected" ).each(function() {str += $( this ).text();});
        carregar_cards('card_alocacaos_dep',str); 
    });

    $('#pills_alocacao_dep-hs-tab').on('click',function(){        
        $('#titialocdep').text('Total em Horas por Alocação em')         
    });
    $('#pills_alocacao_dep-rs-tab').on('click',function(){        
        $('#titialocdep').text('Total Financeiro por Alocação em')         
    });


</script>