
<style>
    .funfaanima{ position: absolute; height: 10px; background-color: #fff; width: 10px; margin-top: -500px; z-index: 0;}
    
    
</style>
<div class="card card_lista_cale" {{$add_anima ?? ''}} >
    <div class="funfaanima"></div>
        <div class="card-body">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#mesatual" role="tab" aria-expanded="true" aria-selected="true"> MÊS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#anoatual" role="tab" aria-expanded="false" aria-selected="false">ANO</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="my-tab-content" class="tab-content text-center">
                <div class="tab-pane active show" id="mesatual" role="tabpanel" aria-expanded="true" >
                </div>
                <div class="tab-pane" id="anoatual" role="tabpanel" aria-expanded="false">
                </div>
            </div>
        </div>
</div>

<script>
    $('#example').DataTable({ 
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
function transforma_magicamente(s){
  function duas_casas(numero){
    if (numero <= 9){
      numero = "0"+numero;
    }
    return numero;
  }
  hora = duas_casas(Math.round(s/3600));
  minuto = duas_casas(Math.round((s%3600)/60));
  segundo = duas_casas((s%3600)%60);
  formatado = hora+":"+minuto+":"+segundo;
  return formatado;
}
</script>