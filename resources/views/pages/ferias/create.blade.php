

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"> 
                        <h5 style="margin: 0; padding:0; font-weight:300"> <i class="far fa-calendar-alt" style="color: #ccc;"></i> Cadastrar Férias / Ausência </h5>
                        <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                            <input type="hidden" id="id_geral" name="id_geral" class="form-control" value="" required>
                            @csrf                       
                            <div class="row"> 
                                <div class="col-md-4" >
                                    <div class="md-form">
                                        <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="usuario" id="usuario" >
                                            <option value="" disabled selected></option>                                            
                                            <option value="">Selecione...</option>                                            
                                            @foreach($usuarios as $key => $value)                              
                                                <option value="{{$value->id ?? ''}}">{{$value->name ?? ''}}</option> 
                                            @endforeach                                                     
                                        </select> 
                                        <label for="usuario" class="active"><i class="fas fa-users" style="color: #444; margin-right: 5px"></i>  Usuários</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="text" id="datainicio" class="form-control datepicker" name="datainicio" value="" >
                                        <label for="datainicio" class="active"><i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data Início</label>
                                    </div>  
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <input type="text" id="datafim" class="form-control datepicker" name="datafim" value="" >
                                        <label for="datafim" class="active"> <i class="far fa-calendar" style="color: #444; margin-right: 5px"></i> Data Fim</label>
                                    </div>   
                                </div> 
                                
                            </div>
                            <div class="footerint">
                                <button type="submit" class="btn btn-outline-success btn-sm btn-rounded waves-effect "><i class="fas fa-save"></i> Adicionar</button>                                                                     
                            </div>                                  
                        </form>
                    </div>       
                </div>
            </div>
        </div>


<script>
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
    });

    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });
</script>