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

function converte_segundos($tempo){
    $segundos = 0;
    list( $h, $m, $s ) = explode( ':', $tempo ); 
    $segundos += $h * 3600; 
    $segundos += $m * 60;
    $segundos += $s;
    return $segundos;
}

$totalhoras = $total_dias * 8;
$totalhoras = $totalhoras.':00:00';
$totalsegundos = converte_segundos($totalhoras);
$totalsegundos = $totalsegundos * count($pessoas);

$totalhoras_banco = 0;
if(isset($resultado[0]->total)){
    $totalhoras_banco = $resultado[0]->total;
}
$porcentagem = 0;
if($totalhoras_banco !== 0){
    $porcentagem = ($totalhoras_banco / $totalsegundos) * 100 ;
}

$porcentagem = round($porcentagem);
// echo $porcentagem;

?>

<style>
        .btfiltro{ background: #fff !important; float: left ;}
        .btrelatorio{ background: #fff !important; }
        .boxdata{float:left; margin-left: 20px;}
</style>
 
<div class="row cardhoratop" data-aos-delay=0 data-aos-anchor="#filtrosfull">

    <div class="col-7" style="margin-top: 10px;">
        <button type="button" class="btn btn-outline-primary btn-sm btn-rounded waves-effect btfiltro"><i class="nc-icon nc-zoom-split"></i> Filtrar</button>
        <div class="boxdata" >
            <span style="font-weight: 600; font-size: 14px; color:#38465a"><span class="dtini"></span>  <br>
            <span class="dtfim"></span></span>  
            <span class="divdias" style="font-weight: 600; font-size: 14px; margin-left:20px; color:#727f93">{{$total_dias}} dias </span>
        </div>
        @if(Auth::user()->perfil == 2) 
            <button type="button" style="float: right; cursor: pointer;" data-toggle="modal" data-target="#myModalRelatorio" onclick="mostrar_relatorio()" class="btn btn-outline-primary btn-sm btn-rounded waves-effect btrelatorio">Relatório de usuários</button>
            <button type="button" style="float: right; cursor: pointer;" data-toggle="modal" data-target="#myModalRelatorio_completo" onclick="mostrar_relatorio_completo()" class="btn btn-outline-primary btn-sm btn-rounded waves-effect btrelatorio">Relatório Completo</button>
        @endif
    </div>
    <div class="col-5" style="text-align: right; margin-top: 5px">
        @if(Auth::user()->perfil == 2) 
        <h5 class="vltotal" style="font-size: 18px; font-weight: 600; color: #2f558a;"> R$ <span class="valor" id="valortotalf">{{$soma_valor}}</span></h5>  
        <h5 class="vltotal" style="font-size: 18px; font-weight: 600; color: #08650b; margin-top: -10px;"><i class="far fa-clock"></i> <?php echo horas_segundos($totalhoras_banco)?></h5>
        @else
        <h5 class="vltotal"  style="font-size: 18px; font-weight: 600; color: #08650b; margin-top: 15px;"><i class="far fa-clock"></i> <?php echo horas_segundos($totalhoras_banco)?></h5>
        @endif
    </div>
</div>




<?php
// echo '<pre>';
//     var_dump($addvalor);
// echo '</pre>';
?>

<script>
    $(document).ready(function($){
        $('.valor').mask('#.##0,00', {reverse: true});
        $('.dtini').text($('#data_inicio').val());
        $('.dtfim').text($('#data_fim').val());
    });
</script>