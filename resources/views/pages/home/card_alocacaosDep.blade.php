<?php
    function horas_segundos($total){
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
        if(strlen($horas) == 1){ $horas = '0'.$horas;}
        $horas = number_format($horas,0, ',', '.');
        return $horas . ":" . $minutos;
    }
    function horas_segundos_sem($total){
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
        if(strlen($horas) == 1){ $horas = '0'.$horas;}
        // $horas = number_format($horas,0, ',', '.');
        return $horas;
    }
?>
<style>
    #example_aloc_length{display: none;}
    #example_aloc_filter{display: none;}
    #example_aloc_info{display: none;}
    #example_aloc_first{display: none;}
    #example_aloc_previous{display: none;}
    #example_aloc_next{display: none;}
    #example_aloc_last{display: none;}
</style>


<style>
    .navint { width: 100%; margin-top: 20px; }
    .navint li{ list-style: none; color: #777;  display: inline; border-radius: 5px ; padding: 5px 10px; font-size: 10px; font-weight: 700; cursor: pointer; font-family: "Roboto", sans-serif; text-transform: uppercase;}
    .navint li.ativo{ background-color: #2f558a !important;  box-shadow: 0 16px 26px -10px rgb(63 106 216 / 56%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(63 106 216 / 20%); color: #fff;}
    .navint li:hover{background-color: #dae5f4; }
    .navhoras{ position: absolute; right: 0; top: -85px}

</style>

<div class="bthorafin" style=" position:absolute; top: 50px; left: 25px; z-index: 999 " data-aos=fade-left data-aos-delay=50 data-aos-anchor="#filtrosfull" >
    <ul class="nav nav-pills mb-3" id="pills_alocacaos-tab" role="tablist">
        <li class="nav-item ">
            <a class="nav-link nav_horas active" id="pills_alocacaos-hs-tab" data-toggle="pill" href="#pills_alocacaos-hs" role="tab" aria-controls="pills_alocacaos-hs" aria-selected="true"> HORAS</a>
        </li>
        @if(Auth::user()->perfil == 2) 
        <li class="nav-item ">
            <a class="nav-link nav_financ" id="pills_alocacaos-rs-tab" data-toggle="pill" href="#pills_alocacaos-rs" role="tab" aria-controls="pills_alocacaos-rs" aria-selected="false"> FINANCEIRO </a>
        </li>  
        @endif                                  
    </ul>
</div>

<div class="info-card" style="perspective: 1800px; " data-aos=fade-left data-aos-delay=80 data-aos-anchor="#filtrosfull">
    <div class="front card" id="front_alocacaos1" style="height:  670px; width:100%">
        <div class="" style="position: relative;">
            <div class="card-header">                      
                <div class="row">
                    <div class="col-12">
                        <div style="float: left; width:100%">
                            <h5><i class="fas fa-snowboarding"  style="color: #777;"></i> <span class="titiintcont_alo">Total de Horas por Alocações em Departamentos</span></h5>
                            
                          
                            
                        </div>
                        
                    </div>
                        <div class="col-md-4"></div>
                        
                        <div class="col-md-4"></div>
                </div>
            </div>

            
            <div class="tab-content" id="pills_alocacaos-tabContent" style="margin-top: -60px;">
                <div class="tab-pane fade show active" id="pills_alocacaos-hs" role="tabpanel" aria-labelledby="pills_alocacaos-hs-tab" style=" width: 100%; ">
                    @include('pages.home.grafico_alocacao_hs')  
                    
                </div>
                <div class="tab-pane fade show active" id="pills_alocacaos-rs" role="tabpanel" aria-labelledby="pills_alocacaos-rs-tab" style=" width: 100%;">
                    @include('pages.home.grafico_alocacao_rs')  

                </div>
            </div>
            
        </div>  
    </div>
    <div class="back" id="back_alocacaos1" style="width:100%">
        <div class="card" style="position: relative;">
            <div class="card-header"> 
                <h5><i class="fas fa-snowboarding"  style="color: #777;"></i> Alocacaos </h5>                    
            </div>
            <div class="card-body" style=" height: 570px; margin-top: -10px">
                <div class="row">
                    <table id="pexample_alo" class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Alocacaos</th>   
                                @if(Auth::user()->perfil == 2)
                                    <th ><i class="fas fa-running"></i></th>    
                                    <th >R$</th>    
                                @endif
                                <th >Horas</th>    
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                        @foreach($lista_alocacaos as $key => $value)
                        <?php $porcentag = $value['total'] * 100 / $total_segundos;  ?>
                            <tr class="shadomtable">
                                <td>{{$value['id']}}</td>
                                <td style="position: relative; padding:2px">
                                    <div style="z-index: 9; position: relative">{{$value['aldescricao']}} </div>
                                   
                                    
                                    <div style="position: absolute; z-index: 1; top: 2px; left: 0px; height: 88%; width: 100%"></div>
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
                <div class="col-sm-12">
                    <button type="button" id="btvira_alocacaos" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i> voltar</button>
                </div>
            </div>
        </div>
    </div>
</div>   

<?php
    echo '<pre>';
        dd($lista_alocacaos);
    echo '</pre>';
?>

<script>    
    $(function() {
        AOS.init();
    });

    $('#pills_alocacaos-hs-tab').on('click',function(){        
        $( '.titiintcont_alo' ).html('Total de Horas por Alocações em Departamentos');      
        $('#pills_alocacaos-rs').css('display', 'none');  
        $('#pills_alocacaos-hs').css('display', 'table');  
        // chartalocacaos_hs.resize();
    });
    $('#pills_alocacaos-rs-tab').on('click',function(){        
        $( '.titiintcont_alo' ).html('Total Financeiro por Alocações em Departamentos');       
        $('#pills_alocacaos-rs').css('display', 'table'); 
        $('#pills_alocacaos-hs').css('display', 'none'); 
        // chartalocacaos_hs.resize(); 
    });


    $('#pexample_alo').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [13,-1],
                [13]
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
        $('#pills_alocacaos-rs').removeClass('show', 'active');  
        $('#pills_alocacaos-rs').css('display', 'none');
    },  100);





    $('#btvira_alocacaos').on('click',function(){        
        $('.bthorafin').show();
        $('#front_alocacaos1').removeClass('virar-front');            
        $('#back_alocacaos1').removeClass('virar-back');            
    });

    
</script>


