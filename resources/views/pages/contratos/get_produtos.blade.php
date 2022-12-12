<style>    
    .divatividade{  border: solid 1px #d0e3f0; margin-bottom: 10px; padding: 5px 10px; border-radius: 5px; float: left;  margin-right: 10px; box-shadow: none; -webkit-transition: all 0.35s ease-out; transition: all 0.35s ease-out}
    .divatividade:hover {  border: solid 1px #f7fafc; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.12);-webkit-transition: all 0.35s ease-in;transition: all 0.35s ease-in}
    .switchacord{float: left; margin-top: 3px; margin-left:-15px}
    .switchacord2{margin-top: 3px; margin-left:-15px}
    .alocapse{margin-left: 60px; text-transform: uppercase; font-weight: bold; font-size: 12px; margin-top: 3px;}

</style>




<div id="accordion-2" role="tablist" aria-multiselectable="true" class="card-collapse" style="margin-top: -20px" data-aos="fade-left" data-aos-delay="0" >
    @foreach($produtos_acord as $key => $value)
        <div class="card card-plain">
            <div class="card-header" role="tab" id="heading{{$value->id}}">
                <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse{{$value->id}}" aria-expanded="false" aria-controls="collapse{{$value->id}}" id='bt{{$value->id}}'  class=" alocapse collapsed">
                <i class="fas fa-shield-alt" style="float: left; font-size: 15px; margin-left: 10px; margin-top: -3px; opacity:.5"></i> {{$value->prdescricao}}
                <i class="nc-icon nc-minimal-down"></i>
                </a>
            </div>
            <div id="collapse{{$value->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$value->id}}">
                <div class="card-body" style="padding-bottom: 20px !important;">
                 
                    <div style="display: table;">

                  
                    <?php $contt = 0 ?>
                    @foreach($atividades_acord as $key => $value2)
                        @if($value2->contrato_produtos_id == $value->id)
                        <div class="divatividade" style="background-color: #fff;">
                           
                        <i class="fas fa-snowboarding" style="opacity: .5; margin-right: 10px"></i>   {{$value2->atdescricao}}
                           
                        </div>
                        @endif
                        <?php $contt = $contt + 1 ?>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
            console.log('abrirt');
        }else{
            // $(bt).addClass('collapsed');
            // $(div).removeClass('show');
        }
    });
    $(document).on('change', '.checklever', function() {checklever($(this));});
</script>