@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile',
    'elementActive2' => ''
])


@section('content')
<style>
    .navprofile a{ font-size:  0.8em; font-weight: 500; color: #777}
    .navprofile a:hover{ background-color: #bfcfe5;color: #435164;  }
    .navprofile a.active{ background-color: #435164 !important; }
    #output {height: 70px;width: 70px;background-color: #bbb;border-radius: 20%;box-sizing:unset;object-fit: cover; box-shadow: 0 4px 8px 0 rgb(34 41 47 / 12%), 0 2px 4px 0 rgb(34 41 47 / 8%);}
    #output2 {height: 70px;width: 70px;background-color: #bbb;border-radius: 20%;box-sizing:unset;object-fit: cover; box-shadow: 0 4px 8px 0 rgb(34 41 47 / 12%), 0 2px 4px 0 rgb(34 41 47 / 8%);}

</style>

<div class="modal fade" id="myModal_foto" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <h5>Atestado Médico</h5>
            </div>
            <div aling="center" class="modal-body divverfoto" style="padding: 0 0 20px 0; text-align: center">
            
            </div>
        </div>
    </div>
</div>



    <div class="content" style="margin: 0; padding:0; margin-top: 80px; padding: 10px" >
        <div class="row">
            <div class="col-md-3" style="margin-bottom: 40px;">
                <div class="nav flex-column nav-pills navprofile" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active waves-effect" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-perfil" aria-selected="true"><i class="fas fa-user-alt" style="margin-right: 10PX;"></i> EDITAR PERFIL</a>
                    <a class="nav-link waves-effect" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fas fa-unlock-alt" style="margin-right: 10PX;"></i> MUDAR A SENHA</a>
                    <a class="nav-link waves-effect" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="far fa-calendar-alt" style="margin-right: 10PX;"></i> SOLICITAR @if(auth()->user()->contrato == 'PJ') AUSÊNCIA @else FÉRIAS @endif</a>                    
                    <a class="nav-link waves-effect" id="v-pills-atestado-tab" data-toggle="pill" href="#v-pills-atestado" role="tab" aria-controls="v-pills-atestado" aria-selected="false"><i class="fas fa-notes-medical" style="margin-right: 10PX;"></i> ATESTADO MÉDICO</a>                    
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="card">
                            <div class="card-header">
                                <h5> <i class="fas fa-user-alt" style="margin-right: 10PX; color: #ccc"></i> {{ __('Editar Perfil') }}</h5>
                            </div>
                            <div class="card-body">
                                <form name="form_anexo" id="form_anexo" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row" style="margin-left: 10px;">   
                                        <div style="float: left;">
                                            <img id='output'src="/storage/{{ auth()->user()->foto }}">
                                    
                                        </div>    
                                        <div style="float: left; margin-left: 10px">
                                            <label for="arquivo" class="btn btn-outline-primary btn-sm btn-rounded waves-effect">Buscar Foto</label>
                                            <input type="file" id="arquivo" name="arquivo" hidden><br>
                                            <p style="color: #777; margin-left: 10px; font-size: 12px;">JPG, GIF ou PNG, máximo de 800kB</p>
                                        </div>                                    
                                        <!-- <div class="col-md-4" >
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Salvar Anexo</button>
                                        </div>                                         -->
                                    </div>                                     
                                </form>
                            </div>
                            <form  action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">                           
                                            <div class="md-form">
                                                <input type="text" id="name" name="name" class="form-control" placeholder="Nome" value="{{ auth()->user()->name }}" required>
                                                <label for="name" class="active">{{ __('Nome') }}</label>
                                                @if ($errors->has('name'))
                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        </div>                                            
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12"> 
                                            <div class="md-form">
                                                <input type="text" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}" disabled  required>
                                                <input type="hidden" name="email" value="{{ auth()->user()->email }}" required>
                                                <label for="name" class="active">{{ __('Email') }}</label>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-outline-primary btn-sm btn-rounded waves-effect">{{ __('Salvar Alterações') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <form  action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-header">
                                    <h5> <i class="fas fa-unlock-alt" style="margin-right: 10PX; color: #ccc"></i> {{ __('Mudar a Senha') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12"> 
                                            <div class="md-form">
                                                <input type="text" id="old_password" name="old_password" class="form-control" placeholder="Senha Antiga"  required>
                                                <label for="old_password" class="active">{{ __('Senha Antiga') }}</label>
                                                @if ($errors->has('old_password'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('old_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="md-form">
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Senha"  required>
                                                <label for="password" class="active">{{ __('Nova Senha') }}</label>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                        
                                        <div class="col-md-6"> 
                                            <div class="md-form">
                                                <input type="password" id="password_confirmation" name="password_confirmation"  class="form-control" placeholder="Confirmar Senha"  required>
                                                <label for="password_confirmation" class="active">{{ __('Nova Senha') }}</label>
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="card-footer ">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-outline-primary btn-sm btn-rounded waves-effect">{{ __('Salvar Alterações') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <form name="form_ferias" id="form_ferias" class="col-md-12" style="width: 100%; margin: 0; padding:0;">                    
                            @csrf 
                            <div class="card">
                                <div class="card-header">
                                    <h5> <i class="far fa-calendar-alt" style="margin-right: 10PX; color: #ccc"></i> Solicitar @if(auth()->user()->contrato == 'PJ') Ausência @else Férias @endif</h5>
                                </div>
                                <div class="card-body">
                                    
                                        <div class="row"> 
                                            <div class="col-md-6">
                                                <div class="md-form">
                                                    <input type="text" id="datainicio" class="form-control datepicker" name="datainicio" value="" >
                                                    <label for="datainicio" class="active"><i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data Início</label>
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="md-form">
                                                    <input type="text" id="datafim" class="form-control datepicker" name="datafim" value="" >
                                                    <label for="datafim" class="active"> <i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data Fim</label>
                                                </div>  
                                            </div> 
                                            
                                        </div>
                                
                                </div>
                                <div class="card-footer ">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-outline-primary btn-sm btn-rounded waves-effect">{{ __('Solicitar') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12" id="card_lista"></div> 
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-atestado" role="tabpanel" aria-labelledby="v-pills-atestado-tab">
                        <form name="form_atestado" id="form_atestado" class="col-md-12" style="width: 100%; margin: 0; padding:0;" enctype="multipart/form-data">                    
                            @csrf 
                            <input type="hidden" id="tipo" name="tipo" class="form-control" value="">

                            <div class="card">
                                <div class="card-header">
                                    <h5> <i class="fas fa-notes-medical" style="margin-right: 10PX; color: #ccc"></i> Enviar Atestado Médico</h5>
                                </div>

                                    <div class="row" style="margin-left: 10px;">   
                                        <div style="float: left;">
                                            <img id='output2' src="">                                            
                                        </div>    
                                        <div style="float: left; margin-left: 10px">
                                            <label for="arquivo2" class="btn btn-outline-primary btn-sm btn-rounded waves-effect">Adicionar Atestado</label>
                                            <input type="file" id="arquivo2" name="arquivo2" hidden><br>
                                            <p style="color: #777; margin-left: 10px; font-size: 12px;">JPG, GIF ou PNG, máximo de 800kB</p>
                                        </div>                                    
                                    </div>

                                <div class="card-body escolha" style="text-align: center;">
                                    <h6 style="font-weight: 500; color: #777">Escolha o tipo de periodo ausente</h6>

                                    <div class="row" style="margin: 20px 0;">

                                        <div class="col-3"></div>
                                        <div class="col-6 align-self-center">
                                            <button type="button" style="font-size: 16px;"  onclick="btdias()" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"> <i class="far fa-calendar" style=" margin-right: 5px"></i> Dias</button>
                                            <button type="button" style="font-size: 16px;"  onclick="bthoras()" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"> <i class="far fa-clock" style=" margin-right: 5px"></i> Horas</button>
                                        </div>
                                        <div class="col-3"></div>                

                                    </div>
                                </div>

                                <div class="comdatas">
                                    <div class="card-body">
                                        <div class="row tipodias"> 
                                            <div class="col-md-6">
                                                <div class="md-form">
                                                    <input type="text" id="datainicio_at" class="form-control datepicker" name="datainicio_at" value="" >
                                                    <label for="datainicio_at" class="active"><i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data Início</label>
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="md-form">
                                                    <input type="text" id="datafim_at" class="form-control datepicker" name="datafim_at" value="" >
                                                    <label for="datafim_at" class="active"> <i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data Fim</label>
                                                </div>  
                                            </div>                                             
                                        </div> 

                                        <div class="row tipohoras"> 
                                            <div class="col-md-6">
                                                <div class="md-form">
                                                    <input type="text" id="datahora" class="form-control datepicker" name="datahora">
                                                    <label for="datahora" class="active"><i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data</label>
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="md-form">
                                                    <input type="text" id="horas_at" name="horas_at" class="form-control timepicker">
                                                    <!-- <label for="input_starttime">Light version, 12hours</label> -->
                                                    <label for="horas_at" class="active"><i class="far fa-clock" style="color: #444; margin-right: 5px"></i> Selecione as horas</label>
                                                </div> 
                                            </div>                                             
                                        </div> 
                                

                                    </div>
                                    <div class="card-footer ">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"> <i class="fas fa-save"></i> Enviar Atestado</button>
                                                <button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect"  onclick="btvoltar()"><i class="fas fa-broom"></i> Voltar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12" id="card_lista_atestado"></div> 
                        </div>
                    </div>
                </div>
            </div>
        </div> 






    </div>
@endsection
@push('scripts')
@extends('profile.script_page')  

<script>
    $('.comdatas').hide();
    $('#output2').hide();
    $('.tipodias').hide();
    $('.tipohoras').hide();
    setTimeout(function(){ $( ".nav-item" ).removeClass( "waves-effect" )}, 1000);
    $(document).ready(function () {
        $('.mdb-select').materialSelect();     
        $('.form-control').trigger("change");
        $('.dropdown-content, .select-dropdown').perfectScrollbar();    
        $(".datepicker").pickadate({
            isRTL: false,
            format: 'dd/mm/yyyy',
            autoclose:true,
            language: 'pt-br'
        }); 
        add_cards('lista');   
        add_cards('lista_atestado');   
    });
    $("#form_ferias").submit(function(e) {           
        e.preventDefault(); 
        form_ferias();        
    });
    $("#form_atestado").submit(function(e) {           
        e.preventDefault(); 
        form_atestado();        
    });

    $("#arquivo").change(function(e) {
        var input = e.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('output');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);

   


        form_anexo(); 
    })
    $("#arquivo2").change(function(e) {
        var input = e.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('output2');

            retorno = dataURL.split(";");
            retornof = retorno[0].split("/");
            if(retornof[1] == 'pdf'){
                dataURL = '/storage/pdfico.png';
            }   

            output.src = dataURL;
            
        };
         reader.readAsDataURL(input.files[0]); 
        $('#output2').show();
        
    })
</script>

@endpush