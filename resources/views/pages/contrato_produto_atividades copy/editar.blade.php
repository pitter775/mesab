<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Editar Contrato/Produto com Atividade</h5>
</div>
<div class="modal-body" style="padding: 0 0 20px 0;">
    <div class="row">
        <div class="col-md-12">
        <form name="form_informacoes_edit" id="form_informacoes_edit" class="col-md-12">
            <input type="hidden" id="id_geral_edit" name="id_geral" class="form-control" value="{{$dados_editar->id}}" required>
            @csrf                       
            <div class="row"> 
                <div class="col-md-5">
                    <div class="md-form">                                                
                        <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form editform" name="contratos_id" id="edit_contratos_id" required>
                            <option value="" disabled selected></option>                                            
                                @foreach($contratos as $key => $value)
                                    <option value="{{$value->id ?? ''}}" @if($value->id == $dados_editar->contratos_id ) selected @endif >{{$value->ctnome ?? ''}}</option>
                                @endforeach                                                     
                        </select>                                                
                        <label for="edit_contratos_id" class="active">Contrato</label>
                    </div>
                </div>  
                <div class="col-md-1 my-auto align-self-center" style="text-align: center;"><i class="fas fa-arrows-alt-h" style="font-size: 20px; "></i></div>
                <div class="col-md-4">
                    <div class="md-form">                                                
                        <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form editform" name="produtos_id" id="edit_produtos_id" required>
                            <option value="" disabled selected></option>                                            
                                @foreach($produtos as $key => $value)
                                    <option value="{{$value->id ?? ''}}" @if($value->id == $dados_editar->produtos_id ) selected @endif >{{$value->prdescricao ?? ''}}</option>
                                @endforeach                                                     
                        </select>                                                
                        <label for="edit_produtos_id" class="active">Produto</label>
                    </div>
                </div>                                          
                <div class="col-md-2">                                                
                    <div class="md-form">
                        <input type="text" id="edit_csppep" name="csppep" class="form-control" value="{{$dados_editar->csppep ?? ''}}" >
                        <label for="edit_csppep" class="active">PEP</label>
                    </div>
                </div>      
                <div class="col-md-12">                                                
                    <div class="md-form">
                        <input type="text" id="edit_cspdescricao" name="cspdescricao" class="form-control" value="{{$dados_editar->cspdescricao ?? ''}}" >
                        <label for="edit_cspdescricao" class="active">Descrição</label>
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

<script>
    $(document).ready(function () {
        $('.form-control').trigger("change"); 
        $('.editform').materialSelect();
        $('.dropdown-content, .select-dropdown').perfectScrollbar();       
    });  
    $("#form_informacoes_edit").submit(function(e) {   
        e.preventDefault();        
        form_informacoes_edit(); 
    });
</script>

