

<div class="card"  {{$add_anima ?? ''}}>
    <div class="card-header">
        <h5><i class="fas fa-project-diagram" style="color: #ccc;"></i> Todas as relações</h5>
    </div>
    <div class="card-body">
        <div class="row">
        <table id='example' class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Departamento</th>
                    <th></th>
                    <th>Atividade</th>
                    <th></th>
                </tr>
            </thead>
            </table>
        </div>                        
    </div>
</div>

<script>
    $(document).ready(function(){
        // DataTable
        $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel',  'print'],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('shadomtable');
            $(row).attr({id:'tab'+data['id']});
        },

        processing: true,
        serverSide: true,
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Buscar",
            },

        ajax: "{{route('get_atividade_dataajax')}}",
        lengthMenu: [[50],],
        order: [[ 1, 'asc' ]],
        columns: [
            { data: 'id' },
            { data: 'depnome' },
            { data: 'setinha' },
            { data: 'atdescricao' },
            { data: 'acao' },
        ],
        columnDefs: [{
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }], 
        });
});

    setTimeout(function(){ 
        $('.buttons-excel').html('<i class="fas fa-file-excel"></i>');
        $('.buttons-excel').addClass('btn btn-outline-success btn-rounded btclear waves-effect');
        $('.buttons-print').html('<i class="fas fa-print"></i>');
        $('.buttons-print').addClass('btn btn-outline-info btn-rounded btclear waves-effect');
    },  100); 
</script>