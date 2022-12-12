<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Editar Tarifas</h5>
</div>
<div class="modal-body" style="padding: 0 0 20px 0;">
    <div class="row">
        <div class="col-md-12">
            <form name="form_informacoes_edit" id="form_informacoes_edit" class="col-md-12">
                <input type="hidden" id="id_geral_edit" name="id_geral" class="form-control" value="{{$dados_editar->id}}" required>
                @csrf                       
                <div class="row">                                            
                <div class="col-md-4">
                        <div class="md-form">                                                
                            <select class="mdb-select editselect colorful-select dropdown-primary md-form" name="funcaos_id" id="ed_funcaos_id" required >
                                    <option value="" disabled selected>Escolha a Função</option>   
                                    @foreach($funcao as $key => $value)
                                        <option value="{{$value->id ?? ''}}" @if($value->id == $dados_editar->funcaos_id ) selected @endif > {{ $value->fndescricao ?? ''}}</option>
                                    @endforeach                                                    
                            </select>                                                
                            <label for="ed_funcaos_id" class="active">Escolha a Função</label>
                        </div>
                    </div> 
 
                    <div class="col-md-4">                                                
                        <div class="md-form">
                            <input type="text" id="ed_valor" name="valor" class="form-control" value="{{ $dados_editar->valor ?? ''}}" required>
                            <label for="ed_valor" class="active">Tarifa</label>
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
        $('.editselect').materialSelect();     
        $('.form-control').trigger("change");     
        $('#ed_valor').mask('#.##0,00', {reverse: true});     
    });  
    $("#form_informacoes_edit").submit(function(e) {   
        e.preventDefault();        
        form_informacoes_edit(); 
    });
</script>

