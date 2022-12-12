                   
<?php
function horas_segundos($total){
    $horas = floor($total / 3600);
    $minutos = floor(($total - ($horas * 3600)) / 60);
    $segundos = floor($total % 60);
    if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
    if(strlen($horas) == 1){ $horas = '0'.$horas;}
    return $horas . ":" . $minutos;
}

?>
<style>
    .col-sm-12{ padding: 0; margin-top: 20px;}
</style>
 <div class="row">
     <div class="col-7" style="padding: 0; margin: 0;">
        <div class="card-header" style="padding: 0; margin:0; text-align: left; ">
            <h5 style="font-weight: 400; text-transform: uppercase; font-size: 17px" ><i class="far fa-calendar-check" style="color: #ccc;"></i> <span class="titimes"> Dias do ano</span></h5>
        </div>
    </div>
    <div class="col-5 horasano" style="text-align: right; padding: 0; margin: 0;">
        <div class="card-header" style="padding: 0; margin:0;">
            <h5 style="font-weight: 400; text-transform: uppercase; font-size: 17px" ><i class="far fa-clock" style="color: #ccc;"></i> <span class="titimes"> <?php echo horas_segundos($horas_total->horas); ?></span></h5>
        </div>
    </div>
 </div>
 <div class="row">
 <div class="card" style="box-shadow: none; width: 100%;"> 
    <div class="card-body" style="padding: 0; margin-top:20px"> 
    @if(horas_segundos($horas_total->horas) !== '00:00')
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="row">
            
                <div class="col-md-12" style="text-align: left; font-size: 11px">            
                <i class="fas fa-briefcase" style="color: #777"></i> CONTRATOS :  
                    @foreach($horas_contratos as $key => $value)
                        <span class="badgeint cor1"> {{ $value->ctnome }} - <i class="far fa-clock" ></i> <?php echo horas_segundos($value->horas) ?></span>
                    @endforeach
                </div>
                <div class="col-md-12" style="text-align: left; font-size: 11px">
                <i class="fas fa-shield-alt" style="color: #777"></i> PRODUTOS :  
                    @foreach($horas_departamentos as $key => $value)
                        <span class="badgeint cor2"> {{ $value->depnome }} - <i class="far fa-clock" style=""></i> <?php echo horas_segundos($value->horas) ?></span>
                    @endforeach 
                </div>
                <div class="col-md-12" style="text-align: left; font-size: 11px; ">
                <i class="fas fa-snowboarding" style="color: #777"></i> ATIVIDADES :  
                    @foreach($horas_atividades as $key => $value)
                        <span class="badgeint cor3"> {{ $value->atdescricao }} - <i class="far fa-clock" style=""></i> <?php echo horas_segundos($value->horas) ?> </span>
                    @endforeach 
                </div>
                </div>
            </div>
        </div>  
    
        <table id="example_ano" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Inicio</th>    
                    <th>Fim</th>    
                    <th>Horas</th> 

                </tr>
            </thead>
            <tbody>
            @foreach($horas_banco as $key => $value)
                <tr id="tab{{ $value->id }}" class="shadomtable">
                    <td>{{ $value->id }}</td>                                
                    <td><span style="font-size: 1px; color:#fff">{{$value->datainicio}}</span>{{ date( 'd/m/Y' , strtotime($value->datainicio))}}</td>                                    
                    <td><span style="font-size: 1px; color:#fff">{{$value->datafim}}</span>{{ date( 'd/m/Y' , strtotime($value->datafim))}}</td>                                    
                    <td> <?php echo horas_segundos($value->horas) ?></td>                          
                </tr>
            @endforeach                            
            </tbody>
        </table> 
    @endif   
    </div> 
 </div>                       
 </div>
           


<script>


    $('#example_ano').DataTable({ 
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [25, 50, -1],
                [25, 50, "All"]
                ],
            "columnDefs": [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }], 
            responsive: true,
            order: [[ 1, 'desc' ], [ 2, 'asc' ]],
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar",
        }
    });
    setTimeout(function(){ 
        $('.buttons-excel').html('<i class="fas fa-file-excel"></i>');
        $('.buttons-excel').addClass('btn btn-outline-success btn-rounded btclear waves-effect');
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        $('.buttons-print').addClass('btn btn-outline-info btn-rounded btclear waves-effect');
    },  100); 
</script>