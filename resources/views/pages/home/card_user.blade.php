<?php
function horas_segundos($total){
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
    if(strlen($horas) == 1){ $horas = '0'.$horas;}
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
<style>.percent{ position: absolute; top: 60px; left: 50%; margin-left: -15px;}</style>
 <!-- Change chart -->
 
 <div class="card-body card-body-cascade text-center" style="position: relative;">

<span class="min-chart my-4" id="chart-sales" data-percent="<?php echo $porcentagem ?>"><span class="percent"></span></span>

</div>
<?php
// echo '<pre>';
//     var_dump($total_dias);
// echo '</pre>';
?>

<script>

    // Small chart
    $(function () {
      $('.min-chart#chart-sales').easyPieChart({
        barColor: "#4caf50",
        onStep: function (from, to, percent) {
          $(this.el).find('.percent').text(Math.round(percent)+'%');
        }
      });
    });
    
</script>