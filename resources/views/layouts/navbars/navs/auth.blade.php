
<style>
.navbar-brand{font-size: 15px; font-weight: 500; color: #626a6e !important; }.minimizeSidebar{cursor: pointer;}
.avatarp {height: 40px;width: 40px !important; background-color: #bbb; border-radius: 50%; box-sizing:unset; object-fit: cover; margin-top: -5px; box-shadow: 0 4px 8px 0 rgb(34 41 47 / 12%), 0 2px 4px 0 rgb(34 41 47 / 8%);}
.imgatestado { cursor: pointer; height: 40px;width: 40px !important; background-color: #bbb; box-sizing:unset; object-fit: cover; margin-top: -5px; box-shadow: 0 4px 8px 0 rgb(34 41 47 / 12%), 0 2px 4px 0 rgb(34 41 47 / 8%);}
.gloww {
  font-size: 80px;
  color: #f8e54d;
  text-align: center;
  -webkit-animation: glow 1s ease-in-out infinite alternate;
  -moz-animation: glow 1s ease-in-out infinite alternate;
  animation: glow 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 6px #fff, 0 0 6px #fff, 0 0 15px #fff38e, 0 0 20px #fff38e, 0 0 25px #fff38e, 0 0 30px #fff38e, 0 0 40px #fff38e;
    color: #ffba00;
  }
  to {
    text-shadow: 0 0 12px #fff, 0 0 3px #fff, 0 0 7px #fff9cb, 0 0 10px #fff9cb, 0 0 12px #fff9cb, 0 0 15px #fff9cb, 0 0 20px #fff9cb;
    color: #ffa200;
  }
}


</style>
<div class="navbar navbar-expand-lg fixed-top bgtop navbar-transparent margtm" style="height: 64px;">
    <div class="container-fluid bgtop" >
        <div class="navbar-wrapper">
            <div class="navbar-minimize">
                    <span id="minimizeSidebar" >
                        <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
                        <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
                    </span>
                </div>
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
        </div>

        <div style=" padding-top: 5px" >

        <style>
            .sino{ margin-top: 5px}
            .nav-item{ float: left; }
            .dropdown .dropdown-toggle::after {display: none}
            .cimaicon{ display: none; box-shadow: none !important; position: absolute; left: 27px; top:-3px; z-index: 99; padding: 2px 4px;; border: none; box-shadow: 0 4px 8px 0 rgb(34 41 47 / 12%), 0 2px 4px 0 rgb(34 41 47 / 8%);}
            .item-aviso { width: 400px !important; border-bottom: solid 1px #eee; white-space:normal !important; padding: 20px !important;}
         
            .item-aviso:hover { background-color: #f8fafc !important; border: #fff;}
            .item-aviso p {width: 350px !important; }
            .avisos_drop p.avtiti{ font-size: 13px !important;color: #000; font-weight: 600 !important;}
            .avisos_drop .avmen{ font-size: 13px !important; color: #777; font-weight: 300 !important; line-height: 15px !important;}
            .dropnotf{ overflow: auto; max-height: 500px; margin:0!important; padding:0!important}

            @media(max-width: 500px){
                #bttutorial{
                    display: none;
                }
            }
         
        </style>
        
        
        <ul style=" list-style-type: none; float: right; padding:0; margin:0; margin-left: 10px; ">
            <li class="nav-item btn-rotate dropdown sino" style="margin:0; padding:0">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="badge badge-pill badge-danger cimaicon"></span>
                    <i class="nc-icon nc-bell-55" style="font-size: 20px; color: #38465a"></i>
                </a>
                
                <div class="dropdown-menu dropdown-menu-right dropnotf ps-active-y" aria-labelledby="navbarDropdownMenuLink" >
                    <p style="margin: 20px;">Notificaçõess <span class="badge badge-pill badge-info quantmem"></span></p>
                    <div class="avisos_drop" style="width: 100%;">
                    
                    </div>                    
                </div>
            </li>
            <li class="nav-item dropdown navcelint">
                <i class="fas fa-medal" id="trofeu" rel="tooltip"  data-original-title="" style="font-size: 20px; margin-top:8px; color: #ccc; margin-left: 10px; margin-right: 18px"></i>
            </li>
            
            <li class="nav-item dropdown navcelint">
                <a data-toggle="dropdown" style="cursor: pointer;" >
                    <div style=" height: 40px; margin-top: 5px; font-weight: 700; ">
                        <div style="float:right; margin-left: 10px;"> 
                            <img class="avatarp" src="/storage/{{ auth()->user()->foto }}" style="width: 30px;">
                        </div>
                        <div style="float:right;">
                            <div style="color: #555;">{{ __(auth()->user()->name)}}</div>
                            <div style="font-size: 12px; color: #777; margin-top: -5px; font-weight: 400;">Usuário</div>
                        </div>                        
                    </div>
                    <!-- <img class="avatar border-gray" src="{{ asset('paper') }}/img/timesheet.png" style="width: 30px;">  -->
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">                        
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="nc-icon nc-planet"></i> {{ __('Meu Perfil') }}</a>
                    <a class="dropdown-item" href="/logout"><i class="nc-icon nc-button-power"></i> {{ __('Sair') }}</a>
                </div>
            </li>

            
        </ul>
        <button type="button" data-toggle="modal" data-target="#myModal_video" id="bttutorial" class="btn btn-outline-success btn-sm btn-rounded waves-effect " style="background: #FFF;  float:right">
        <i class="fas fa-video" style="margin-right: 10px;"></i>Tutorial</button>
        
        </div>
    </div>
</div>

<script>


// define a function...


// ...repeat it once every second
window.setInterval(add_cimaicon, 10000);
window.setInterval(add_mensagens, 10000);

    $.get('/horas/horasOk', function(retorno){
        console.log(retorno);
        if(retorno == 1){
            $('#trofeu').addClass('gloww');
            $('#trofeu').attr('data-original-title', 'Parabéns, você preencheu as horas no mês passado');
        }else{
            $('#trofeu').attr('data-original-title', 'Você não preencheu as horas no mês passado');
        }
            
    });


    $(document).ready(function () { 
        add_cimaicon();
        add_mensagens();       
        $('.dropnotf').perfectScrollbar();
    });
    function add_cimaicon(){
        $.get('/avisos/aviso_qnt', function(retorno){
                $('.quantmem').html(retorno);       
        });
        $.get('/avisos/aviso_qnt_novo', function(retorno){
            if(retorno > 0){
                $('.cimaicon').css('display','block');
                $('.cimaicon').show();
                $('.cimaicon').html(retorno);
            }            
        });
    }
    function add_mensagens(){
        $.get('/avisos/aviso_user', function(retorno){
            $('.avisos_drop').html(retorno);
        });
    }
    $(".sino").click(function(e) {           
        e.preventDefault(); 
        $('.cimaicon').hide();
        $('.cimaicon').html('');
        $.get('/avisos/aviso_visto', function(retorno){
            $('.cimaicon').hide();
            $('.cimaicon').html('');
        });                
    });
</script>