

<div class="card"  {{$add_anima ?? ''}}>
    <div class="card-header">
        <h5><i class="fas fa-project-diagram" style="color: #ccc;"></i> Todas as relações</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="example" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>     
                        <th>contrato / Produto</th>     
                        <th></th>     
                        <th>Atividade</th>     
                    @if(auth()->user()->perfil !== '2')
                        <th style="width: 30px;"></th>
                    @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($dados_lista as $key => $value)
                    <tr id="tab{{ $value->id }}" class="shadomtable"> 
                        <td>{{ $value->id }}</td>     
                        <td>{{ $value->depnome}} </td>    
                        <td style="text-align: center;"><i class="fas fa-arrows-alt-h" style="font-size: 20px; "></i></td>              
                        <td>{{ $value->atdescricao}} </td>               
                    @if(auth()->user()->perfil !== '2')
                        <td><a href="#" class="btn btn-outline-danger btn-rounded btn-sm waves-effect" onclick="return deletar_item('{{ $value->id }}')"><i class="fas fa-trash-alt"></i></a></td>
                    @endif
                    </tr>
                @endforeach                            
                </tbody>
            </table> 
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
            order: [[ 1, 'asc' ], [ 3, 'asc' ]],
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