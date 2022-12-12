<div class="card card_lista_cale wow fadeInRight"  id="card_add_horas_lista">
    <div class="card-header">
        <h5><i class="far fa-clock" style="color: #ccc;"></i> Somente esse periodo</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="example2" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Inicio</th>    
                        <th>Fim</th>    
                        <th>Contrato</th>    
                        <th>Produto</th>    
                        <th>Atividade</th>    
                        <th>Tempo</th>    
                        @if(auth()->user()->perfil !== '2')
                        <th style="width: 20px;"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($dados_lista as $key => $value)
                    <tr id="tab{{ $value->id }}" class="shadomtable">
                        <td>{{ $value->id }}</td>                                
                        <td>{{ date( 'd/m/Y' , strtotime($value->datainicio))}}</td>                                    
                        <td>{{ date( 'd/m/Y' , strtotime($value->datafim))}}</td>                                    
                        <td>{{ $value->ctnumero }} - {{ $value->ctnome }}</td>                                    
                        <td>{{ $value->depnome }}</td>                                    
                        <td>{{ $value->atdescricao }}</td>                                    
                        <td>{{ $value->horas }}</td>                                    
                        @if(auth()->user()->perfil !== '2')
                        <td>                            
                            <a href="#" id="del{{ $value->id }}" class="btn btn-outline-danger btn-rounded btn-sm waves-effect" data-tempo="{{ $value->horas }}" onclick="return deletar_item('{{ $value->id }}')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        @endif
                    </tr>
                @endforeach                            
                </tbody>
            </table> 
        </div>                        
    </div>
</div>

<script>
    $('.btssalvar').show();
    $('#example2').DataTable({ 
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