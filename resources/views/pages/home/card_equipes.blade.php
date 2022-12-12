<style>
    #example_equipe_length{display: none;}
    #example_equipe_filter{display: none;}
    #example_equipe_info{display: none;}
    #example_equipe_first{display: none;}
    #example_equipe_previous{display: none;}
    #example_equipe_next{display: none;}
    #example_equipe_last{display: none;}
    /* #example_equipe_paginate{display: none;} */
</style>
<?php
  $cores = ['107, 208, 152,','210,85,42,','169,57,144,','57,169,136,','169,57,57,','123,57,169,','98,176,179,','221,170,46,','178,221,46,', '107, 208, 152,','507, 108, 152,','12,162,206,','210,85,42,','169,57,144,','57,169,136,','169,57,57,','123,57,169,','98,176,179,','221,170,46,','178,221,46,'];       
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
    // $horas = number_format($horas,2, ',', '.');
    return $horas . ":" . $minutos;
}
function horas_segundos2($total){
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    return $horas . "." . $minutos;
}
?>

<div class="" style="position: relative;display: table; width:100%;" data-aos=fade-left data-aos-delay=280 data-aos-anchor="#filtrosfull">
    <div class="info-card" style="perspective: 1800px; ">
    <i class="fas fa-hat-wizard icohear2"></i>
        <div class="front card" id="front-eq"  style="height: 450px">
                <div class="card-header">
                    <h5 style="margin-top: -5px;"> Equipes </h5>
                </div>
                <div class="card-body txtcenter" style="position: relative"> 
                    <canvas id="doughnutChart-eq"></canvas>  
                </div> 
                <div class="row" style="padding: 10px" >
                    <div class="col-md-12">
                        <button type="button" id="btviraf-eq" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-table"></i></button>                   
                    </div>
                </div>
      
        </div>
        <div class="back" id="back-eq">
            <div class="card" style="position: relative;">
                <div class="card-header"> 
                    <h5> Equipes </h5>                    
                </div>
                <div class="card-body" style=" height: 360px; margin-top: -30px">
                    <div class="row">
                        <table id="example_equipe" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Equipes</th>    
                                    <th style="width: 40px;">Horas</th>    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total_segundos = $total_horas[0]->total; $cont_tab = 0 ?>

                            @foreach($lista_contratos_horas as $key => $value)
                                <?php $porcentag = $value->total * 100 / $total_segundos;  ?>
                                <tr class="shadomtable">
                                    <td>{{$value->id}}</td>
                                    <td style="position: relative; padding:2px">
                                        <div style="position: absolute; top: 3px; left: 10px">{{$value->eqnome}} </div>
                                        <div style="background-color: rgb(<?php echo $cores[$cont_tab]?> 0.2); border: solid 1px rgb(<?php echo $cores[$cont_tab]?> 0.5); height: 25px; width: <?php echo round($porcentag)?>%"></div>
                                    </td>
                                    <td class="text-right"><?php echo horas_segundos($value->total); $cont_tab = $cont_tab + 1 ?>hs</td>
                                </tr>
                            @endforeach 
                            </tbody>
                        </table> 
                    </div>                        
                </div>
                <div class="row" style="padding: 10px;">
                    <div class="col-md-12">
                        <button type="button" id="btvirab-eq" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-chart-pie"></i></button>                   
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
     $('#example_equipe').DataTable({ 
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [4,-1],
                [4]
                ],
            responsive: true,
            order: [[ 2, 'desc' ]],
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

    $('#btviraf-eq').on('click',function(){        
        $('#front-eq').addClass('virar-front');            
        $('#back-eq').addClass('virar-back');            
    });

    $('#btvirab-eq').on('click',function(){        
        $('#front-eq').removeClass('virar-front');            
        $('#back-eq').removeClass('virar-back');            
    });


    var ctxD = document.getElementById("doughnutChart-eq").getContext('2d');
    
    var myLineChart = new Chart(ctxD, {
      type: 'bar',      
      data: {
        labels: [
            <?php
                foreach($lista_contratos_horas as $value){
                    echo '"'.$value->eqnome.'",';
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