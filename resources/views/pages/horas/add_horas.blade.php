<style>
    .labdata{ font-size: 13px; font-weight: bold; color: #777; margin-right: 10px;}
    .labdata1{ font-size: 14px; font-weight: bold; color: #000;}
    .fixo {z-index: 199; position: fixed !important; top: 20px; margin-top: 100px !important;}
    .btssalvar{ position:  absolute; top: 100px; right: 50px; text-align: center; }
    .percent{ position: absolute; top: -38px; left: 27px; font-weight: bold; display:inline-block}
    .ajustepercent{ left: 25px !important; }
    .divchart canvas{ width: 80px;}
    .totalhoras1{ font-weight: bold; color: #000;}
    .totalhoras{ color: #777; font-weight: 400;}
    .saldohoras1{ font-weight: bold; color: #000;}
    .saldohoras{  color: #777; font-weight: 400;}
    .rowatividade .md-form{  padding: 0px; margin: 5px;  } 
    .rowatividade{ padding: 0 10px; border: solid 1px #c9d7e0; justify-content:center; float: left; margin-right: 20px; border-radius: 5px; margin-bottom: 15px;-webkit-transition: all 0.25s ease-out;transition: all 0.25s ease-out;}
    .rowatividade:hover{ border: solid 1px #fff;  -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12);}

    /* .rowatividade{ padding: 0 10px; border: solid 1px #c9d7e0; float: left; margin-right: 20px; border-radius: 5px; margin-bottom: 15px;-webkit-transition: all 0.25s ease-out;transition: all 0.25s ease-out;}
    .rowatividade:hover{ -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12);
     border: solid 1px #fff; -webkit-transition: all 0.25s ease-out;transition: all 0.25s ease-out;}
     .rowatividade{ padding: 0;}
     
    /*.rowatividade .md-form input{ width: 110% !important} */ 
    /* .rowatividade .md-form ::after{ width: 100% !important;} */
    /* .nomeative{ font-size: 13px; color: #444; margin-left: 10px;} */
    .inputhoras{ text-align: center;}
    .addselecao{ background-color: #edf9fb; font-weight: bold !important;  }
    .card-header a{ color: #3c4a5f  !important; font-weight: bold !important;}
    .horasano{ text-align: right !important;}
    .col-sm-12{ position: relative;width: 100%;min-height: 1px;padding-right: 15px !important;padding-left: 15px !important; }
     .labelatv{  margin-left: 10px; padding-top: 5px; } 

    .flex-container {display: flex; align-items:center}
    .divform{ width: 100px;}
    .formhoras{ width: 37px !important; padding: 0 !important; text-align: center; color: #10a031; font-weight: 500;}
    
    @media only screen and (max-width: 750px) {
        .btssalvar{ position: fixed; top: 100px; right: 10px; }
        .percent{ position: absolute; top: -55px; left: 42px; font-weight: bold; display:inline-block}
    }
    @media only screen and (max-width: 600px) {

        .rowatividade .md-form{ width: 100px !important;} 
        .divform{ width: 100px; float: left;}
        .labelatv{text-align: center; margin-top: 5px;}
        .horasano{ text-align: left;}
        .percent{ position: absolute; top: -50px; left: 45px; font-weight: bold; display:inline-block}
        .rowatividade{ float: none;}
        .flex-container { display: table; width: 100%;}
        /* .rowatividade .md-form input{ width: 60% !important} 
        .rowatividade { text-align: center !important; border-top: solid 1px #eee;}
        .rowatividade .md-form { left: 50%; transform: translate(-29%); } */
        .btssalvar{ position: fixed; top: 100px; right: -7px; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 10px;
        -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12);}
       
    }
</style>

<div class="row" style="position: relative;" id="card_add_horas">
<input type="hidden" value="{{auth()->user()->id}}" name="userfuncao" id="userfuncao" />

    
    <div class="col-sm-10">
        <div class="card" {{$add_anima}}>    
            <div class="card-header">
                <h5><i class="far fa-clock"  style="color: #ccc;"></i> Cadastrar atividade</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"><span class="labdata">INÍCIO:</span><i class="far fa-calendar-check" style="color: #777"></i> <span class="labdata1">{{$data_inicio}}</span></div>
                    <div class="col-md-4"><span class="labdata">FIM:</span><i class="far fa-calendar-check"  style="color: #777"></i> <span class="labdata1">{{$data_fim}}</span></div>
               
                </div>
                <div class="row">

                <?php 
                    // dd($contrato_users);
                ?>
               
                    <form name="form_horas" id="form_horas" class="col-md-12"> 
                    @csrf  
                        <!-- data para cadastro -->
                        <input type="hidden" value="{{$data_inicio_s}}" id="data_inicio_s" name="data_inicio">
                        <input type="hidden" value="{{$data_fim_s}}" id="data_fim_s" name="data_fim">    
                        
                        <!-- data para recarregar pagina -->
                        <input type="hidden" value="{{$data_inicio_rec}}" id="data_inicio_rec" >
                        <input type="hidden" value="{{$data_fim_rec}}" id="data_fim_rec">   

                        <input type="hidden" value="" name="horas_cadastradas" id="horas_cadastradas">
                        
                  
                        <div id="accordion-2" role="tablist" aria-multiselectable="true" class="card-collapse"> 
                            @if(!count($contrato_users) == 0)     
                            <div class="row">
                                <div class="col-md-8">   
                                    <h4 class="card-title" style="font-size: 16px; font-weight: 400;">Distribua as horas nos contratos</h4>     
                                </div>
                                <div class="col-md-4">                                                
                                    <div class="md-form">
                                        <input type="text" id="buscactnome" name="ctnome" class="form-control" value="" required="">
                                        <label for="ctnome" class=""> <i class="fas fa-search"></i> Contratos</label>
                                    </div>
                                </div>
                            </div>
                            @endif                
                            @if(count($contrato_users) == 0)
                            <h4 class="card-title" style="font-size: 16px; font-weight: 400; color:#f93e3e">Você não tem contratos adicionados</h4>
                                <a href="/meuscontratos" class="btn btn-outline-info btn-sm btn-rounded"><i class="fas fa-briefcase"></i> Clique aqui para adicionar contratos</a>
                            @endif
                            
              
                            <?php
                                $contratos_name = '';                         
                                $contador = 0;
                            ?>
                            @foreach($contrato_users as $key => $value)
                            <?php                        
                                $departamento_name = '';
                            ?>
                                @if($value->ctnome !== $contratos_name)
                                    <?php $contratos_name = $value->ctnome; ?>
                                    <div class="card card-plain cardcontratosid" data-ctnumero ="{{$value->ctnumero}}" data-ctnome= "{{$value->ctnome}}" data-contratos_id ="{{$value->contratos_id}}" data-nome="{{$value->ctnome}}">
                                        <div class="card-header" role="tab" id="heading{{$value->contratos_id}}">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$value->contratos_id}}" aria-expanded="false" aria-controls="collapseOne">
                                        {{$value->ctnumero}} - {{$value->ctnome}} 
                                            <i class="nc-icon nc-minimal-down"></i>
                                        </a>
                                        </div>
                                        <div id="collapse{{$value->contratos_id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$value->contratos_id}}">
                                            <div class="card-body" style="padding: 5px;">
                                                <div id="accordion-3" role="tablist" aria-multiselectable="true" style="margin-top: 0px;" class="card-collapse">
                                                    <!-- <h4 class="card-title" style="font-size: 16px;">Selecione o produto</h4> -->
                                                    @foreach($contrato_users as $key => $value2)  
                                                        @if($value2->ctnome == $contratos_name)     
                                                            @if($value2->depnome !== $departamento_name)   
                                                                 
                                                                <?php 
                                                                    $departamento_name = $value2->depnome; 
                                                                    $prodon = true;                                                                   
                                                                ?> 
                                                                @if($prodon)                                        
                                                                    <div class="card card-plain">
                                                                        <div class="card-header" role="tab" id="heading-{{$contador}}">
                                                                        <span style="float: left; margin-right: 20px"> 
                                                                            {{-- <a href="" title="Adicionar ou Remover as Atividades" data-toggle="modal" data-target="#myModal_editatv" onclick="editar_atv('{{ $value->departamentos_id }}', '{{$value->contratos_id}}')" class="btn btn-outline-primary btn-sm btn-rounded waves-effect" style="margin: 0">
                                                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                                                            </a>  --}}
                                                                        </span>
                                                                        
                                                                        <a data-toggle="collapse" data-parent="#accordion-3" href="#collapse-{{$contador}}" aria-expanded="false" aria-controls="collapse-{{$contador}}">
                                                                            {{$value2->depnome}}
                                                                            <i class="nc-icon nc-minimal-down"></i>
                                                                        </a>
                                                                        </div>
                                                                        <div id="collapse-{{$contador}}" class="collapse" role="tabpanel" aria-labelledby="heading-{{$contador}}">
                                                                            <div class="card-body" id="prod{{$value2->departamentos_id}}{{$value2->contratos_id}}" style="padding: 5px;">
                                                                                @foreach($contrato_users as $key => $value3)  
                                                                                    @if($value3->ctnome == $value2->ctnome)     
                                                                                        @if($value3->depnome == $value2->depnome)
                                                                                        <div class="flex-container rowatividade" id="atv{{$value3->contratos_id}}{{$value3->departamentos_id}}{{$value3->atividades_id}}">
                                                                                            <div class="divform" >
                                                                                                <div class="md-form">
                                                                                                    <input type="hidden" id="aldescricao{{$contador}}" class="inputhoras" name="horas[{{$value3->contratos_id}}, {{$value3->departamentos_id}}, {{$value3->atividades_id}}, {{$contador}}]" value="00:00" >                                                                                                
                                                                                                    <i class="far fa-clock" style="font-size: 10px; margin-left: -10px"></i>
                                                                                                    <input type="text" value="" id="horas{{$contador}}" data-id="{{$contador}}" data-tipo='hora' max="40" maxlength="2" class="formhoras" placeholder="hh"> : 
                                                                                                    <input type="text" value=""  id="minutos{{$contador}}" data-id="{{$contador}}" data-tipo ='minuto' max="59" step="10"  maxlength="2" class="formhoras" placeholder="mm">
                                                                                                </div>
                                                                                            </div>                                                                                      
                                                                                        
                                                                                            <div class="labelatv">
                                                                                                <label for="aldescricao{{$contador}}" class="active">{{$value3->atdescricao}} </label>
                                                                                            </div>
                                                                                        </div>                                                                                
                                                                                            <?php $contador = $contador+1; ?>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif                                                        
                                                    @endforeach  
                                                </div>                                         
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>

     <?php
                // echo '<pre>';
                // var_dump($contrato_users);
                // echo '</pre>';
                ?>

        <div class="btssalvar anima_geral" >
            <input type="hidden" value="{{$total_dias}}" id="total_dias">
            <input type="hidden" value="{{$total_horas}}" id="total_horas">
            <input type="hidden" value="{{$data_voltar}}" id="data_voltar">

            <!-- <input type="hidden" value="{{$totalats}}" id="horas_atestado"> -->



            <div><div><div><input type="hidden" class="inputhoras"  value="{{$totalats}}" style="background-color: none !important;" ></div></div></div>



            <input type="hidden" value="{{$totalcad ?? '00:00'}}" id="horas_banco" name="horas_banco">
            <div class="divchart">
                <span style="position: relative;" class="min-chart my-4" id="chart-sales" data-percent="0"><span class="percent"></span></span>
            </div>
            <span class="totalhoras">Restante</span> <b><span class="totalhoras1">{{$total_horas}}</span><br></b>
            <span class="saldohoras">Total</span> <b><span class="saldohoras1">0</span></b><br>                  
            <span class="saldohoras">{{$total_dias}} dias</span></b><br>                  
            <button type="button" id="btaddhotas" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-save"></i> Adicionar</button>    <br>  
            <a type="button" id="voltar_mapa" class="btn-floating btn-tw waves-effect waves-light btn-sm" style="width: 30px; height: 30px"><i class="fas fa-angle-left" style="margin-top: -2px;"></i></a>
        </div>



</div>

<script>
    var arrayhoras = [];
    var total_horas = $('#total_horas').val();
    var data_voltar = $('#data_voltar').val();
    var horas_banco = calcular($('#horas_banco').val(), '00:00','+')
    var restante = total_horas;
    // var allcontratos = <?php echo json_encode($contrato_users) ?>;
    
    

    $(document).ready(function () { 
       /// $('.form-control').trigger("change");    
       verificarhoras();  
       criarcontartos();
    //    buscarinit(allcontratos);
    });
    
    $(document).on('keyup', '.formhoras', function() {
        id = $(this).data('id');    
        input = '#aldescricao'+id;
        tempo = $(this).val();     
        if(tempo == '00'){ tempo = ''}
        if(tempo == '0'){ tempo = ''}


        $(this).val(tempo);

        var result = $(input).val().split(':');

        if(result[0] == undefined){result[0] = '00' }
        if(result[0] == 'NaN'){result[0] = '00' }
        if(result[1] == 'NaN'){result[1] = '00' }
        if(result[1] == undefined){result[1] = '00' }

        console.log(result);


        if($(this).data('tipo') == 'hora'){
            hora = parseInt($(this).val());     
            if(hora >= 40) { hora = 40 ; $(this).val('40')} 
            $(input).val( hora +':'+result[1]+':00')
        }
        if($(this).data('tipo') == 'minuto'){
            minuto = parseInt($(this).val());   
            if(minuto >= 59) { minuto = 59 ; $(this).val('59')}

            $(input).val( result[0] +':'+minuto+':00')
        }

        console.log('ok',result);
        
        verificarhoras();
    });

    $('.ps-container').scroll(function () {
        if ($(this).scrollTop() > 100) {
            $(".btssalvar").addClass("fixo");
        } else {
            $(".btssalvar").removeClass("fixo");
        }
    });
    
    $( "#voltar_mapa" ).on( "click", function(e) {
        e.preventDefault();
        voltar_calendario();       
    });

    $( "#btaddhotas" ).on( "click", function(e) {
        e.preventDefault();
        form_horas();       
    });   

    $(document).on('keyup', '.inputhoras', function() {
        verificarhoras();
    });
    $(document).on('change', '.inputhoras', function() {
        verificarhoras();
    });

    $(document).on('keyup', '#buscactnome', function() {
        filtrarbusca();
    });
    



</script>


