<style>
    #dexample_alo_length{display: none;}
    #dexample_alo_filter{display: none;}
    #dexample_alo_info{display: none;}
    #dexample_alo_first{display: none;}
    #dexample_alo_previous{display: none;}
    #dexample_alo_next{display: none;}
    #dexample_alo_last{display: none;}
    /* #dexample_alo_paginate{display: none;} */
</style>
<?php

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

<div class="" style="position: relative; width:100%" data-aos=fade-left data-aos-delay=290 data-aos-anchor="#filtrosfull" >
    <div class="info-card" style="perspective: 1800px; ">
    <i class="fas fa-globe-americas icohear2"></i>
        <div class="front card" id="front-alo"style="height: 600px">
         
            <div class="card-header">
                <h5 style="margin-top: -5px;" id="titialoc"> Total de Horas por cada área de Alocação </h5>
            </div>

            <div style="margin-left: 10px;">
                <ul class="nav nav-pills mb-3" id="pills_alocacao-tab" role="tablist">
                    <li class="nav-item ">
                        <a class="nav-link nav_horas active" id="pills_alocacao-hs-tab" data-toggle="pill" href="#pills_alocacao-hs" role="tab" aria-controls="pills_alocacao-hs" aria-selected="true"> HORAS</a>
                    </li>
                    @if(Auth::user()->perfil == 2) 
                    <li class="nav-item ">
                        <a class="nav-link nav_financ" id="pills_alocacao-rs-tab" data-toggle="pill" href="#pills_alocacao-rs" role="tab" aria-controls="pills_alocacao-rs" aria-selected="false"> FINANCEIRO </a>
                    </li>  
                    @endif                                  
                </ul>
            </div>

            <div class="tab-content" id="pills_alocacao-tabContent" style="margin-top: -20px;">
                <div class="tab-pane fade show active" id="pills_alocacao-hs" role="tabpanel" aria-labelledby="pills_alocacao-hs-tab" style=" width: 100%; ">
                    @include('pages.home.grafico_alocacao_hs')     
                </div>
                <div class="tab-pane fade show active" id="pills_alocacao-rs" role="tabpanel" aria-labelledby="pills_alocacao-rs-tab" style=" width: 100%;">
                    @include('pages.home.grafico_alocacao_rs')
                </div>
            </div>


            <div class="row" style="padding: 10px; position:absolute; top:540px">
                <div class="col-md-12">
                    <button type="button" id="btviraf-alo" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i> Lista Completa</button>                   
                </div>
            </div>
      
        </div>
        <div class="back" id="back-alo">
            <div class="card" style="position: relative;">
                <div class="card-header"> 
                    <h5> Alocação </h5>                    
                </div>
                <div class="card-body" style=" height: 485px; margin-top: 0px">
                    <div class="row">
                        <table id="dexample_alo_f" class="table table-bordered" style="width:100%">
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
                        <button type="button" id="btvirab-alo" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i></button>                   
                  </div>
                </div>
            </div>
        </div>
    </div> 
</div> 

<script>
    $(function() {AOS.init();});
    $('#dexample_alo_f').DataTable({
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


    $('#btviraf-alo').on('click',function(){        
        $('#front-alo').addClass('virar-front');            
        $('#back-alo').addClass('virar-back');            
    });

    $('#btvirab-alo').on('click',function(){        
        $('#front-alo').removeClass('virar-front');            
        $('#back-alo').removeClass('virar-back');            
    });
    $('#pills_alocacao-hs-tab').on('click',function(){        
        $('#titialoc').text('Total de Horas por cada área de Alocação')         
    });
    $('#pills_alocacao-rs-tab').on('click',function(){        
        $('#titialoc').text('Total Financeiro por cada área de Alocação')         
    });

    setTimeout(function(){ 
        $('#pills_alocacao-rs').removeClass('show', 'active', 'fade');  
        // $('#pills_alocacao-rs').css('display', 'none');
    },  500);
</script>