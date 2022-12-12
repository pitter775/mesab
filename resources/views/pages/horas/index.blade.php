@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'horas',
    'elementActive2' => ''
])
<style>
    .col-centered{
    float: none;
    margin: 0 auto;
}
</style>
@section('content')
<div class="content">
<div class="modal fade" id="myModal_editatv" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content" id="retorno_editatv"></div>
    </div>
</div>




    <input type="hidden" value="" id="data_voltar_calend">
    <input type="hidden" value="{{Auth::user()->horas_ilimitadas}}" id="horas_ilimitadas">

    <!-- depois que seleciona a data no calendario -->
    <div class="row">
        <div class="col-md-12" id="card_horas" style="z-index: 9; background-color: none !important; " ></div>
    </div>
    <div class="row">
        <div class="col-md-10" id="card_horas_lista" ></div>
    </div>

    <!-- antes de selecionar a data no calendario -->
    <div class="row" >
        <div class="col-md-12" id="card_calendario" >            
        </div>        
    </div>
    <div class="row">
        <div class="col-md-12" id="card_lista"></div>
    </div>
    <div id="calendar"></div>
    @extends('pages.horas.script_page')  
    
</div>


 
        <script>
            $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

            $(document).ready(function () { 
                add_cards(null);  
            }); 


        </script>

@endsection