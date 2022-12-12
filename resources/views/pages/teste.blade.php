@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'criacao',
    'elementActive2' => 'usuarios'
])

@section('content')

<div class="content">
        <div class="row">
            <div class="col-md-12" id="card_create">
            <table id="example" class="table table-bordered display nowrap" style="width:100%">
                <thead >
                    <tr style="border-bottom: solid 5px #ccc !important;">
                        <th>ID Evento</th>
                        <th>Email</th>                                    
                        <th>Nome</th>
                        <th>Contrato</th>
                        <th>Atividade</th>
                        <th>Horas</th>
                        <th>Data Inicio</th>
                        
                    </tr>
                </thead>
                <tbody>
                @foreach($veratividade as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->ctnome }}</td>
                        <td>{{ $value->atdescricao }}</td>
                        <td>{{ $value->horas }}</td>
                        <td>{{ $value->datainicio }}</td>
                    </tr>
                @endforeach                            
                </tbody> 
            </table> 
            </div>
        </div>
</div>

@endsection


@push('scripts')

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
   
    </script>
@endpush