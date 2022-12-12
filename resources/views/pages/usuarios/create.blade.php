<div class="card"{{$add_anima ?? ''}} style="z-index: 9;" >
    <div class="card-body">
        <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
            <div class="card card-plain card_dif">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                        <h5 style="margin: 0; padding:0; font-weight:300"> <i class="fas fa-plus" style="float: left; font-size: 15px; margin-top: 2px; opacity:.5"></i> Cadastrar Usuário <i class="nc-icon nc-minimal-down"></i></h5>
                        
                    </a>
                </div>
                <div id="collapseOne" class="collapse" role="tabpanel"  aria-labelledby="headingOne" >
                    <div class="card-body">
                        <div class="row">
                            <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                                <input type="hidden" id="id_geral" name="id_geral" class="form-control" value="" required>
                                @csrf                       
                                <div class="row">                                            
                                    <div class="col-md-12">                                                
                                        <div class="md-form">
                                            <input type="text" id="name" name="name" class="form-control" value="" required>
                                            <label for="name" class="active">Nome</label>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-3" style="display:none">
                                        <div class="md-form">                                                
                                            <div class="switch switchacord2 pequeno" style="margin-left: 0; padding-left:0; margin-top: 10px">
                                                <label><input type="checkbox" style="width: 20px;" name="horas" value="1" class="checklever">
                                                <span class="lever" style="margin-left: 0; padding-left:0"></span> ilimitado</label> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="md-form">                                                
                                            <select class="mdb-select colorful-select dropdown-primary md-form perfect-scrollbar" name="departamentos_id" id="departamentos_id" required >
                                                <option value="" disabled selected></option>                                            
                                                    @foreach($departamento as $key => $value)
                                                        <option value="{{$value->id ?? ''}}">{{$value->depnome ?? ''}}</option>
                                                    @endforeach                                                          
                                            </select>                                                
                                            <label for="departamentos_id" class="active">Departamento</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <div class="md-form">                                                
                                            <select class="mdb-select colorful-select dropdown-primary md-form perfect-scrollbar" name="funcaos_id" id="funcaos_id" required >
                                                <option value="" disabled selected></option>                                            
                                                    @foreach($funcao as $key => $value)
                                                        <option value="{{$value->id ?? ''}}">{{$value->fndescricao ?? ''}}</option>
                                                    @endforeach                                                          
                                            </select>                                                
                                            <label for="funcaos_id" class="active">Função</label>
                                        </div>
                                    </div>

                                   

                                    
                                    <div class="col-md-2">                                                
                                        <div class="md-form">
                                            <input type="text" id="tarifa" name="tarifa" class="form-control" value="" required>
                                            <label for="tarifa" class="active">Tarifa</label>
                                        </div>
                                    </div>  
                                
                                    <div class="col-md-3">
                                        <div class="md-form">
                                            <input type="email" name="email" id="email" class="form-control"  value="" required>
                                            <label for="email" class="active">Login</label>
                                        </div>
                                    </div>                         
                                    <div class="col-md-2">
                                        <div class="md-form">
                                            <input type="text" name="password" id="password" class="form-control"  value="">
                                            <label for="password" class="active">Senha</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="text-align: right; margin-top: 30px">
                                        <div class="form-check-inline">
                                            <input     class="form-check-input"    type="radio"    name="perfil"    id="perfil1" value="0"  checked />
                                            <label class="form-check-label" for="perfil1"> Normal </label>
                                        </div>

                                        <div class="form-check-inline">  
                                            <input    class="form-check-input"    type="radio"    name="perfil"    id="perfil2"   value="1"    />
                                            <label class="form-check-label" for="perfil2"> Administrativo </label>
                                        </div>
                                        @if( Auth::user()->perfil  == '2')
                                            <div class="form-check-inline">  
                                                <input    class="form-check-input"    type="radio"    name="perfil"    id="perfil3"  value="2"     />
                                                <label class="form-check-label" for="perfil3"> Master </label>
                                            </div>
                                        @endif  
                                    </div>
                          
                                </div>
                                <div class="footerint">
                                    <button type="submit" class="btn btn-outline-success btn-sm btn-rounded waves-effect "><i class="fas fa-save"></i> ADICIONAR</button>                                                                     
                                </div>                                  
                            </form>
                        </div>
                    </div>
                </div>
            </div>                            
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.mdb-select').materialSelect();                
        $('#valor').mask('#.##0,00', {reverse: true});      
        document.getElementById('form_informacoes').reset();
        $('.form-control').trigger("change");   
        $('.dropdown-content, .select-dropdown').perfectScrollbar();   
    });
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });
    $(document).on('change', '#funcaos_id', function() {atualizatarifa();});
</script>
