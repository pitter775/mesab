<?php

if($contrato_ativo == ''){
    $contrato_ativo = 'todos os tipos';
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
        $horas = number_format($horas,0, ',', '.');
        return $horas . ":" . $minutos;
    }

    function horas_segundos2($total){
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        return $horas . "." . $minutos;
    }
     
?>
<style>
    #example_contrato_length{display: none;}
    #example_contrato_first{display: none;}
    #example_contrato_previous{display: none;}
    #example_contrato_next{display: none;}
    #example_contrato_last{display: none;}
    .divgrafico{ margin: 0; padding: 0; margin-top: -50px;}
  
    .pretoltip{ padding: 0;margin:0; max-width: 300px; border: none; background-color: #fff; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;  }
    .tolname{ font-size: 12px; font-weight: 500; color: #777}
    .tolcusto{ font-size: 14px;font-weight: 500;color: #333}
    .tolhora{ font-size: 13px;font-weight: 500; color: #555}
    .divvalores{ padding: 5px; background-color: #eee;}
    .nomecardp{ font-weight: 500; color: #777; font-size: 14px; text-transform: uppercase}
    .cadintc{margin:10px; padding: 10px; background:#f7fafc;}



</style>
<div style="left:15; position:absolute; top: -50px; " data-aos=fade-left data-aos-delay=50 data-aos-anchor="#filtrosfull" >
    <ul class="nav nav-pills mb-3" id="pills_contrato-tab" role="tablist">
        <li class="nav-item ">
            <a class="nav-link nav_horas active" id="pills_contrato-hs-tab" data-toggle="pill" href="#pills_contrato-hs" role="tab" aria-controls="pills_contrato-hs" aria-selected="true"> HORAS</a>
        </li>
        @if(Auth::user()->perfil == 2) 
        <li class="nav-item ">
            <a class="nav-link nav_financ" id="pills_contrato-rs-tab" data-toggle="pill" href="#pills_contrato-rs" role="tab" aria-controls="pills_contrato-rs" aria-selected="false"> FINANCEIRO </a>
        </li>  
        @endif                                  
    </ul>
</div>
<div style="right:15px; position:absolute; top: -50px; text-align: right " data-aos=fade-left data-aos-delay=50 data-aos-anchor="#filtrosfull" >
    <a href="" class="btn btn-outline-primary btn-sm btn-rounded waves-effect btvertodos">Todos os tipos de contratos</a>
</div>
<div class="info-card" style="perspective: 1800px; " data-aos=fade-left data-aos-delay=80 data-aos-anchor="#filtrosfull">
    <div class="front " id="front_contrato1" style="height:  600px; width:100%">
        <div class="" style="position: relative;">
            <div class="card-header">                      
                <div class="row">
                    <div class="col-12">
                        <div style="float: left; width:100%">
                            <h5><i class="fas fa-briefcase"  style="color: #777;"></i> <span class="titiintcont">Total de Horas por Contrato em {{$contrato_ativo}} </span></h5>
                            
                        </div>
                        
                    </div>
                        <div class="col-md-4"></div>
                        
                        <div class="col-md-4"></div>
                </div>
            </div>

            
            <div class="tab-content" id="pills_contrato-tabContent" style="margin-top: -20px;">
                <div class="tab-pane fade show active" id="pills_contrato-hs" role="tabpanel" aria-labelledby="pills_contrato-hs-tab" style=" width: 100%; ">
                    @include('pages.home.grafico_contrato_hs')     
                </div>
                <div class="tab-pane fade show active" id="pills_contrato-rs" role="tabpanel" aria-labelledby="pills_contrato-rs-tab" style=" width: 100%;">
                    @include('pages.home.grafico_contrato_rs')
                </div>
            </div>
            
        </div>  
    </div>
    <div class="back" id="back_contrato1" style="width:100%">
        <div class="" style="position: relative;">
            <div class="card-header"> 
                <h5><i class="far fa-building"  style="color: #777;"></i> Contrato em {{$contrato_ativo}}</h5>                    
            </div>
            <div class="card-body cardback addheit" style=" height: 500px; margin-top: -10px">
                <div class="row">
                    <table id="example_contrato" class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contratos</th>   
                                @if(Auth::user()->perfil == 2)
                                    <th ><i class="fas fa-running"></i></th>    
                                    <th >R$</th>    
                                @endif
                                <th >Horas</th>    
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                        @foreach($lista_contratos as $key => $value)
                        <?php $porcentag = $value['total'] * 100 / $total_segundos;  ?>
                            <tr class="shadomtable">
                                <td>{{$value['id']}}</td>
                                <td style="position: relative; padding:2px">
                                    <div style="z-index: 9; position: relative">{{$value['ctnome']}} </div>
                                   
                                    
                                    <div style="position: absolute; z-index: 1; top: 2px; left: 0px; height: 88%; width: 100%"></div>
                                </td>
                                @if(Auth::user()->perfil == 2) 
                                <td>{{$value['totaluser']}}</td> 
                                <td class="text-right"><span  class="valor">{{$value['custo']}}</span></td> 
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
                    <button type="button" id="btvira_contrato" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i> voltar</button>
                </div>
            </div>
        </div>
    </div>
</div>                         
 

<?php
    // echo '<pre>';
    // var_dump($total_horas);
    // echo '</pre>';
?>

<script>
    $(document).ready(function($){
        $('.valor').mask('#.##0,00', {reverse: true});
        // $.fn.dataTable.moment( 'HH:mm' );
        // $('.mdb-select2').materialSelect();
        // $('.form-control').trigger("change");   
        // $('.dropdown-content, .select-dropdown').perfectScrollbar();    
    });
    $('.expand').on('click',function(){        
        $( '#card_empreendimentos' ).toggleClass( "divexpand_emprend" );      
    });

    $('#pills_contrato-hs-tab').on('click',function(){        
        $( '.titiintcont' ).html('Total de Horas por Contrato em <?php echo $contrato_ativo ?>');      
        $('#pills_contrato-rs').css('display', 'none');  
    });
    $('#pills_contrato-rs-tab').on('click',function(){        
        $( '.titiintcont' ).html('Total Financeiro por Contrato em <?php echo $contrato_ativo ?>');       
        $('#pills_contrato-rs').css('display', 'table');  
    });
    $('.btvertodos').on('click',function(e){   
        e.preventDefault();
        $('.cardpeque').removeClass('active');      
        carregar_cards('card_contratos','Todos'); 
    });
    $('#example_contrato').DataTable({
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
            "columnDefs": [ {"targets": [ 0 ],"visible": false,"searchable": false},
                            { type: 'time-uni', targets: 4 }]         
    });
    setTimeout(function(){ 
        $('.buttons-excel').html('<i class="fas fa-file-excel"></i>');
        $('.buttons-excel').addClass('btn btn-outline-success btn-rounded btclear waves-effect');
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        $('.buttons-print').addClass('btn btn-outline-info btn-rounded btclear waves-effect');
        $('#pills_contrato-rs').removeClass('show', 'active');  
        $('#pills_contrato-rs').css('display', 'none');
    },  100);
    $('#btvira_contrato').on('click',function(){        
        $('#front_contrato1').removeClass('virar-front');            
        $('#back_contrato1').removeClass('virar-back');            
    });

    





</script>