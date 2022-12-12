<div class="card" {{$add_anima ?? ''}} style="z-index: 9;">
    <div class="card-body"> 
        <div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">
            <div class="card card-plain card_dif">
                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                        <h5 style="margin: 0; padding:0; font-weight:300"> <i class="fas fa-plus" style="float: left; font-size: 15px; margin-top: 2px; opacity:.5"></i> Criar Mensagens <i class="nc-icon nc-minimal-down"></i></h5>
                        
                    </a>
                </div>
                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row">
                            <form name="form_informacoes" id="form_informacoes" class="col-md-12">
                                <input type="hidden" id="id_geral" name="id_geral" class="form-control" value="" required>
                                @csrf                       
                                <div class="row">                              
                              
                                    <div class="col-md-12">
                                        <div class="md-form">
                                            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="usuario[]" id="usuario" multiple>
                                                <option value="" disabled selected></option>                                            
                                                <option value="">Selecione...</option>                                            
                                                @foreach($usuarios as $key => $value)
                                                    @if(isset($filtros['usuario']))
                                                        <option value="{{$value->id ?? ''}}" selected>{{$value->name ?? ''}}</option>   
                                                        @else
                                                        <option value="{{$value->id ?? ''}}">{{$value->name ?? ''}}</option>                            
                                                        @endif                         
                                                @endforeach                                                     
                                            </select> 
                                            <label for="usuario" class="active"><i class="fas fa-users" style="color: #444; margin-right: 5px"></i>  Usuários</label>
                                        </div>
                                    </div>  
                                                                            
                                    <div class="col-md-12" style="margin-top: -20px;">                                                
                                        <div class="md-form">
                                            <input type="text" id="titulo" name="titulo" class="form-control" value="" required>
                                            <label for="titulo" class="active">Titulo</label> 
                                        </div>
                                    </div>     
                                    <div class="col-md-12">
                                        <label style="color: #777;">Corpo da Mensagem</label>
                                        <div class="form-group">
                                            <!-- <input type="text" name="objeto" class="form-control" placeholder="Objeto do Aditivo:" value="{{$dados_geral->objeto ?? ''}}"> -->
                                            <textarea id="editor77" placeholder="" class="form-control input-md">{!!$dados_geral->objeto ?? ''!!}</textarea>
                                        </div>
                                    </div>  
                                    <div class="divatividade">
                                        <div class="switch switchacord2 pequeno">
                                            <label><input type="checkbox" style="width: 20px;" name="enviar_email" value="email" class="checklever checklever47" checked>
                                            <span class="lever"></span> Enviar por email</label> 
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
        ClassicEditor.create( document.querySelector( '#editor77' ), {}).then( editor77 => {
            window.editor77 = editor77; }).catch( err => {console.error( err.stack );
        }); 
    });
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        form_informacoes();        
    });
</script>