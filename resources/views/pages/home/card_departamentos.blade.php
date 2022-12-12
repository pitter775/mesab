<style>
    #example_departamento_length{display: none;}
    #example_departamento_filter{display: none;}
    #example_departamento_info{display: none;}
    #example_departamento_first{display: none;}
    #example_departamento_previous{display: none;}
    #example_departamento_next{display: none;}
    #example_departamento_last{display: none;}
    /* #example_departamento_paginate{display: none;} */
</style>
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
$cores=[];   
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

<div class="" style="position: relative; width:100%" data-aos=fade-left data-aos-delay=310 data-aos-anchor="#filtrosfull" >
    <div class="info-card" style="perspective: 1800px; ">
    <i class="fas fa-graduation-cap icohear2"></i>
        <div class="front card" id="front-depa" style="height: 450px">
         
                <div class="card-header">
                    <h5 style="margin-top: -5px;"> Departamento </h5>
                </div>
                <div class="card-body txtcenter" style="position:relative"> 
                    <canvas id="doughnutChart-depa"></canvas>  
                </div> 
                <div class="row" style="padding: 10px">
                    <div class="col-md-12">
                        <button type="button" id="btviraf-depa" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i></button>                   
                    </div>
                </div>
      
        </div>
        <div class="back" id="back-depa">
            <div class="card" style="position: relative;">
                <div class="card-header"> 
                    <h5> Departamento </h5>                    
                </div>
                <div class="card-body" style=" height: 360px; margin-top: -30px">
                    <div class="row">
                        <table id="example_departamento" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Departamento</th>    
                                    <th style="width: 50px;">Horas</th>    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                            @foreach($lista_contratos_horas as $key => $value)
                                <?php $porcentag = $value->total * 100 / $total_segundos;  ?>
                                <tr class="shadomtable">
                                    <td>{{$value->id}}</td>
                                    <td style="position: relative; padding:2px">
                                        <div style="z-index: 9; position: relative">{{$value->depnome}} </div>
                                        <?php array_push($cores, novacor());  ?>
                                        <div style="position: absolute; z-index: 1; top: 2px; left: 0px; background-color: rgb(<?php echo $cores[$cont_tab]?> 0.2); border: solid 1px rgb(<?php echo $cores[$cont_tab]?> 0.5); height: 88%; width: <?php echo round($porcentag)?>%"></div>
                                    </td>
                                    <td class="text-right"><span class="txordem" style="font-size: 1px; color:#fff"><?php echo $ordem[$cont_tab] ?></span><?php echo horas_segundos($value->total); $cont_tab = $cont_tab + 1 ?>hs</td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table> 
                    </div>                        
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-md-12">
                        <button type="button" id="btvirab-depa" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i></button>                   
                  </div>
                </div>
            </div>
        </div>
    </div> 



</div> 

<?php
// echo '<pre>';
// var_dump($lista_contratos_horas);
// echo '</pre>';
?>


<script>
    $(function() {
  AOS.init();
});
     $('#example_departamento').DataTable({
        "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        "pagingType": "full_numbers",
        "lengthMenu": [
                [5,-1],
                [5]
                ],
            responsive: true,
            order: [[ 2, 'asc' ]],
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

    $('#btviraf-depa').on('click',function(){        
        $('#front-depa').addClass('virar-front');            
        $('#back-depa').addClass('virar-back');            
    });

    $('#btvirab-depa').on('click',function(){        
        $('#front-depa').removeClass('virar-front');            
        $('#back-depa').removeClass('virar-back');            
    });


    var ctxD = document.getElementById("doughnutChart-depa").getContext('2d');
    
    var myLineChart = new Chart(ctxD, {
      type: 'doughnut',      
      data: {
        labels: [
            <?php
                foreach($lista_contratos_horas as $value){
                    echo '"'.$value->depnome.' - hs",';
                }    
            ?>
            ],
        datasets: [{
          data: [
            <?php
                foreach($lista_contratos_horas as $value){
                    echo horas_segundos2($value->total).',';
                }    
            ?>
              ],
          backgroundColor: [
            <?php
                $cont_cor = 0;
                foreach($lista_contratos_horas as $value){
                    echo '"rgb('.$cores[$cont_cor].'0.4)",';
                    $cont_cor = $cont_cor + 1;
                }    
            ?>
            ],
            borderColor: [
            <?php
                $cont_cor = 0;
                foreach($lista_contratos_horas as $value){
                    echo '"rgb('.$cores[$cont_cor].'0.9)",';
                    $cont_cor = $cont_cor + 1;
                }    
            ?>
            ],
            borderWidth: 1
        }]
    },
      options: {
        animation: false,
        legend: {
            display: false,
        },
        responsive: true
      }
    });

</script>