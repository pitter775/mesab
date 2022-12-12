<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('paper') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('paper') }}/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="theme-color" content="#dce9f7">
    <meta content="pitter775@gmail.com" name="author">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <!-- Extra details for Live View on GitHub Pages -->
    
    <title> {{ __('Diário de Ativos') }} </title>
    <meta property="og:description" content="Sistema de Gerenciamento do Diario dos Ativos."/>
    <meta property="og:image" content="https://ativos.cinovasan.com.br/paper/img/timesheet.png" />

    <script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>


    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <!-- CSS Files -->
    <link href="{{ asset('paper') }}/css/normalize.css?v=2.0.0" rel="stylesheet" />
    <link href="{{ asset('css') }}/bganimado.css?v=2.0.0" rel="stylesheet" />
    <link href="{{ asset('fullcalendar') }}/main.css?v=9.0.0" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/selectize.default.css?v=5.0.0" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/bootstrap.min.css?422981258" rel="stylesheet" />
    <!-- <link href="http://200.187.70.117/plesk-site-preview/ativos2021.cinovasan.com.br/https/10.1.0.125/paper/css/bootstrap.min.css?422981258" rel="stylesheet" /> -->
    <link href="{{ asset('paper') }}/css/paper-dashboard.css?v=7.4.0" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/animate.min.css" rel="stylesheet" /> 
    <link href="{{ asset('paper') }}/demo/demo.css?3522981258" rel="stylesheet" />
    <link href="{{ asset('paper') }}/aos/aos.css?1422981258" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/stylesheet.css?v=6.0.0" rel="stylesheet" />
    <link href="{{ asset('select') }}/css/bootstrap-select.min.css?1422981258" rel="stylesheet" />
    <link href="{{ asset('md') }}/mdb.css?v=4.0.0" rel="stylesheet" />    
    <!-- <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet" />     -->
    <!-- <link href="http://200.187.70.117/plesk-site-preview/ativos2021.cinovasan.com.br/https/10.1.0.125/md/mdb.css?v=5.0.0258" rel="stylesheet" /> -->
 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">


</head>
<style>
    .modal { overflow: auto !important; }
    #blanket,#aguarde {position: fixed;display: none;}
    #blanket {left: 0;top: 0;background-color: #f0f0f0;filter: alpha(opacity = 65);height: 100%; width: 100%;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";opacity: 0.65; z-index: 9998;}
    #aguarde {width: 80px; height: 80px; top: 50%; left: 50%;  background: url('https://usevou.com/images/loading.gif') no-repeat 0 50%;  background-size: cover; z-index: 9999;}
    div.dropdown-menu{ margin-left: 20px; z-index: 9999999; max-height: 600px !important; }
    .bootstrap-select > .dropdown-toggle { width: 98% !important;}
    ul.dropdown-menu{ margin-left: 10px; z-index: 9999999; max-height: 400px !important; }
    footer{ display: none !important;}
    .bootstrap-select > select.mobile-device:focus + .dropdown-toggle, .bootstrap-select .dropdown-toggle:focus {
    outline: thin dotted #333333 !important; 
    outline: 0px auto -webkit-focus-ring-color !important;
    outline-offset: 0 !important;}
    .table td{color: #555; font-weight: 500;}
    .tab-content{ margin-top: -30px;}
    .select-dropdown{ font-size: 13px !important; margin-top: -4px !important;}
    .anima_edit td{ background-color: #a0d1ff; border: #4179ae;  color: #000 !important;}
    .anima_add td{ background-color: #a9e89b; border: #3a8d38;  color: #000 !important;}
    .editremove td{ background-color: #ffa9a2; border: #9f4642;  color: #000 !important;}
    .anima td{-webkit-transition: all 1s ease-in;    -moz-transition: all 1s ease-in;    -o-transition: all 1s ease-in;    transition: all 1s ease-in;}
    .anima_geral{-webkit-transition: all .2s;    -moz-transition: all .2s;    -o-transition: all .2s;    transition: all .2s;}
    .dropdown-content, .select-dropdown{ max-height:350px !important; }
    .filtrable{ margin-top: -5px;  }
    .shadomtable {-webkit-box-shadow: none;box-shadow: none;-webkit-transition: all 0.25s ease-in-out;transition: all 0.25s ease-in-out}
    .shadomtable:hover {        -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12);-webkit-transition: all 0.25s ease-out;transition: all 0.25s ease-out;}
    .btredondo{ border-radius: 15px !important; padding: 5px 5px 5px 5px !important;}
    #accordion-2 .card-plain{ background: #f7fafc; border:solid 1px #c9d7e0;  margin-bottom: 5px; padding: 0 10px 0 10px; border-radius: 5px;}
    #accordion-3 .card-plain{ background: #ffff; border:solid 1px #c9d7e0;  margin-bottom: 5px; padding: 0 10px 0 10px; border-radius: 5px;}
    .card-collapse .card .card-header:after {height: 0px;}
    .fc .fc-button-primary {border-radius: 10em; color: #6a99be !important;background-color: transparent !important;border: 2px solid #6a99be !important;display: inline-block;padding: .2rem .6rem !important;font-size: .64rem;box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);}
    .fc .fc-button-primary:hover{background-color: #6a99be !important}
    .fc-today-button{ padding: 10px !important;}
    #example_mes_next{ display: none;}
    #example_ano_next{ display: none;}
    #example_mes_previous{ display: none;}
    #example_ano_paginate{ display: none;}
    .fc-col-header-cell-cushion { font-weight: 600 !important; font-size: 12px;}
    .dropdown-content{ border-radius: 5px;}
    .fc-event-past{ background-color: #dcf4dc !important; border: solid 1px #8bc68b !important;}
    .fc-event-time{ display: none !important;}
    .fc-daygrid-event-dot{display: none !important;}
    .datatrue{ background-color: #dcf4dc !important; border:solid 1px #8bc68b !important}
    .datafalse{ background-color: #dcf5f5 !important; border:solid 1px #69a8e7 !important}
    .dataferiado{ background-color: #ffe1e1 !important; border:solid 1px #e76969 !important}
    .dataHoras{ background-color: #e6e6e6 !important; border:solid 1px #999999 !important}
    .dataferias{ background-color: #f0e2ff !important; border:solid 1px #b28dd8 !important}
    .dataferias_pend{ background-color: #ffffe1 !important; border:solid 1px #d8d78a !important}
    .fc-event-title{ font-weight: normal !important; color: #38465a !important; font-size: 1.1em !important; padding-left: 5px;}
    a.fc-event:hover{ box-shadow: 0 3px 10px -4px rgb(0 0 0 / 35%);}
    a.fc-event{ cursor: pointer !important;}
    .setabaixo{ position: absolute; bottom: -130px; left: 50%; margin-left: -50px; width: 100px;}
    .cor1{  border: solid 1px #c9e2f8; background-color: #e6f2fc;}
    .cor2{  border: solid 1px #a5e7ed; background-color: #e4fdff;}
    .cor3{  border: solid 1px #9ddfb6; background-color: #defdea;}
    .badgeint{font-size: .94em;font-weight: 500;border-radius: .125rem;padding: 4px 8px;text-transform: uppercase;text-decoration: none;margin-bottom: 5px;  display: inline-block;text-align: center;white-space: nowrap;vertical-align: baseline;}
    .main-panel > .content{ margin: 85px auto;}
    .pequeno label input[type="checkbox"]:checked+.lever {background-color: #789abb;}
    .pequeno label input[type="checkbox"]:checked+.lever:after {left: 1.5rem;background-color: #deeffe;}
    .pequeno label .lever:after { width: 15px; height: 15px;     top: 0px; } 
    .buttons-excel:hover{opacity: 0.95;-webkit-transition: all 0.2s ease-in;    -moz-transition: all 0.2s ease-in;    -o-transition: all 0.2s ease-in;    transition: all 0.2s ease-in;}
    .buttons-excel{ opacity: 0.7;}
    .buttons-print{ opacity: 0.7;}

    .buttons-print:hover{opacity: 0.95;-webkit-transition: all 0.2s ease-in;    -moz-transition: all 0.2s ease-in;    -o-transition: all 0.2s ease-in;    transition: all 0.2s ease-in;}
    .btclear{ border: none !important; padding: 5px; padding-top: 0; margin-bottom: 0; box-shadow: none; margin-right: 0px; font-size: 17px;}
    .dt-buttons{ float: left; margin-top: -10px;  margin-left: -5px; }

    .dataTables_filter{ float: right; margin-left: -5px; margin-bottom: 10px;}

/* .cards_margin{ margin: 110px auto;}
.cards_margin1{ margin: 50px auto; margin-bottom: 110px;}
.cards_margin2{ margin: 110px auto; margin-bottom: 200px;} */

@media screen and (min-width: 1300px) {
        .content{ width: 100%;}
    }
    @media screen and (min-width: 1500px) {
        .content{ width: 95%;}
    }
    @media screen and (min-width: 1800px) {
        .content{ width: 80%;}
    }
    @media screen and (min-width: 2200px) {
        .content{ width: 68%;}
    }
    @media screen and (min-width: 700px) {
      /* .cards_margin { margin-bottom: 0px; margin-top: 0px;}
      .cards_margin1 { margin-bottom: 0px; margin-top: 0px;}
      .cards_margin2 { margin-bottom: 0px; margin-top: 0px;} */

      /* .btrelatorio{ display: none;} */
    }

    @media (max-width:768px){
    .btrelatorio{ display: none;}   
  }
  /*
  i wish this required CSS was better documented :(
  https://github.com/FezVrasta/popper.js/issues/674
  derived from this CSS on this page: https://popper.js.org/tooltip-examples.html
  */

  .popper,
  .tooltip {
    position: absolute;
    color: #777;
    width: auto;
    border-radius: 3px;
    text-align: center;
    opacity: 1;
    font-size: 10px !important;
  }
  .style5 .tooltip {
    background: #fff;
    color: #FFFFFF;
    width: auto;

    padding: .5em 1em;
  }
  .popper .popper__arrow,
  .tooltip .tooltip-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
    margin: 5px;
  }

  .tooltip .tooltip-arrow,
  .popper .popper__arrow {
    border-color: #fff;
  }
  .style5 .tooltip .tooltip-arrow {
    border-color: #1E252B;
  }
  .popper[x-placement^="top"],
  .tooltip[x-placement^="top"] {
    margin-bottom: 5px;
  }
  .popper[x-placement^="top"] .popper__arrow,
  .tooltip[x-placement^="top"] .tooltip-arrow {
    border-width: 5px 5px 0 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    bottom: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .popper[x-placement^="bottom"],
  .tooltip[x-placement^="bottom"] {
    margin-top: 5px;
  }
  .tooltip[x-placement^="bottom"] .tooltip-arrow,
  .popper[x-placement^="bottom"] .popper__arrow {
    border-width: 0 5px 5px 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-top-color: transparent;
    top: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .tooltip[x-placement^="right"],
  .popper[x-placement^="right"] {
    margin-left: 5px;
  }
  .popper[x-placement^="right"] .popper__arrow,
  .tooltip[x-placement^="right"] .tooltip-arrow {
    border-width: 5px 5px 5px 0;
    border-left-color: transparent;
    border-top-color: transparent;
    border-bottom-color: transparent;
    left: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }
  .popper[x-placement^="left"],
  .tooltip[x-placement^="left"] {
    margin-right: 5px;
  }
  .popper[x-placement^="left"] .popper__arrow,
  .tooltip[x-placement^="left"] .tooltip-arrow {
    border-width: 5px 0 5px 5px;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    right: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }
  .avtiti_mod{ font-size: 18px; color:#000; font-weight: 600;}
  .avmen_mod{ font-size: 18px; color:#777; font-weight: 400;}




</style>

<body class="{{ $class }}" style="height: auto; min-height: 100%;">
<div class="modal fade" id="myModal_video" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content" id="retorno_modal_video">
            <div class="modal-header justify-content-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <h5>VÍDEO EXPLICANDO AS NOVIDADES DO NOVO SISTEMA</h5>
            </div>
            <div class="modal-body" style="padding: 0 0 0px 0;">
            <video width="100%" height="auto" controls="controls">
                <source src="{{ asset('paper') }}/video/mudancas.mp4" type="video/mp4">
                <object data="" width="320" height="auto">
                    <embed width="100%" height="auto" src="{{ asset('paper') }}/video/mudancas.mp4">
                </object>
            </video>
               
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_aviso" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content" id="retorno_modal_video">
            <div class="modal-header justify-content-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <h5><i class="far fa-envelope"></i> Mensagem</h5>
            </div>
            <div class="modal-body" >
              <p class="avtiti_mod"></p>
              <p class="avmen_mod"></p>
            </div>
        </div>
    </div>
</div>
        
    
    @auth()
        <div id="blanket"></div>
        <div id="aguarde"></div>
        @include('layouts.page_templates.auth')
        @include('layouts.navbars.fixed-plugin')
    @endauth
    
    @guest
        @include('layouts.page_templates.guest')
    @endguest
    
    <script>
        $(document).ready(function () {
            aos_init();
        });
        function aos_init() {
            AOS.init({
            duration: 150,
            easing: "ease-in-out", 
            once: true
            });
        }
  
       
        
        function anima_editado($id, tipo){ 
           
            if (!Array.isArray($id)) {
                add_animacao($id, tipo, '20');
            }else{
                
                for (let i = 0; i < $id.length; ++i) {
                    time = i+'00';
                    setTimeout(function(){ add_animacao($id[i], tipo, '20');},  time);
                    
                }
            }
        } 
        function add_animacao($id, tipo, time){

            tipocor = '';    
            if(tipo == 'edit'){tipocor = 'anima_edit'}          
            if(tipo == 'add'){tipocor = 'anima_add'}
            let obj = '#tab'+$id;
            $(obj).addClass(tipocor);
            setTimeout(function(){ $(obj).addClass('anima');}, 10);
            setTimeout(function(){ $(obj).removeClass(tipocor);}, time);
        }
        var load = '<div class="preloader-wrapper smal active crazy"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
    </script>
    <!--   Core JS Files   -->
    
    <script src="{{ asset('paper') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <!-- Chart JS -->
    <!-- <script src="{{ asset('paper') }}/js/plugins/chartjs.min.js"></script> -->
    <script src="{{ asset('paper') }}/demo/moment.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/nouislider.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('paper') }}/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>

    <!-- <script src="https://ativos.cinovasan.com.br/fullcalendar/main.js?v=3.0.0"></script> -->

    <script src="{{ asset('md') }}/mdb.min.js"></script>
    <script src="{{ asset('md') }}/tooltip.min.js"></script>
    <script src="{{ asset('fullcalendar') }}/main.js"></script>
    <script src="{{ asset('paper') }}/js/jquery.mask.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/time.js"></script>






    <script src="{{ asset('paper') }}/demo/demo.js"></script>
    <!-- <script src="{{ asset('paper') }}/js/echarts.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts-nightly@5.1.2-dev.20210512/dist/echarts.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts-nightly@5.1.2-dev.20210512/dist/echarts.min.js"></script>
    
    <script src="{{ asset('paper') }}/aos/aos.js"></script>
    <script src="{{ asset('paper') }}/demo/dashboard.js"></script>
    <script src="{{ asset('paper') }}/demo/jquery.sharrre.js"></script>
    <script src="{{ asset('paper') }}/demo/bootstrap-datetimepicker.js"></script>
    <script src="{{ asset('paper') }}/demo/locale.js"></script>
   
    <script src="{{ asset('select') }}/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
    



      <!-- Select JS -->
      <script src="{{ asset('paper') }}/js/index.js"></script>
      <script src="{{ asset('paper') }}/js/selectize.js"></script>

    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/treemap.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script> -->

    
    @stack('scripts')



    @include('layouts.navbars.fixed-plugin-js')
</body>

</html>
