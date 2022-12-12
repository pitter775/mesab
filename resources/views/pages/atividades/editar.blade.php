<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Editar Atividades</h5>
</div>
<div class="modal-body" style="padding: 0 0 20px 0;">
    <div class="row">
        <div class="col-md-12">
            <form name="form_informacoes_edit" id="form_informacoes_edit" class="col-md-12">
                <input type="hidden" id="id_geral_edit" name="id_geral" class="form-control" value="{{$dados_editar->id}}" required>
                @csrf                       
                <div class="row">                                            
                    <div class="col-md-6">                                                
                        <div class="md-form">
                            <input type="text" id="atdescricao" name="atdescricao" class="form-control" value="{{$dados_editar->atdescricao}}" required>
                            <label for="atdescricao" class="active">Descrição</label>
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
    $(document).ready(function () {
        $('.form-control').trigger("change");      
    });  
    $("#form_informacoes_edit").submit(function(e) {   
        e.preventDefault();        
        form_informacoes_edit(); 
    });
</script>

