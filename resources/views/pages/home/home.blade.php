@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'home',
    'elementActive2' => ''
])

@section('content')

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content" id="retorno_modal"></div>
    </div>
</div>


<div class="modal fade" id="myModalCalend" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="background-color: #fff; padding: 20px;">
        <div class="modal-content"  style="box-shadow: none" >
            <div class="modal-header" style="padding: 0; margin: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="cardnome" class="modalusercalend"  style="margin-top:  -20px;" ></div>
            <div id="card_calendario" class="modalusercalend" ></div>
            <div id="card_lista" class="modalusercalend"></div>        
        </div>
    </div>
</div>


<div class="modal fade" id="myModalRelatorio" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="background-color: #fff; padding: 20px;">
        <div class="modal-content"  style="box-shadow: none" >
            <div class="modal-header" style="padding: 0; margin: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="card_relatorio"> Carregando...</div>      
        </div>
    </div>
</div>
<div class="modal fade" id="myModalRelatorio_completo" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="background-color: #fff; padding: 20px;">
        <div class="modal-content"  style="box-shadow: none" >
            <div class="modal-header" style="padding: 0; margin: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="card_relatorio_completo"> Carregando...</div>      
        </div>
    </div>
</div>
<style>
    .navint { width: 100%; margin-top: 20px; }
    .navint li{ list-style: none; color: #777;  display: inline; border-radius: 5px ; padding: 5px 10px; font-size: 10px; font-weight: 700; cursor: pointer; font-family: "Roboto", sans-serif; text-transform: uppercase;}
    .navint li.ativo{ background-color: #2f558a !important;  box-shadow: 0 16px 26px -10px rgb(63 106 216 / 56%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(63 106 216 / 20%); color: #fff;}
    .navint li:hover{background-color: #dae5f4; }
    .navhoras{ position: absolute; right: 0; top: -85px}

    
    .md-form { margin-top: 2px;}
    .badge{ box-shadow: none; font-size: 11px; font-weight: 400; padding: 5px 20px !important; border:none}
    .txtcenter{ text-align: center;}
    .h5center{ margin: 0; padding: 0; margin-top: -25px; font-size: 25px; font-weight: 400 !important; color: #566985}
    .icohear{ color: #ccc; position: absolute; right: -5px; top: -8px; font-size: 15px; border-radius: 5px; background-color: #fff; padding: 5px;  -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.1), 0 4px 10px 0 rgba(0, 0, 0, 0.05); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.1), 0 4px 10px 0 rgba(0, 0, 0, 0.05);}
    .icohear2{ color: #777; z-index: 999999; position: absolute; right: -5px; top: -8px; font-size: 15px; border-radius: 5px; background-color: #fff; padding: 5px;  -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.1), 0 4px 10px 0 rgba(0, 0, 0, 0.05); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.1), 0 4px 10px 0 rgba(0, 0, 0, 0.05);}
    .highcharts-credits{ display: none;}
    .highcharts-a11y-proxy-button { display: none !important;}
    .highcharts-exporting-group { display: none !important;}
    .highcharts-legend{ display: none;}
    .progress {height: 3px;};  
    .info-card {float: left;}
    .front, .back {transition: -webkit-transform 0.8s;   -webkit-transform-style: preserve-3d; transform-style: preserve-3d;-webkit-backface-visibility: hidden;backface-visibility: hidden;}
    .front {overflow: hidden;width: 100%;position: absolute;z-index: 1;}
    .back {width: 100%;-webkit-transform: rotateY(-180deg);transform: rotateY(-180deg);}
    .virar-front {-webkit-transform: rotateY(180deg);transform: rotateY(180deg);}
    .virar-back {-webkit-transform: rotateY(0);transform: rotateY(0);}
    .card-image {width: 100%;}    
    /* .tamanhocard{margin-top: 37px; height: 590px} */
    .divexpand_emprend{ position: absolute; width: 133.5% !important; top:0; left: -33.5%; z-index: 999; flex: 0 0 133.5% !important; max-width: 133.5% !important;}
    #card_empreendimentos{ width: 100%;}
    .divexpand{ width: 100%; top:0; left: 0; z-index: 999; flex: 0 0 100%; max-width: 100%;}
    .divexpand_meio{ position: absolute; width: 50%; top:0; left: 0; z-index: 999; flex: 0 0 50%; max-width: 50%;}
    .divexpand_meio .card{  box-shadow: 0 0px 30px -4px rgb(0 0 0 / 45%); }
    .somedivs{ opacity: 0; -webkit-transition: all 1s;    -moz-transition: all 1s;    -o-transition: all 1s;    transition: all 1s;}
    .filtro_lateral{ width: 600px; height: 450px; position: fixed; top: 70px; left: -665px; z-index: 99; }
    .btfecharfiltro{ font-size: 18px; cursor: pointer; }
    .topdash{ height: 90px; width: 100%; position: fixed; top: 50px; margin-left: -30px;  background-color: #f7fafc; border-bottom: solid 1px #dde8f3; z-index: 2; padding: 20px 280px 20px 20px;}
    a.bttaba { 
        background-color: none !important;
        border: none  !important;
        font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif !important;
        font-weight: 600!important;;
        text-transform: uppercase;
        padding: 0;
        font-size: 10px !important;
        margin-right: 10px !important;
     }

     .nav-item .nav_horas.active {
        background-color: #5ec762 !important;
        box-shadow: 0 16px 26px -10px rgb(94 199 98 / 56%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(94 199 98 / 20%);
     }
     .nav-item .nav_financ.active {
        background-color: #2f558a !important;
        box-shadow: 0 16px 26px -10px rgb(63 106 216 / 56%), 0 4px 25px 0px rgb(0 0 0 / 12%), 0 8px 10px -5px rgb(63 106 216 / 20%);
     }
     .nav-item {
        border-radius: 5px !important;   margin-right: 10px !important; padding: 5px !important; border: none !important;       
     }
    .nav-pills .nav-item:first-child .nav-link , .nav-pills .nav-item:last-child .nav-link , .nav-item {
        border-radius: 5px !important;
    }
    .nav-pills .nav-item .nav-link { border: none; padding: 5px 10px; font-size: 10px;}
    


    @media only screen and (max-width: 600px) {
        /* .tamanhocard{margin-top: 37px; height: 600px} */
    }
    @media only screen and (max-width: 990px) {
        .filtro_lateral{ width: 400px; height: 700px; padding: 30px; margin-top: -30px;  display: block; overflow-y: scroll;}
        .cardhoratop{ width: 100%; margin-left: -20px;}
        .topdash{padding: 20px 0px 20px 20px; margin-left: -15px}
        .divdias{ display: none;}
        .chardcardrigh{ display: none;}
        .nocelular{ display: none;}
        .vltotal{ font-size: 16px !important;}
    }
</style>


<div class="filtro_lateral">
    <div class="card" style="box-shadow: 0 13px 20px -4px rgb(0 0 0 / 35%);">
        <div class="card-header" style="display: table;">
            <div style="float: left;">
                <h5 style="margin: 0; padding:0; font-weight:300; color: #000; margin-bottom: 20px"> 
                    <i class="nc-icon nc-zoom-split" style="color: #000; font-size: 15px; margin-top: 2px; opacity:.5; margin-right: 10px"></i> 
                        Filtro Dashboard 
                </h5>
            </div>
            <div style="float: right;">                
                <i class="fas fa-times btfecharfiltro"></i>
            </div>
              
        </div>
        <div class="card-body" style=" width: 100%; ">
            <form name="form_filtros" id="form_filtros" class="col-md-12" style="width: 100%; margin: 0; padding:0; @if(Auth::user()->perfil == 0) padding-bottom: 0px @endif">                    
                @csrf  
                <div class="row"> 
                    <div class="col-md-6">
                        <div class="md-form">
                            <input type="text" id="data_inicio" class="form-control datepicker" name="data_inicio" value="{{$datainicio}}" >
                            <label for="data_inicio" class="active"><i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Início</label>
                        </div>  
                    </div>
                    <div class="col-md-6">
                        <div class="md-form">
                            <input type="text" id="data_fim" class="form-control datepicker" name="data_fim" value="{{$datafim}}" >
                            <label for="data_fim" class="active"> <i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Fim</label>
                        </div>  
                    </div> 
                    
                </div>
                @if(Auth::user()->perfil == 0)
                    <input type="hidden" name="usuario" id="usuario" value="{{ Auth::user()->id }}">
                @endif

                @if(Auth::user()->id == 214 )
                    <input type="hidden" name="equipe" id="equipe" value="3">
                @endif
                    
                <div id="card_filtros" class="row dvfiltros" style="@if(Auth::user()->perfil == 2) margin-top: 14px @endif  "></div>
                                                
            </form>
        </div>
    </div>
</div>
<div class="content"  style="width: 100%; margin-top: 160px">
    
    <div class="topdash">
        <div id="card_horas"></div>
    </div>
    
    <div class="row">
        <div class="col-md-12" >
            <div class="card">
                <div class="card-body" style="height: 800px;">
                    <div class="row" id="card_pequenos"></div>
                    <div class="row">
                        <div class="col-md-4" style="padding-top: 20px; height:60px"></div>  
                        <div class="col-md-12 cards_margin anima_geral"  id="card_contratos" style="margin-top: -10px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row" id="mae" >                              
                <div class="col-md-12 cards_margin2 anima_geral"  id="card_atividades" ></div>
                <div class="col-md-7" id="card_alocacaos" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>
                <div class="col-md-5" id="card_alocacaos_dep" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>
                <!-- <div class="col-md-12 cards_margin2 anima_geral"  id="card_alocacaosDep" ></div> -->


                <div class="col-md-4 cards_margin anima_geral"  id="card_produtos"></div>
                <!-- <div class="col-md-4" id="card_equipes" @if(Auth::user()->perfil == 0) style="display:none" @endif></div> -->
                <div class="col-md-4" id="card_alocacaos" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>


                @if(Auth::user()->perfil == 2) 
                <div class="col-md-12">
                    <div class="card"> 
                        <div class="card-body">
                            <div class="row" id="card_f_pequenos" style="padding: 0 20px;" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>
                            <div class="row" id="card_usuarios" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>     
                        </div>                     
                    </div>
                </div>
                @endif
       
              

                <div class="col-md-4" id="card_funcaos" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>
                <div class="col-md-4" id="card_departamentos" @if(Auth::user()->perfil == 0) style="display:none" @endif></div>
            </div>
            
        </div>

            


    </div>
</div>
@endsection



@push('scripts')
<script>
    
    var appUrl ="{{env('APP_URL')}}";
    // var modulo = 'home';
    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    $(document).ready(function () {   
        $(".datepicker").pickadate({
            isRTL: false,
            format: 'dd/mm/yyyy',
            autoclose:true,
            language: 'pt-br'
        });       
        carregar_cards('card_filtros'); 
        allcards(); 
          
    });
    $(document).on('click', ".btlimpar", function() {
        location.reload();      
        //carregar_cards('card_filtros');      
	});
    $(document).on('click', ".btfiltro", function() {    
        var windowWidth = window.innerWidth;
        // console.log(windowWidth);
        if(windowWidth < 990){vim = '10px'; $('.filtro_lateral').perfectScrollbar();   }else{ vim = '270px'}
        $(".filtro_lateral").animate({left: vim, opacity: '1',}, 500, 'easeOutCirc');
	});
    $(document).on('click', ".btfecharfiltro", function() {    
        $(".filtro_lateral").animate({left: '-670px', opacity: '0',}, 500, 'easeInCirc');
	});
    $("#form_filtros").submit(function(e) {           
        e.preventDefault(); 
        allcards();
        $(".filtro_lateral").animate({left: '-670px', opacity: '0',}, 500, 'easeInCirc');
    });
    $('#pills-home-tab').on('click',function(){           
        $('#pills-home').css('display', 'table'); 
        setTimeout(function(){ 
            $('#pills-home').css('display', 'table'); 
        },  3000);
    });
    $('#pills-profile-tab').on('click',function(){
        setTimeout(function(){ 
            $('#pills-home').css('display', 'none'); 
        },  200);
    });
    setTimeout(function(){ 
        $('#pills-home').removeClass('show', 'active');  
        $('#pills-home').css('display', 'none');
    },  4000);


    $( "#cttipo" ).change(function() {
        var str = "";
        $( "#cttipo option:selected" ).each(function() {str += $( this ).text();});
        carregar_cards('card_contratos',str); 
    });

    function carregar_cards(card, param = null){
        if(param == 'Todos'){ param = null}      
  
        let atualizar = true;
        let div = '#'+card;      
            $(div).html('');
        let form = $('#form_filtros');
        var dados_serealize = [];
            dados_serealize =  form.serializeArray();
            dados_serealize.push({name: "card", value: card},{name: "param", value: param});
            $(div).children().addClass('somedivs');
            // console.log(dados_serealize);
            if(atualizar){
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: appUrl+'/home/get_card',
                    data: dados_serealize, 
                    success: function(data)
                    {                
                        $(div).html(data);
                    }
                });
                return false;
            }
    }
    
    function allcards(){
      
        carregar_cards('card_horas'); 
        carregar_cards('card_pequenos'); 
        carregar_cards('card_contratos','Todos');
        carregar_cards('card_atividades','Todos');
        // carregar_cards('card_alocacaos'); 
        // carregar_cards('card_alocacaos_dep', 'MEQ'); 
        // carregar_cards('card_alocacaosDep','Todos');
        // carregar_cards('card_produtos'); 
        // carregar_cards('card_equipes'); 
       
        
        
        carregar_cards('card_f_pequenos'); 
        // carregar_cards('card_funcaos'); 
        // carregar_cards('card_departamentos'); 
        carregar_cards('card_usuarios','Todos');        
        if($('#usuario').val() !== ''){
            setTimeout(function (data) { carregar_cards('card_user'); },100);
        }

    }

    $('.close').on('click',function(){           
        $('.modalusercalend').html('');        
    });
    function exibir_calend(user){
        // console.log('teste');
        dados = {usuario: user}; 


        $.get(appUrl+'/horas/add/create-1', dados, function(dados){
            $('#card_calendario').html(dados);
        }); 

        $.get(appUrl+'/horas/add/lista-1', dados, function(dados){
            $('#card_lista').html(dados);
        });
    }

    function mostrar_relatorio(){
        $('#card_relatorio').html('Carregando...');
 
        let form = $('#form_filtros');
        let param = null;
        let atualizar = true;
        var dados_serealize = [];
            dados_serealize =  form.serializeArray();
            dados_serealize.push({name: "card", value: 'card_relatorio'},{name: "param", value: param});

            console.log(dados_serealize);
            if(atualizar){
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: appUrl+'/home/get_card',
                    data: dados_serealize, 
                    success: function(data)
                    {                
                        $('#card_relatorio').html(data);
                    }
                });
                return false;
            }
    }
    function mostrar_relatorio_completo(){
        $('#card_relatorio_completo').html('Carregando...');
 
        let form = $('#form_filtros');
        let param = null;
        let atualizar = true;
        var dados_serealize = [];
            dados_serealize =  form.serializeArray();
            dados_serealize.push({name: "card", value: 'card_relatorio_completo'},{name: "param", value: param});

            console.log(dados_serealize);
            if(atualizar){
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: appUrl+'/home/get_card',
                    data: dados_serealize, 
                    success: function(data)
                    {                
                        $('#card_relatorio_completo').html(data);
                    }
                });
                return false;
            }
    }
</script>
    
@endpush