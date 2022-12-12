<style>
    #dexample_alo_dep_length {
        display: none;
    }

    #dexample_alo_dep_filter {
        display: none;
    }

    #dexample_alo_dep_info {
        display: none;
    }

    #dexample_alo_dep_first {
        display: none;
    }

    #dexample_alo_dep_previous {
        display: none;
    }

    #dexample_alo_dep_next {
        display: none;
    }

    #dexample_alo_dep_last {
        display: none;
    }

    /* #dexample_alo_dep_paginate{display: none;} */
</style>
<?php

function converte_segundos($tempo)
{
    $segundos = 0;
    list($h, $m, $s) = explode(':', $tempo);
    $segundos += $h * 3600;
    $segundos += $m * 60;
    $segundos += $s;
    return $segundos;
}

function horas_segundos($total)
{
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    if (strlen($minutos) == 1) {
        $minutos = '0' . $minutos;
    }
    if (strlen($horas) == 1) {
        $horas = '0' . $horas;
    }
    return $horas . ":" . $minutos;
}
function horas_segundos2($total)
{
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    return $horas . "." . $minutos;
}
// dd($tablefull[0]);
?>
<div class="row">
    <h5 style="padding: 20px;"> Relatório dos Usuários no período</h5>
    <table id="data_relatorio" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Contratos</th>
                <th>Valor por contrato</th>
                <th>Horas por contrato</th>
                <th>Total Horas</th>
                <th>Total Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tablefull as $key => $value)
                @foreach($value['contratos'] as $key => $val)
                @if($value['nome'])

                <tr>
                    <td>{{$value['nome']}}</td>
                    <td>{{$val['contrato']}}</td>
                    <td>{{$val['valorContrato']}}</td>
                    <td>{{$val['segundosContrato']}}hs</td>
                    <td>{{$value['segundosTotal']}}hs</td>
                    <td>{{$value['total']}}</td>
                </tr>
                @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>



<script>
    // $(function() {AOS.init();});
    $('#data_relatorio').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
            [30, -1],
            [30]
        ],
        responsive: true,
        order: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar",
            "decimal": ",",
            "thousands": "."
        }
    });

    setTimeout(function() {
        $('.buttons-excel').html('<i class="fas fa-file-excel"></i>');
        $('.buttons-excel').addClass('btn btn-outline-success btn-rounded btclear waves-effect');
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        $('.buttons-print').addClass('btn btn-outline-info btn-rounded btclear waves-effect');
        // $('#pills_atividade-rs').removeClass('show', 'active');  
        // $('#pills_atividade-rs').css('display', 'none');
    }, 100);
</script>