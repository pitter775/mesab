<style>
    .avatarp2 {height: 30px;width: 30px !important; margin: 2px!important;  background-color: #bbb; border-radius: 50%; box-sizing:unset; object-fit: cover; margin-top: -5px; box-shadow: 0 4px 8px 0 rgb(34 41 47 / 12%), 0 2px 4px 0 rgb(34 41 47 / 8%);}
</style>
<div class="card"{{$add_anima ?? ''}} >
    <div class="card-header">
        <h5> <i class="fas fa-users" style="color: #ccc;"></i> Todos os usuários</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="example" class="table table-bordered display nowrap" style="width:100%">
                <thead >
                    <tr style="border-bottom: solid 5px #ccc !important;">
                        <th>ID</th>
                        <th>Nome</th>                                    
                        <th>Email</th>
                        <th>Departamento</th>              
                        <th>Função</th>
                        <th>Tarifa</th>
                        <!-- <th>Perfil</th> -->
                        @if(auth()->user()->perfil !== '2')
                        <th style="width: 50px;"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @foreach($dados_lista as $key => $value)
                    <tr id="tab{{ $value->uid }}" class="shadomtable"s>
                        <td> {{ $value->uid }}</td>
                        <td><img class="avatarp2" src="/storage/{{ $value->foto }}" style="width: 30px;"> {{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->depnome }}</td>
                        <td>{{ $value->fndescricao }}</td>
                        <td>{{ $value->valor }}</td>
                        <!-- <td>@if($value->perfil == '0') Usuário @endif @if($value->perfil == '2') Admin @endif</td>                                         -->
                        @if(auth()->user()->perfil !== '2')
                        <td>
                            <a href="#" class="btn btn-outline-primary btn-sm btn-rounded waves-effect" data-toggle="modal" data-target="#myModal_lista" onclick="editar_lista('{{ $value->uid }}')"><i class="fas fa-pencil-alt"></i></a>
                            <a href="#" class="btn btn-outline-danger btn-rounded btn-sm waves-effect" onclick="return deletar_item('{{ $value->uid }}')"><i class="fas fa-trash-alt"></i></a>
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
            "columnDefs": [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }], 
            responsive: true,
            // scrollX: true,
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