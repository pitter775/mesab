<div class="card"  {{$add_anima ?? ''}} style="z-index: 9;">
    <div class="card-body">
        <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
            <div class="card card-plain card_dif">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion"  href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                        <h5 style="margin: 0; padding:0; font-weight:300"> <i class="fas fa-plus" style="float: left; font-size: 15px; margin-top: 2px; opacity:.5"></i> Cadastrar Função <i class="nc-icon nc-minimal-down"></i></h5>
                        
                    </a>
                </div>
                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row">
                            <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                                <input type="hidden" id="id_geral" name="id_geral" class="form-control" value="" required>
                                @csrf                       
                                <div class="row">                                            
                                    <div class="col-md-6">                                                
                                        <div class="md-form">
                                            <input type="text" id="fndescricao" name="fndescricao" class="form-control" value="" required>
                                            <label for="fndescricao" class="active">Descrição</label>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="footerint">
                                    <button type="submit" class="btn btn-outline-success btn-sm btn-rounded waves-effect"><i class="fas fa-save"></i> Adicionar</button>          
                                                                                         
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
    });
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });
</script>