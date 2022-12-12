<script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
<script>
    var appUrl ="{{env('APP_URL')}}";
    var modulo = 'atividades';

    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    
    function anima_editado($id, tipo){ 
            tipocor = '';    
            if(tipo == 'edit'){tipocor = 'anima_edit'}  
            if(tipo == 'add'){tipocor = 'anima_add'}
            if (!Array.isArray($id)) {
                let obj = '#tab'+$id;
                $(obj).addClass(tipocor);
                setTimeout(function(){ $(obj).addClass('anima');}, 10);
                setTimeout(function(){ $(obj).removeClass(tipocor);}, 20);
                setTimeout(function(){ $(obj).removeClass('anima');}, 1000);
            }else{
                for (let i = 0; i < $id.length; ++i) {
                    let obj = '#tab'+$id[i];
                    $(obj).addClass(tipocor);
                    is0 = i+'0';
                    is1 = i+'00';
                    is2 = i+'000';
                    setTimeout(function(){ $(obj).addClass('anima');}, parseInt(is0));
                    setTimeout(function(){ $(obj).removeClass(tipocor);}, parseInt(is1));
                    setTimeout(function(){ $(obj).removeClass('anima');}, 1000+parseInt(is2));
                }
            }
        } 

    
</script>