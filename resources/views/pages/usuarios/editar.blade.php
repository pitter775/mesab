<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Editar Usuário</h5>
</div>
<div class="modal-body" style="padding: 0 0 20px 0;">
    <div class="row">
        <div class="col-md-12">
        <form name="form_informacoes_edit" id="form_informacoes_edit" class="col-md-12">
            <input type="hidden" id="id_geral_edit" name="id_geral" class="form-control" value="{{$dados_editar->uid}}" required>
            @csrf                       
            <div class="row">                                            
                <div class="col-md-9">                                                
                    <div class="md-form">
                        <input type="text" id="ed_name" name="name" class="form-control" value="{{$dados_editar->name ?? ''}}" required>
                        <label for="ed_name" class="active">Nome</label>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="md-form">                                                
                        <select class="mdb-select editselect colorful-select dropdown-primary md-form" name="departamentos_id" id="ed_departamentos_id" >
                            <option value="" disabled selected></option>                                            
                                @foreach($departamento as $key => $value)
                                    <option value="{{$value->id ?? ''}}" @if($value->id == $dados_editar->departamentos_id ) selected @endif>{{$value->depnome ?? ''}}</option>
                                @endforeach                                                     
                        </select>                                                
                        <label for="ed_departamentos_id" class="active">Departamento</label>
                    </div>
                </div> 
           
                <div class="col-md-3">
                    <div class="md-form">                                                
                        <select class="mdb-select editselect colorful-select dropdown-primary md-form" name="funcaos_id" id="ed_funcaos_id" required >
                            <option value="" disabled selected></option>                                            
                                @foreach($funcao as $key => $value)
                                    <option value="{{$value->id ?? ''}}" @if($value->id == $dados_editar->funcaos_id ) selected @endif >{{$value->fndescricao ?? ''}}</option>
                                @endforeach                                                          
                        </select>                                                
                        <label for="ed_funcaos_id" class="active">Função</label>
                    </div>
                </div>

           
                
                
                

                <div class="col-md-3">                                                
                    <div class="md-form">
                        <input type="text" id="ed_tarifa" name="tarifa" class="form-control" value="{{ $dados_editar->valor ?? ''}}" required disabled>
                        <label for="ed_tarifa" class="active">Tarifa</label>
                    </div>
                </div>  
            
                <div class="col-md-4">
                    <div class="md-form">
                        <input type="email" name="email" id="ed_email" class="form-control"  value="{{ $dados_editar->email ?? ''}}" required>
                        <label for="ed_email" class="active">Login</label>
                    </div>
                </div>                         
                <div class="col-md-2">
                    <div class="md-form">
                        <input type="text" name="password" id="ed_password" class="form-control"  value="">
                        <label for="ed_password" class="active">Trocar Senha</label>
                    </div>
                </div>

                <div class="col-md-6" style="text-align: right;">
                <div class="md-form">
                    <div class="form-check-inline">
                        <input     class="form-check-input"    type="radio"    name="perfil"    id="ed_perfil1" value="0"  @if('0' == $dados_editar->perfil ) checked @endif   />
                        <label class="form-check-label" for="ed_perfil1"> Normal </label>
                    </div>

                    <div class="form-check-inline">  
                        <input    class="form-check-input"    type="radio"    name="perfil"    id="ed_perfil2"   value="1"   @if('1' == $dados_editar->perfil ) checked @endif  />
                        <label class="form-check-label" for="ed_perfil2"> Administrativo </label>
                    </div>
                    @if( Auth::user()->perfil  == '2')
                        <div class="form-check-inline">  
                            <input    class="form-check-input"    type="radio"    name="perfil"    id="ed_perfil3"  value="2"   @if('2' == $dados_editar->perfil ) checked @endif   />
                            <label class="form-check-label" for="ed_perfil3"> Master </label>
                        </div>
                    @endif  
                </div>
                </div>
        
            </div>
            <div class="footerint">
                <button type="submit" class="btn btn-outline-primary btn-sm btn-rounded waves-effect"><i class="fas fa-save"></i> Salvar</button>                                                                       
            </div>                                  
        </form>
        </div>
    </div>
</div>
<script>

    if($('#hidhoras').val() == '1'){
        $('#ed_horas').prop("checked", true);
    }
    $(document).ready(function () {
        $('.editselect').materialSelect();     
        $('.form-control').trigger("change");     
        $('#ed_valor').mask('#.##0,00', {reverse: true});     
        $('.dropdown-content, .select-dropdown').perfectScrollbar();  
    });  
    $("#form_informacoes_edit").submit(function(e) {   
        e.preventDefault();        
        form_informacoes_edit(); 
    });
    $(document).on('change', '#ed_funcaos_id', function() {ed_atualizatarifa();});
</script>

