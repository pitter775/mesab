<div class="card"  {{$add_anima ?? ''}} style="z-index: 9;">
    <div class="card-body">
        <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
            <div class="card card-plain card_dif">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion"  href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                        <h5 style="margin: 0; padding:0; font-weight:300"> <i class="fas fa-plus" style="float: left; font-size: 15px; margin-top: 2px; opacity:.5"></i>  Adicionar Contrato <i class="nc-icon nc-minimal-down"></i></h5>
                        
                    </a>
                </div>
                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row">
                            <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                                <input type="hidden" id="id_geral" name="id_geral" class="form-control" value="" required>
                                @csrf                       
                                <div class="row">                                            
                                    <div class="col-md-4">
                                        <div class="md-form">                                                
                                            <select searchable="Procurar..."  class="mdb-select colorful-select dropdown-primary md-form perfect-scrollbar" name="contratos_id" id="contratos_id" required >
                                                <option value="" disabled selected></option>                                            
                                                    @foreach($contratos as $key => $value)
                                                        <option value="{{$value->id ?? ''}}">{{$value->ctnumero ?? ''}} - {{$value->ctnome ?? ''}}</option>
                                                    @endforeach                                                          
                                            </select>                                                
                                            <label for="contratos_id" class="active">Selecione o contrato</label>
                                        </div>
                                    </div> 
                                                                      
                                </div>
                                <div class="row">
                                    <div id="retorno_produtos" class="col-md-12">

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
    $(document).on('change', '#contratos_id', function() {get_produtos();});
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });
</script>