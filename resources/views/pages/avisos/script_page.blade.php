<script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
<script>
    var appUrl ="{{env('APP_URL')}}";
    var modulo = 'avisos';

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

    function editar_lista($id){
        $.get(appUrl+'/'+modulo+'/editar/'+$id, function(retorno){
            $('#retorno_modal_lista').html(retorno);
        });
    }     
    
    function form_informacoes_edit() {        
        let form = $('#form_informacoes_edit');
        var idgeral = $('#id_geral_edit').val();
        const ed_editorData = ed_editor77.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "mensagem", value: ed_editorData});
        
        $.ajax({
            type: "POST",
            url: appUrl+'/'+modulo+'/cadastro',
            data: dados_serealize, 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{                  
                    demo.showNotification('top','center', 'success', 'Item editado com sucesso ');
                    add_cards('lista',idgeral, 'edit');  
                    $('#myModal_lista').modal('toggle');
                }
            }
        });
    }
    
    function form_informacoes() {    
        let form = $('#form_informacoes');
        const editorData = editor77.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "mensagem", value: editorData});
        console.log(dados_serealize);
        $.ajax({
            type: "POST",
            url: appUrl+'/'+modulo+'/cadastro',
            data: dados_serealize, 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{                  
                    demo.showNotification('top','center', 'success', 'Envio de Mensagens com sucesso!');
                    add_cards('lista',data, 'add');  
                    document.getElementById('form_informacoes').reset();
                    editor77.setData( '' );
                    $('.form-control').trigger("change");  
                }
            }
        });
    }
</script>