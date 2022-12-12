<div class="card" {{$add_anima ?? ''}} style="z-index: 9;">
    <div class="card-body">
        <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
            <div class="card card-plain card_dif">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                        <h5 style="margin: 0; padding:0; font-weight:300"> <i class="fas fa-plus" style="float: left; font-size: 15px; margin-top: 2px; opacity:.5"></i> Cadastrar Contrato <i class="nc-icon nc-minimal-down"></i></h5>
                         
                    </a>
                </div>
                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row">
                            <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                                <input type="hidden" id="id_geral" name="id_geral" class="form-control" value="" required>
                                @csrf                       
                                <div class="row">                                            
                                    <div class="col-md-7">                                                
                                        <div class="md-form">
                                            <input type="text" id="ctnome" name="ctnome" class="form-control" value="" required>
                                            <label for="ctnome" class="active">Nome do contrato</label>
                                        </div>
                                    </div>    
                                    <div class="col-md-3">                                                
                                        <div class="md-form">
                                            <input type="text" id="ctapelido" name="ctapelido" class="form-control" value="">
                                            <label for="ctapelido" class="active">Apelido</label>
                                        </div>
                                    </div> 
                                    <div class="col-md-2">                                                
                                        <div class="md-form">
                                            <input type="text" id="ctnumero" name="ctnumero" class="form-control" value="" >
                                            <label for="ctnumero" class="active">Número</label>
                                        </div>
                                    </div>   
                                    <div class="col-md-9">                                                
                                        <div class="md-form">
                                            <input type="text" id="ctdescricao" name="ctdescricao" class="form-control" value="" >
                                            <label for="ctdescricao" class="active">Descrição</label>
                                        </div>
                                    </div>  
                                    <div class="col-md-3">                                                
                                        <div class="md-form">                                                
                                            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="cttipo" id="cttipo" >
                                                <option value="" disabled selected></option>
                                                <option>Apoio</option>
                                                <option>Automação</option>
                                                <option>Jica</option>
                                                <option>Obra</option>
                                                <option>Pura</option>
                                                <option>Sabesp</option>
                                            </select>                                                
                                            <label for="cttipo" class="active">Tipo de contrato</label>
                                        </div>
                                    </div>  
                                    <div class="col-md-3">
                                        <div class="md-form">                                                
                                            <select class="mdb-select colorful-select dropdown-primary md-form" name="ctsituacao" id="ctsituacao" >    
                                                    <option value="" disabled selected></option>                                                                         
                                                    <option>A Contratar</option>
                                                    <option>Em Andamento</option>                                                      
                                                    <option>Encerrado</option>                                                      
                                            </select>                                                
                                            <label for="ctsituacao" class="active">Situação</label>
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
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.mdb-select').materialSelect();
        $('.form-control').trigger("change");   
        $('.dropdown-content, .select-dropdown').perfectScrollbar();    
    });
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });
</script>