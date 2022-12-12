<style>    
    .divatividade{  border: solid 1px #d0e3f0; margin-bottom: 10px; padding: 5px 10px; border-radius: 5px; float: left;  margin-right: 10px; box-shadow: none; -webkit-transition: all 0.35s ease-out; transition: all 0.35s ease-out}
    .divatividade:hover {  border: solid 1px #f7fafc; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.12);-webkit-transition: all 0.35s ease-in;transition: all 0.35s ease-in}
    .switchacord{float: left; margin-top: 3px; margin-left:-15px}
    .switchacord2{margin-top: 3px; margin-left:-15px}
    .alocapse{margin-left: 60px; text-transform: uppercase; font-weight: bold; font-size: 12px; margin-top: 3px;}

</style>




<div id="accordion-2" role="tablist" aria-multiselectable="true" class="card-collapse" style="margin-top: -20px" data-aos="fade-left" data-aos-delay="0" >
    <h4 class="card-title" style="font-size: 16px; font-weight: 400;">Atividades do Departamento </h4>
    <div class="card card-plain">
        <div class="card-header" role="tab" id="heading{{$contrato_id}}">
            <div class="switch switchacord">
                <label><input type="checkbox" value="{{$departamentos_atv[0]->dadepartamentos_id}}" data-id="{{$contrato_id}}" class="checkprod" id="checkprod{{$departamentos_atv[0]->dadepartamentos_id}}"><span class="lever"></span></label>
            </div>
            <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse{{$contrato_id}}" aria-expanded="false" aria-controls="collapse{{$contrato_id}}" id='bt{{$contrato_id}}'  class=" alocapse collapsed">
                {{$departamentos_atv[0]->depnome}}
            <i class="nc-icon nc-minimal-down"></i>
            </a>
        </div>
        <div id="collapse{{$contrato_id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$contrato_id}}">
            <div class="card-body" style="padding-bottom: 20px !important;">
                <h4 class="card-title" style="font-weight: 400; color: #777; font-size: 16px; margin-left:-10px; margin-top:-10px">Atividades de {{$departamentos_atv[0]->depnome}}</h4>
                <div style="display: table;">    
                
                <?php $contt = 0 ?>
                @foreach($departamentos_atv as $key => $value2)                   
                    <div class="divatividade">
                        <div class="switch switchacord2 pequeno" >
                            <label>
                                <input type="checkbox" style="width: 20px;" data-propai="{{$departamentos_atv[0]->dadepartamentos_id}}" name="atividades[{{$departamentos_atv[0]->dadepartamentos_id}},{{$contt}}]" value="{{$value2->daatividades_id}}"
                                class=" checklever checklever{{$departamentos_atv[0]->dadepartamentos_id}}" ><span class="lever"></span> {{$value2->atdescricao}}
                            </label> 
                        </div> 
                    </div>
                    <?php $contt = $contt + 1 ?>
                @endforeach
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    $(document).on('change', '.checkprod', function() {
        checkprod($(this));
        id = $(this).data('id');
        bt = '#bt'+id;
        div = '#collapse'+id;

        if($(this).is(":checked")){
            $(bt).removeClass('collapsed');     
            $(div).addClass('show');     
        }else{
            // $(bt).addClass('collapsed');
            // $(div).removeClass('show');
        }
    });
    $(document).on('change', '.checklever', function() {
        checklever($(this));
    });
</script>