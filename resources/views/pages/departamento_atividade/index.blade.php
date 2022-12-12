@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'relacionamentos',
    'elementActive2' => 'departamento_atividade'
])

@section('content')

<div class="modal fade" id="myModal_lista" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content" id="retorno_modal_lista"></div>
    </div>
</div>

    <div class="content">
        <div class="row">
            <div class="col-md-12" id="card_create"></div>
        </div>
        <div class="row">
            <div class="col-md-12" id="card_lista"></div>
        </div>
    </div>
@endsection

@push('scripts')
    @extends('pages.departamento_atividade.script_page')  

    <script>
    $(document).ready(function () { 
       add_cards(null);         
    });       
    </script>
@endpush