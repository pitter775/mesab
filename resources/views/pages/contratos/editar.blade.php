<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Editar Contrato</h5>
</div>
<div class="modal-body" style="padding: 0 0 20px 0;">
    <div class="row">
        <div class="col-md-12">
        <form name="form_informacoes_edit" id="form_informacoes_edit" class="col-md-12">
            <input type="hidden" id="id_geral_edit" name="id_geral" class="form-control" value="{{$dados_editar->id}}" required>
            @csrf                       
            <div class="row">                                            
                <div class="col-md-7">                                                
                    <div class="md-form">
                        <input type="text" id="ed_ctnome" name="ctnome" class="form-control" value="{{$dados_editar->ctnome ?? ''}}" required>
                        <label for="ed_ctnome" class="active">Nome do contrato</label>
                    </div>
                </div>   
                <div class="col-md-3">                                                
                    <div class="md-form">
                        <input type="text" id="ed_ctapelido" name="ctapelido" class="form-control" value="{{$dados_editar->ctapelido ?? ''}}" >
                        <label for="ed_ctapelido" class="active">Apelido</label>
                    </div>
                </div> 
                <div class="col-md-2">                                                
                    <div class="md-form">
                        <input type="text" id="ed_ctnumero" name="ctnumero" class="form-control" value="{{$dados_editar->ctnumero ?? ''}}" >
                        <label for="ed_ctnumero" class="active">Número</label>
                    </div>
                </div>   
                <div class="col-md-9">                                                
                    <div class="md-form">
                        <input type="text" id="ed_ctdescricao" name="ctdescricao" class="form-control" value="{{$dados_editar->ctdescricao ?? ''}}" >
                        <label for="ed_ctdescricao" class="active">Descrição</label>
                    </div>
                </div>  
                <div class="col-md-3">                                                
                    <div class="md-form">                                                
                        <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form editform" name="cttipo" id="ed_cttipo" >
                            <option @if( $dados_editar->cttipo == 'Apoio') selected @endif>Apoio</option>   
                            <option @if( $dados_editar->cttipo == 'Automação') selected @endif>Automação</option>   
                            <option @if( $dados_editar->cttipo == 'Jica') selected @endif>Jica</option>   
                            <option @if( $dados_editar->cttipo == 'Obra') selected @endif>Obra</option>   
                            <option @if( $dados_editar->cttipo == 'Pura') selected @endif>Pura</option>   
                            <option @if( $dados_editar->cttipo == 'Sabesp') selected @endif>Sabesp</option>   
                        </select>                                                
                        <label for="ed_cttipo" class="active">Tipo de contrato</label>
                    </div>
                </div>
     
                <div class="col-md-3">
                    <div class="md-form">                                                
                        <select class="mdb-select colorful-select dropdown-primary md-form editform" name="ctsituacao" id="ed_ctsituacao" >                                                                            
                            <option @if( $dados_editar->ctsituacao == 'A Contratar') selected @endif>A Contratar</option> 
                            <option @if( $dados_editar->ctsituacao == 'Em Andamento') selected @endif>Em Andamento</option> 
                            <option @if( $dados_editar->ctsituacao == 'Encerrado') selected @endif>Encerrado</option>                                                    
                        </select>                                                
                        <label for="ed_ctsituacao" class="active">Situação</label>
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
        $('.editform').materialSelect();
        $('.dropdown-content, .select-dropdown').perfectScrollbar();   
    });  
    $("#form_informacoes_edit").submit(function(e) {   
        e.preventDefault();        
        form_informacoes_edit(); 
    });
</script>

