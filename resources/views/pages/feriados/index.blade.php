@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'criacao',
    'elementActive2' => 'feriados'
])

@section('content')
<div class="modal fade" id="myModal_lista" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content" id="retorno_modal_lista"></div>
    </div>
</div>

    <div class="content">
        <input type="hidden" value="" id="data_voltar_calend">
        <div class="row">
            <div class="col-md-12" id="card_create"></div>
        </div>
        <div class="row">
            <div class="col-md-12" id="card_lista"></div>
        </div>
    </div>
    <?php
        // echo '<pre>';
        // var_dump($feriados);
        // echo '</pre>';

        // // $ano_=date("Y");// $ano_='2010'; 
        // foreach($feriados as $key => $a)
        // {
        //  echo date("Y-m-d",$key).'<br>';						 
        // }
    ?>
@endsection

@push('scripts')
    @extends('pages.feriados.script_page')  

    <script>
    $(document).ready(function () { 
       add_cards(null);         
    });      
    </script>
@endpush