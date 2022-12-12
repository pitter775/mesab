<style>    
    .divatividade{  border: solid 1px #d0e3f0; margin-bottom: 10px; padding: 5px 10px; border-radius: 5px; float: left;  margin-right: 10px; box-shadow: none; -webkit-transition: all 0.35s ease-out; transition: all 0.35s ease-out}
    .divatividade:hover {  border: solid 1px #f7fafc; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.12);-webkit-transition: all 0.35s ease-in;transition: all 0.35s ease-in}
    .switchacord{float: left; margin-top: 3px; margin-left:-15px}
    .switchacord2{margin-top: 3px; margin-left:-15px}
    .alocapse{margin-left: 60px; text-transform: uppercase; font-weight: bold; font-size: 12px; margin-top: 3px;}
    .modal-header{ z-index: 9999;}

</style>


<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
    <h5>Adicionar ou Remover as Atividades</h5>

</div>
<div class="modal-body" style="padding: 0 0 20px 0;">
 
    <div class="card-body" style="padding-bottom: 20px !important; margin-top: -60px">
        <h4 class="card-title" style="font-weight: 400; color: #555; font-size: 16px; ">{{$dados_lista[0]->ctnumero}} - {{$dados_lista[0]->ctnome}}</h4>
        <h5 class="card-title" style="font-weight: 400; color: #555; font-size: 16px; ">{{$dados_lista[0]->prdescricao}}</h4>
        <div style="display: table; margin-top: 20px">        
        <?php $contt = 0 ?>       
            @foreach($cont_prod_atv as $key => $value)
                <?php    
                    $checked = '';
                    foreach($dados_lista as $key2 => $value2){
                        if($value->atividades_id == $value2->atividades_id){
                            $checked = 'checked';
                        }
                    }
                ?>
   
                <div class="divatividade">
                    <div class="switch switchacord2 pequeno" >
                        <label><input type="checkbox" style="width: 20px;" data-contpro = '{{$value->contrato_produtos_id}}' value="{{$value->atividades_id}}" class=" checklever" {{$checked}} >
                               <span class="lever"></span> {{$value->atdescricao}}
                        </label> 
                    </div> 
                </div>            
                <?php $contt = $contt + 1 ?>
            @endforeach
        </div>
    </div>
</div>

<script>

    $( ".checklever" ).click(function() {checklever($(this));});
    var contador = 99999;

    function checklever(elemento){
        contador = contador + 1;
        var checado = elemento.is(":checked");
        let idprod = elemento.data('contpro');
        let idatv = elemento.val();

        var dados = [];
            dados.push(
                {name: "contproid", value: idprod},
                {name: "ativid", value: idatv}
            );

        if(checado){
            $.get(appUrl+'/'+modulo+'/add/add_atv-0', dados, function(retorno){            
                divpai = '#prod'+retorno['produtos_id']+retorno['contratos_id'];
                let html = '<div class="flex-container rowatividade" id="atv'+retorno['contratos_id']+retorno['produtos_id']+idatv+'">'+
                                '<div class="divform" >'+
                                    '<div class="md-form">'+
                                        '<input type="hidden" id="aldescricao'+contador+'" class="inputhoras" name="horas['+retorno['contratos_id']+', '+retorno['produtos_id']+', '+idatv+', '+contador+']" value="00:00" >  '+                                                                                              
                                        '<i class="far fa-clock" style="font-size: 10px; margin-left: -10px"></i>'+
                                        '<input type="text" value="" id="horas'+contador+'" data-id="'+contador+'" data-tipo="hora" max="40" maxlength="2" class="formhoras" placeholder="hh"> : '+
                                        '<input type="text" value=""  id="minutos'+contador+'" data-id="'+contador+'" data-tipo ="minuto" max="59" step="10"  maxlength="2" class="formhoras" placeholder="mm">'+
                                    '</div>'+
                                '</div>'+                                                                                    
                            
                                '<div class="labelatv">'+
                                    '<label for="aldescricao'+contador+'" class="active">'+retorno['atdescricao']+' </label>'+
                                '</div>'+
                            '</div>'
                $(divpai).append(html);
            });
        }else{
            $.get(appUrl+'/'+modulo+'/add/remove_atv-0', dados, function(retorno){
                divremove = '#atv'+retorno['contratos_id']+retorno['produtos_id']+idatv;
                $(divremove).remove();
            });
        }
    }
</script>