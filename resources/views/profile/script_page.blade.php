<script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
<script>
    var appUrl ="{{env('APP_URL')}}";
    var modulo = 'profile';

    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    function add_cards(card, id, tipo){ 
        switch (card) {
            case 'lista':
                $.get(appUrl+'/'+modulo+'/add/lista-0', function(data){
                    $('#card_lista').html(data);
                    anima_editado(id, tipo); 
                });
            break;
            case 'lista_atestado':
                $.get(appUrl+'/'+modulo+'/add/lista_atestado-0', function(data){
                    $('#card_lista_atestado').html(data);
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
                $.get(appUrl+'/'+modulo+'/add/lista_atestado-1', function(data){
                    $('#card_lista_atestado').html(data);
                });
                $.get(appUrl+'/'+modulo+'/add/create-1', function(data){
                    $('#card_create').html(data);
                }); 
            break;
        }
    }

    function deletar_item_atestado(id){
        if(confirm('Deseja remover esse item? ')){
            $.get(appUrl+'/'+modulo+'/atestado/delete/'+id, function(retorno){
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
    function deletar_item(id){
        if(confirm('Deseja remover esse item? ')){
            $.get(appUrl+'/'+modulo+'/ferias/delete/'+id, function(retorno){
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
    
    function form_informacoes_edit() {        
        let form = $('#form_informacoes_edit');
        var idgeral = $('#id_geral_edit').val();
        $.ajax({
            type: "POST",
            url: appUrl+'/'+modulo+'/cadastro',
            data: form.serializeArray(), 
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
    
    function form_ferias() {    
        let form = $('#form_ferias');
        console.log(form.serializeArray());
        $.ajax({
            type: "POST",
            url: appUrl+'/'+modulo+'/ferias/cadastro',
            data: form.serializeArray(), 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{                  
                    demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                    add_cards('lista',data, 'add');  
                    document.getElementById('form_ferias').reset();
                    $('.form-control').trigger("change");  
                }
            }
        });
    }

    function form_anexo() {  
        let form = $('#form_anexo');
        console.log(form.serializeArray());
        var data = new FormData($("form[name='form_anexo']")[0]);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            url: appUrl+'/'+modulo+'/anexos/add',
            data: data, 
            success: function(retorno)
            {
                console.log(retorno);
            }
        });
    }
    function form_atestado() {  
        let form = $('#form_atestado');
        console.log(form.serializeArray());
        var data = new FormData($("form[name='form_atestado']")[0]);
        console.log(data);
   
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            url: appUrl+'/'+modulo+'/atestado/cadastro',
            data: data, 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{                  
                    demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                    add_cards('lista_atestado',data, 'add');  
                    document.getElementById('form_atestado').reset();
                    $('.form-control').trigger("change");  
                }
            }
        });
    }


    function verfoto(foto){
        var fotof = ';'
        var retorno = foto.split(".");
        if(retorno[1] == 'pdf'){
            fotof = '<embed src="/storage/'+foto+'" frameborder="0" width="100%" height="800px">';
        }else{
            fotof = '<img  src="/storage/'+foto+'">';
        }
        
        $('.divverfoto').html(fotof);

    }

    function btdias(){
        $('.escolha').hide();
        $('.comdatas').show();
        $('.tipodias').show();
        $('#tipo').val('dias');
        $('.form-control').trigger("change");
    }
    function bthoras(){
        $('.escolha').hide();
        $('.comdatas').show();
        $('.tipohoras').show();
        $('#tipo').val('horas');
        $('#horas_at').pickatime({twelvehour: false,});
        $('.form-control').trigger("change");
    }
    function btvoltar(){
        $('#datahora').val('');
        $('#horas_at').val('');
        $('#datainicio_at').val('');
        $('#datafim_at').val('');

        $('.escolha').show();
        $('.comdatas').hide();
        $('.tipohoras').hide();
        $('.tipodias').hide();
        
    }
</script>