@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'relacionamentos',
    'elementActive2' => 'relacionamentos'
])

@section('content')
<style>
    .divatividade{  border: solid 1px #d0e3f0; margin-bottom: 10px; padding: 5px 10px; border-radius: 5px; float: left;  margin-right: 10px; box-shadow: none; -webkit-transition: all 0.35s ease-out; transition: all 0.35s ease-out}
    .divatividade:hover {  border: solid 1px #f7fafc; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.12);-webkit-transition: all 0.35s ease-in;transition: all 0.35s ease-in}
    .card-collapse{ padding-bottom: 0; ;}
</style>
    <div class="content">
    <div class="card">
        <div class="card-body">
            <h5> <i class="fas fa-code-branch"></i> Todos os Relacionamentos </h5>
            <div class="row" style="margin-top: 40px;">
            <table id="example_mes" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 80px; text-align:  center">Número</th>   
                        <th>Contrato</th>  
                    </tr>
                </thead>
                <tbody>
                @foreach($contratos as $key => $value) 
                    <tr id="tab{{ $value->id }}" class="shadomtable">
                        <td>{{ $value->ctnumero }}</td>                               
                        <td>
                            <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">                           
                            <div class="card card-plain">
                                <div class="card-header" role="tab" id="headingo{{ $value->id }}">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseo{{ $value->id }}" aria-expanded="false" aria-controls="collapseo{{ $value->id }}" data-id="{{ $value->id }}" class="collapsed btcontrato">
                                <i class="fas fa-briefcase "  style="float: left; font-size: 15px; margin-left: 10px; margin-top: -3px; opacity:.5"></i> {{$value->ctnome}}
                                    <i class="nc-icon nc-minimal-down"></i>
                                </a>
                                </div>
                                <div id="collapseo{{ $value->id }}" class="collapse" role="tabpaneo{{ $value->id }}" aria-labelledby="headingo{{ $value->id }}" >
                                    <div class="card-body" id="verprod{{ $value->id }}">
                                        Carregando...                                        
                                    </div>

                                </div>
                            </div>
                            </div>
                        </td>                           
                    </tr>               
                @endforeach                            
                </tbody>
            </table>
            </div>
        </div>
    </div>

    </div>
@endsection

@push('scripts')
    @extends('pages.contratos.script_page')   

    <script>
        var appUrl ="{{env('APP_URL')}}";

    $(document).on('click', ".btcontrato", function() {
        id = $(this).data('id');
        get_produtos(id);
	});


    function get_produtos(id){
        $.get(appUrl+'/contratos/get_produtos/'+id, function(retorno){
            div = '#verprod'+id;
            $(div).html(retorno);
        });
    }

         $('#example_mes').DataTable({ 
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        "pagingType": "full_numbers",
        "lengthMenu": [
                [25, 50, -1],
                [25, 50, "All"]
                ],
            responsive: true,
            order: [[ 1, 'asc' ]],
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
@endpush