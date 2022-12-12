<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Editar mensagem enviada</h5>
</div>
<style>
    .ck-blurred p { font-weight: 400;}
</style>
<div class="modal-body" style="padding: 0 0 20px 0;">
    <div class="row">
        <div class="col-md-12">
            <form name="form_informacoes_edit" id="form_informacoes_edit" class="col-md-12">
                <input type="hidden" id="id_geral_edit" name="id_geral" class="form-control" value="{{$dados_editar->id}}" required>
                @csrf                       
                <div class="row">
                    <div class="col-md-12" style="margin-top: -20px;">                                                
                        <div class="md-form">
                            <input type="text" id="titulo" name="titulo" class="form-control" value="{{$dados_editar->titulo}}" required>
                            <label for="titulo" class="active">Titulo</label> 
                        </div>
                    </div>     
                    <div class="col-md-12">
                        <label style="color: #777;">Corpo da Mensagem</label>
                        <div class="form-group">
                            <!-- <input type="text" name="objeto" class="form-control" placeholder="Objeto do Aditivo:" value="{{$dados_geral->objeto ?? ''}}"> -->
                            <textarea id="ed_editor77" placeholder="" class="form-control input-md">{!!$dados_editar->mensagem ?? ''!!}</textarea>
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
        $('.dropdown-content, .select-dropdown').perfectScrollbar();   
        $('.editselect').materialSelect();  
        ClassicEditor.create( document.querySelector( '#ed_editor77' ), {}).then( ed_editor77 => {
            window.ed_editor77 = ed_editor77; }).catch( err => {console.error( err.stack );
        }); 
    });  
    $("#form_informacoes_edit").submit(function(e) {   
        e.preventDefault();        
        form_informacoes_edit(); 
    });
</script>

