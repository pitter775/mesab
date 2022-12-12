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
    #example_ativi_length{display: none;}
    #example_ativi_filter{display: none;}
    #example_ativi_info{display: none;} 
    #example_ativi_first{display: none;}
    #example_ativi_previous{display: none;}
    #example_ativi_next{display: none;}
    #example_ativi_last{display: none;}
</style>


<style>


</style>



<div class="info-card" style="perspective: 1800px; " data-aos=fade-left data-aos-delay=80 data-aos-anchor="#filtrosfull">
    <div class="front card" id="front_atividade1" style="height:  670px; width:100%; background-image: url('{{ asset('bgcardAtv.png') }}'); background-position: top left; background-repeat: no-repeat;">
        <div class="" style="position: relative;">
            <div class="card-header">                      
                <div class="row">
                    <div class="col-12">
                        <div style="float: left; width:100%">
                            <h5><i class="fas fa-snowboarding"  style="color: #777;"></i> <span class="titiintcont">Total de Horas por Atividade em Produtos</span></h5>
                            <div style="float: right; margin-right: 10px; margin-top: -30px">
                                <div class="bthorafin2" style=" float: right; z-index: 9 " data-aos=fade-left data-aos-delay=50 data-aos-anchor="#filtrosfull" >
                                    <ul class="nav nav-pills mb-3" id="pills_atividade-tab" role="tablist">
                                        <li class="nav-item ">
                                            <a class="nav-link nav_horas active" id="pills_atividade-hs-tab" data-toggle="pill" href="#pills_atividade-hs" role="tab" aria-controls="pills_atividade-hs" aria-selected="true"> HORAS</a>
                                        </li>
                                        @if(Auth::user()->perfil == 2) 
                                        <li class="nav-item ">
                                            <a class="nav-link nav_financ" id="pills_atividade-rs-tab" data-toggle="pill" href="#pills_atividade-rs" role="tab" aria-controls="pills_atividade-rs" aria-selected="false"> FINANCEIRO </a>
                                        </li>  
                                        @endif                                  
                                    </ul>
                                </div>
                          
                            </div>
                          
                            
                        </div>
                        
                    </div>
                        <div class="col-md-4"></div>
                        
                        <div class="col-md-4"></div>
                </div>
            </div>

            
            <div class="tab-content" id="pills_atividade-tabContent" style="margin-top: -70px;">
                <div class="tab-pane fade show active" id="pills_atividade-hs" role="tabpanel" aria-labelledby="pills_atividade-hs-tab" style=" width: 100%; ">
                    @include('pages.home.grafico_atividade_hs')  
                </div>
                <div class="tab-pane fade show active" id="pills_atividade-rs" role="tabpanel" aria-labelledby="pills_atividade-rs-tab" style=" width: 100%;">
                    @include('pages.home.grafico_atividade_rs')  
                </div>
            </div>
            
        </div>  
    </div>
    <div class="back" id="back_atividade1" style="width:100%">
        <div class="card" style="position: relative;">
            <div class="card-header"> 
                <h5><i class="fas fa-snowboarding"  style="color: #777;"></i> Atividade </h5>                    
            </div>
            <div class="card-body" style=" height: 570px; margin-top: -10px">
                <div class="row">
                    <table id="pexample_atv" class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Atividades</th>   
                                @if(Auth::user()->perfil == 2)
                                    <th ><i class="fas fa-running"></i></th>    
                                    <th >R$</th>    
                                @endif
                                <th >Horas</th>    
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                        @foreach($lista_atividades as $key => $value)
                  
                            <tr class="shadomtable">
                                <td>{{$value['id']}}</td>
                                <td style="position: relative; padding:2px">
                                    <div style="z-index: 9; position: relative">{{$value['atdescricao']}} </div>                                    
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
                    <button type="button" id="btvira_atividade" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i> voltar</button>
                </div>
            </div>
        </div>
    </div>
</div>   


<script>    
    $(function() {
        AOS.init();
    });

    $('#pills_atividade-hs-tab').on('click',function(){        
        $( '.titiintcont' ).html('Total de Horas por Atividade em Produtos');      
        $('#pills_atividade-rs').css('display', 'none');  
        $('#pills_atividade-hs').css('display', 'table');  
        // chartatividade_hs.resize();
    });
    $('#pills_atividade-rs-tab').on('click',function(){        
        $( '.titiintcont' ).html('Total Financeiro por Atividade em Produtos');       
        $('#pills_atividade-rs').css('display', 'table'); 
        $('#pills_atividade-hs').css('display', 'none'); 
        // chartatividade_hs.resize(); 
    });


    $('#pexample_atv').DataTable({
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
        $('#pills_atividade-rs').removeClass('show', 'active');  
        // $('#pills_atividade-rs').css('display', 'none');
    },  100);





    $('#btvira_atividade').on('click',function(){   
        $('.bthorafin2').show();     
        $('#front_atividade1').removeClass('virar-front');            
        $('#back_atividade1').removeClass('virar-back');            
    });

    
</script>


