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
// dd($lista_usuario_mes[0]);
?>
<div class="row">
    <h5 style="padding: 20px;"> Relatório dos Usuários no período</h5>
    <table id="data_relatorio" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
             
                    <th>ID</th>
                    <th>NOME</th>  
                    <th>Função</th>
                    <th>Data inicio</th>
                    <th>Data fim</th>
                    
                 
                    <th style="width: 40px;"><i class="far fa-clock" style="color: #727f93;"></i></th>
                    <th>R$</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach($lista_usuario_mes as $key => $value) 
                <tr style="background-color: #ccc;">
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>             
                @foreach($value as $key1 => $value1)
                 
                    @foreach($value1 as $key2 => $value2)
                        <tr>
                            <td>{{$value2['id']}}</td>
                            <td>{{$value2['name']}}</td>
                            <td>{{$value2['cargo']}}</td>
                            <td>{{ date( 'd/m/Y' , strtotime($value2['data_inicio']))}}</td>
                            <td>{{ date( 'd/m/Y' , strtotime($value2['data_fim']))}}</td>                            
                            <td><?php echo horas_segundos($value2['total']) ?></td>
                            <td>{{$value2['custo']}}</td>
                        </tr>

                    @endforeach
                   
                @endforeach
              
            @endforeach
        </tbody>
    </table>
</div>

       

<script>
    // $(function() {AOS.init();});
    $('#data_relatorio').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [30,-1],
                [30]
                ],
            responsive: true,
            order: false,
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



</script>