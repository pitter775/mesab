<script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
<script>
    var appUrl ="{{env('APP_URL')}}";
    var modulo = 'meuscontratos';
    
    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    function add_cards(card, id, tipo){
        switch (card) {
            case 'lista':
                $.get(appUrl+'/'+modulo+'/add/lista-0', function(data){
                    $('#card_lista').html(data);
                    anima_editado(id, tipo); 
                });
            break;
            case 'create':
                $.get(appUrl+'/'+modulo+'/add/create-0', function(data){
                    $('#card_create').html(data);
                }); 
            break;
            case null:
                $.get(appUrl+'/'+modulo+'/add/lista-1', function(data){
                    $('#card_lista').html(data);
                });
                $.get(appUrl+'/'+modulo+'/add/create-1', function(data){
                    $('#card_create').html(data);
                }); 
            break;
        }
    }

    function deletar_item(id){
        if(confirm('Deseja remover esse item? ')){
            $.get(appUrl+'/'+modulo+'/delete/'+id, function(retorno){
                var result = retorno.split(',');
                if(result[0] == 'Erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{                  
                    demo.showNotification('top','center', 'success', result[0]);
                    obj = '#tab'+id; 
                    obj2 = 'tr > .child';
                    $(obj).addClass('editremove');
                    setTimeout(function(){ $(obj).addClass('anima');}, 10);
                    setTimeout(function(){ $(obj).removeClass('editremove');}, 20);                 
                    setTimeout(function(){ $(obj).hide('slow');}, 400);   
                    setTimeout(function(){ $(obj2).hide();}, 400);    
                }                             
            });
        }
    }

    function get_produtos(){
        var id = $('#contratos_id').val();
        console.log(id);
        $.get(appUrl+'/'+modulo+'/get_produtos/'+id, function(retorno){
            $('#retorno_produtos').html(retorno);
        });
    }
    function checklever(elemento){
        var checado = elemento.is(":checked");
        let idprod = elemento.data('propai');
        let objpai = '#checkprod'+idprod;
        $(objpai).prop("checked", true);
    }
    function checkprod(elemento){
        var checado = elemento.is(":checked");
        let idprod = elemento.val();
        let obj = '.checklever'+idprod;       



        $(obj).each(function() {
            if(checado){
                $(this).prop("checked", true);
            }else{
                $(this).prop("checked", false);
            }
        });
    }

function form_informacoes() {    
        let form = $('#form_informacoes');
        console.log(form.serializeArray());
        $.ajax({
            type: "POST",
            url: appUrl+'/'+modulo+'/cadastro',
            data: form.serializeArray(), 
            success: function(data)
            {
                console.log('form_informacoes');
                if (!Array.isArray(data)) {
                    demo.showNotification('top','center', 'info', 'Relacionamento existente');
                }else{
                    demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                    add_cards('lista',data, 'add');  
                    $('#accordion-2').hide('slow');
                    document.getElementById('form_informacoes').reset();
                    $('.form-control').trigger("change"); 
                    $('.ps-container').animate({scrollTop: 0}, 1000,);
                    
                }
            }
        });
    }

    
</script>