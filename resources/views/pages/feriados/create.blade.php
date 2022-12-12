<style>
    .flex-container {display: flex; align-items:center}
    .divform{ width: 100px;}
    .formhoras{ width: 37px !important; padding: 0 !important; text-align: center; color: #10a031; font-weight: 500;}
    .rowatividade .md-form{  padding: 0px; margin: 5px;  } 
    .rowatividade{ padding: 0 15px; border: solid 1px #c9d7e0; justify-content:center; float: left; border-radius: 5px; margin-bottom: 15px;-webkit-transition: all 0.25s ease-out;transition: all 0.25s ease-out;}
    .rowatividade:hover{ border: solid 1px #fff;  -webkit-box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12); box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.2), 0 4px 10px 0 rgba(0, 0, 0, 0.12);}
</style>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body"> 
                        <h5 style="margin: 0; padding:0; font-weight:300"> Cadastrar Feriados/ Horas </h5>
                        <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    @csrf    
                                    <input type="hidden" id="fn_data_envio" name="fn_data_envio" class="form-control" value="" required> 
                                    <div class="md-form" style="margin-top: 30px;">
                                        <input type="text" id="fn_data" class="form-control datepicker" name="fn_data" value="" required>
                                        <label for="fn_data" class="active">Selecione uma data</label>
                                    </div>                 
                                                            
                                    <div class="md-form" style="margin-top: 30px;">
                                        <input type="text" id="fn_descricao" name="fn_descricao" class="form-control" value="" required>
                                        <label for="fn_descricao" class="active">Descrição</label>
                                    </div>
                                    <div class="md-form" style="margin-top: 30px;">    

                                        <select class="mdb-select colorful-select dropdown-primary md-form" name="feriados_tipos_id" id="feriados_tipos_id" required>
                                            <option value="" disabled selected></option>                                            
                                                @foreach($tipo_feriado as $key => $value)
                                                    <option value="{{$value->id ?? ''}}">{{$value->ftdescricao ?? ''}}</option>
                                                @endforeach                                                     
                                        </select>                                                
                                        <label for="feriados_tipos_id" class="active">Escolha um tipo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="divtotalhoras">
                                <div class="col-md-12">
                                    <div class="flex-container rowatividade" id="atv242245">
                                        <div class="divform">
                                            <div class="md-form">
                                                <i class="far fa-clock active" style="font-size: 10px; margin-left: -10px"></i>
                                                <input type="text" name="horas" value="" id="horas0" data-id="0" data-tipo="hora" max="40" maxlength="2" class="formhoras" placeholder="hh"> : 
                                                <input type="text" name="minutos" value="" id="minutos0" data-id="0" data-tipo="minuto" max="59" step="10" maxlength="2" class="formhoras" placeholder="mm">
                                            </div>
                                        </div>                                                                                      
                                    
                                        <div class="labelatv">
                                            <label for="aldescricao0" class="active">Horas Permitida </label>
                                        </div>
                                    </div>
                                    <div class="" style="margin-left: -10px;">
                                        <div class="switch switchacord2 pequeno">
                                            <label><input type="checkbox" style="width: 20px;" name="todosuser" value="email" class="checklever checkuser" checked>
                                            <span class="lever"></span> Todos os usuários</label> 
                                        </div> 
                                    </div>
                                    <div class="md-form selecionaruser">
                                        <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="usuario[]" id="usuario" multiple>
                                            <option value="" disabled selected></option>                                            
                                            <option value="">Selecione...</option>                                            
                                            @foreach($usuarios as $key => $value)
                                                <option value="{{$value->id ?? ''}}">{{$value->name ?? ''}}</option>      
                                            @endforeach                                                     
                                        </select> 
                                        <label for="usuario" class="active"><i class="fas fa-users" style="color: #444; margin-right: 5px"></i>  Usuários</label>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-12">
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-success btn-sm btn-rounded waves-effect "><i class="fas fa-save"></i> Adicionar</button>                                                                     
                                    </div> 
                                </div>

                            </div>
                        </form>
                    </div>
                    <div style="width: 100%; border-top: solid 1px #eee; margin-bottom: 20px; margin-top:18px "></div>
                    <div class="" style="margin: 10px ;">
                        <div class="card-body">
                            <form name="form_todosferiados" id="form_todosferiados" >
                            @csrf 
                                <h5 style="margin: 0; padding:0; font-weight:300; font-size: 15px"> Adicionar todos os feriados nacionais </h5>
                                <div class="md-form" style="margin-top: 30px;">
                                    <input type="text" id="ferano" name="ferano" class="form-control" value="" required>
                                    <label for="ferano" class="active">Qual ano ?</label>
                                </div>
                                <button type="submit" class="btn btn-outline-success btn-sm btn-rounded waves-effect "><i class="fas fa-save"></i> Feriados Nacionais do ano  <span class="txt-ano">...</span> </button>       
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-calendar ">  
                    <div class="card-body">
                        <div id='fullCalendar'></div>
                    </div>                    
                </div>
            </div>        


        </div>


<script>
    $(document).ready(function () {
        $('.mdb-select').materialSelect();     
        $('.form-control').trigger("change");   
        $('#divtotalhoras').hide();
        $('.selecionaruser').hide();
        // $('.datepicker').pickadate();   

        $(".datepicker").pickadate({
            isRTL: false,
            format: 'dd/mm/yyyy',
            autoclose:true,
            language: 'pt-br'
        });
        $(document).on('change', '#feriados_tipos_id', function() {
            
            if($(this).val() == 9){
                $('#divtotalhoras').show();
            }else{
                $('#divtotalhoras').hide();
            }
        });
        $('#ferano').keyup(function(e) {
            $('.txt-ano').text($(this).val());
        });
        
    });

    $(document).on('change', '.checkuser', function() {
        if($(this).is(":checked")){
            $('.selecionaruser').hide();
        }else{
            $('.selecionaruser').show();
        }
    });

    function calendario_atual(event){ 
        data_atual = formatDate(event.activeRange.end);
        $('#data_voltar_calend').val(data_atual);
    }    
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });

    $("#form_todosferiados").submit(function(e) {           
        e.preventDefault(); 
        form_todosferiados();        
    });

    if( document.readyState !== 'loading' ) {
          myInitCode();
        } else {
        document.addEventListener('DOMContentLoaded', function () {
            myInitCode();
        });
    }

    function myInitCode(){ 
        var data_inicial = new Date();
        if($('#data_voltar_calend').val()){
        data_inicial = $('#data_voltar_calend').val();
        }
        var calendarEl = document.getElementById('fullCalendar');     
        var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
        center: '',
        left: 'title',   
        right: 'prevYear,prev,next,nextYear today'
        },
        buttonText: {
            today: "Hoje"
        },
        navLinks: true, // can click day/week names to navigate views
        businessHours: false, // display business hours
        editable: false,
        selectable: true,
        weekends: true,
        height: "auto",
        initialDate: data_inicial,
        events: [
        <?php
            foreach($dados_lista as $key => $value){
                $class = 'dataferiado';
                echo "{
                        title: '$value->fn_descricao',
                        start: '$value->fn_data 11:30:00',
                          end: '$value->fn_data 11:50:00',
                   classNames: '$class', 
                        },";
            } 
        ?>
        ],

        select: function(info) {
            data = info.startStr;
            let result = data.split('-');
            let resultdata = result[2]+'/'+result[1]+'/'+result[0];
            $('#fn_data_envio').val(data);
            $('#fn_data').val(resultdata);
            $('.form-control').trigger("change");   
        },
        navLinkDayClick: function(date, jsEvent) {        
            let result = date.toISOString().split('T');  
            let result2 = result[0].split('-');
            let resultdata = result2[2]+'/'+result2[1]+'/'+result2[0];
            $('#fn_data_envio').val(result[0]);
            $('#fn_data').val(resultdata);
            $('.form-control').trigger("change");   
        },
        
        
    });
    var eventSource = calendar.getEventSourceById('a');
    calendar.setOption('locale', 'pt-br');
    calendar.render();
  }
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;
        return [year, month, day].join('-');
    }
    function dataAtualFormatada(data){    
        var dia  = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0'+dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0'+mes : mes,
        anoF = data.getFullYear();
        return anoF+"-"+mesF+"-"+diaF;
    }
</script>