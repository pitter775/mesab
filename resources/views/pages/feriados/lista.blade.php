

<div class="card" {{$add_anima ?? ''}} >
    <div class="card-header">
        <h5><i class="fas fa-calendar-check"  style="color: #ccc;"></i> Todos os Feriados</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="example" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>    
                        <th>Descricao</th>    
                        <th>Tipo</th>    
                        @if(auth()->user()->perfil !== '2')
                        <th style="width: 30px;"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($dados_lista as $key => $value)
                    <tr id="tab{{ $value->id }}" class="shadomtable">
                        <td>{{ $value->id }}</td>
                        <td><span style="font-size: 1px; color:#fff">{{$value->fn_data}}</span><span style="font-size: 1px; color:#fff">{{$value->fn_data}}</span> {{ date( 'd/m/Y' , strtotime($value->fn_data))}}</td>
                        <td>{{ $value->fn_descricao }}</td>                                    
                        <td>{{ $value->ftdescricao }}</td>                                    
                        @if(auth()->user()->perfil !== '2')
                        <td>
                            <a href="#" class="btn btn-outline-danger btn-rounded btn-sm waves-effect" onclick="return deletar_item('{{ $value->id }}')"><i class="fas fa-trash-alt"></i></a>
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
    $('#example').DataTable({ 
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