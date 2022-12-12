
<script>
    var appUrl ="{{env('APP_URL')}}"; 
    var modulo = 'horas'; 
    var allcontratos = []; 

    function criarcontartos(){
        // arrayteste.push({name: "mensagem", value: ed_editorData});
        $( ".cardcontratosid" ).each(function() { 
            let ctnumero =  $( this ).attr("data-ctnumero"); 
            let ctnome =  $( this ).attr("data-ctnome"); 
            let contratos_id =  $( this ).attr("data-contratos_id"); 
            allcontratos.push ({ctnumero: ctnumero, contratos_id: contratos_id, ctnome:ctnome});
        });
    }
    function filtrarbusca(){
         $( ".cardcontratosid" ).css("display", "none");
        const searchString = $('#buscactnome').val();
        const escapeRegExp = (str) => // or better use 'escape-string-regexp' package
        str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
        const filterBy = (term) => {
            const re = new RegExp(escapeRegExp(term), 'i')
            return person => {
                for (let prop in person) {
                if (!person.hasOwnProperty(prop)) {
                    continue;
                }
                if (re.test(person[prop])) {
                    return true;
                }
                }
                return false;        
            }
        }
        const found = allcontratos.filter(filterBy(searchString))
        limpardados(found);
    }
    function limpardados(dados){
        for(const member of dados){
            if(member){
                $( ".cardcontratosid" ).each(function() {   
                    let id =  $( this ).attr("data-contratos_id");   
                    if(id == member.contratos_id){
                        $( this ).css("display", "block"); 
                    } 
                });
            }            
        }
    }
    function editar_atv(prid, contid){
        var dados_serealize = [];
            dados_serealize.push(
                {name: "card", value: 'editar_atv'},
                {name: "prid", value: prid},
                {name: "contid", value: contid},
            );
        $.get(appUrl+'/'+modulo+'/add/editar_atv-0', dados_serealize, function(retorno2){
            $('#retorno_editatv').html(retorno2);
        });
    }
    function add_cards(card, id, tipo){
        switch (card) {
            case 'lista':
                $.get(appUrl+'/'+modulo+'/add/lista-0', function(data){
                    $('#card_lista').html(data);
                    anima_editado(id, tipo); 
                });
            break;

            case 'lista_horas':            
                dados = {inicio: $('#data_inicio_s').val(), fim: $('#data_fim_s').val()}; 
                $.get(appUrl+'/'+modulo+'/add/lista_horas-0',dados, function(data){
                    $('#card_horas_lista').html(data);
                    anima_editado(id, tipo); 
                });
            break;

            case 'create':
                $.get(appUrl+'/'+modulo+'/add/create-0', function(data){
                    $('#card_calendario').html(data);
                }); 
            break;
            case null:
                $.get(appUrl+'/'+modulo+'/add/lista-1', function(data){
                    $('#card_lista').html(data);
                });
                $.get(appUrl+'/'+modulo+'/add/create-1', function(data){
                    $('#card_calendario').html(data);
                }); 
            break;
        }
    }
    function verificarhoras(){
        arrayhoras = [];
        var soma = horas_banco;
       

        // console.log(idfuncao);

        $('.inputhoras').each(function(){
            if($(this).val() == ''){
                $(this).val('00:00');
            }
            if($(this).val() !== '00:00'){
                $(this).parent().parent().parent().addClass('addselecao');
                var valor = $(this).val();
                $(this).val(valor.replace(/[-]/g, ''));
                arrayhoras.push($(this).val());
            }
        })


        for (var x=0; x < arrayhoras.length; x++) {
            soma = calcular(soma, arrayhoras[x],'+');
        }
        trestante = calcular(soma, restante, '-');
        porcentag = horas_segundos(soma) * 100 / horas_segundos(total_horas);   

        $('.saldohoras1').text(soma);
        $('.totalhoras1').text(trestante);
        $('#horas_cadastradas').val(soma);
        if(porcentag > 100 || porcentag < 0){
            $("#btaddhotas").prop("disabled",true);
        }else{
            $("#btaddhotas").prop("disabled",false);          
        }
        if(trestante.substr(0, 1) == '-'){
            $('.totalhoras1').text('Ultrapassou');
            $('.totalhoras').text('');
        }else{
            $('.totalhoras').text('Restante');
        }
        atualizachart(porcentag);

        var horasilimit = $('#horas_ilimitadas').val();
        if(horasilimit == '1'){
            $("#btaddhotas").prop("disabled",false);  
            $('.totalhoras').hide(); 
            $('.saldohoras').hide(); 
            $('.totalhoras1').hide(); 
            $('.divchart').hide(); 
        }
        
    }
    function hmToMins(str) {
        const [hh, mm] = str.split(':').map(nr => Number(nr) || 0);
        return hh * 60 + mm;
    }
    function calcular(total, adicionar, sinal) {
        const segent = hmToMins(total);
        const segsai = hmToMins(adicionar);
        var diff = null;
        if(sinal == '+'){
            diff = segsai + segent;
        }
        if(sinal == '-'){
            diff = segsai - segent;
        }
        
        if (isNaN(diff)) return;
        const hhmm = [
            Math.floor(diff / 60), 
            Math.round(diff % 60)
        ].map(nr => `00${nr}`.slice(-2)).join(':');
        
        return hhmm;
    }
    function horas_segundos(hms){
        var a = hms.split(':'); // split it at the colons
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60; 
        return seconds;
    }    
    function editar_lista($id){
        $.get(appUrl+'/'+modulo+'/editar/'+$id, function(retorno){
            $('#retorno_modal_lista').html(retorno);
        });
    }    
    function form_horas() {    
        let form = $('#form_horas');
        $.ajax({
            type: "POST",
            url: appUrl+'/'+modulo+'/cadastro',
            data: form.serializeArray(), 
            success: function(data)
            {
                var result = data.toString().split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    dados2 = {inicio: $('#data_inicio_rec').val(), fim:$('#data_fim_rec').val(), data_voltar:$('#data_voltar').val()}; 
                    $('#card_add_horas').animate({opacity: 0 }, 200, function() {
                        $.get(appUrl+'/'+modulo+'/add/add_horas-0', dados2, function(retorno2){
                            $('#card_horas').html(retorno2);
                            demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');     
                            add_cards('lista_horas',data, 'add');  
                        });
                    });                   
                }
            }
        });
    }
    function atualizachart(porcentagem){
        $color = '#0254ce';
        $(".percent").removeClass('ajustepercent');
        if(porcentagem == 100){
            $color = '#169c00';
            $(".percent").addClass('ajustepercent');
        }
        if(porcentagem > 100){
            $color = '#ff2424';
        }
        if(porcentagem < 0){
            $color = '#ff2424';
        }
        $('.divchart').html('');
        if(porcentagem !== 0){
            $('.divchart').html('<span style="position: relative;" class="min-chart my-4" id="chart-sales" data-percent="'+porcentagem+'"><span class="percent"></span></span>');
            $('.min-chart#chart-sales').easyPieChart({
                barColor: $color,
                onStep: function (from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent)+'%');
                }
            });
        }
    }
    function voltar_calendario(){
        $( "#card_add_horas" ).hide();
        $( "#card_add_horas_lista" ).hide();

        $('#data_voltar_calend').val(data_voltar);
        $.get(appUrl+'/'+modulo+'/add/lista-1', function(data){    
            $('#card_lista').html(data);
        });
        $.get(appUrl+'/'+modulo+'/add/create-1', function(data){
            $('#card_calendario').html(data);
        });
    }
    function deletar_item(id){
        if(confirm('Deseja remover esse item? ')){
            let obj = '#del'+id;
            let tempo = $(obj).data('tempo');
            let horas_atual = $('#horas_cadastradas').val();
            let horas_alterada = calcular(tempo, horas_atual,'-'); 
            dados = horas_alterada+'-'+id; 

            
            $.get(appUrl+'/'+modulo+'/delete/'+dados, function(retorno){ 
                var result = retorno.split(',');
                if(result[0] == 'Erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{ 
                    demo.showNotification('top','center', 'success', result[0]);
                    obj = '#tab'+id; 
                    obj2 = 'tr > .child';
                    $(obj).addClass('editremove');

                    dados2 = {inicio: $('#data_inicio_rec').val(), fim:$('#data_fim_rec').val(), data_voltar:$('#data_voltar').val()}; 
                    setTimeout(function(){ $(obj).addClass('anima');}, 10);
                    setTimeout(function(){ $(obj).removeClass('editremove');}, 20);                 
                    setTimeout(function(){ $(obj).hide('slow');}, 400); 
                    setTimeout(function(){ $(obj2).hide();}, 400);   

                    setTimeout(function(){
                        $.get(appUrl+'/'+modulo+'/add/add_horas-0', dados2, function(retorno2){
                           // console.log(retorno2);
                            $('#card_horas').html('');   
                            $('#card_horas').html(retorno2);   
                            verificarhoras();                    
                        });
                    }, 800);  
                   
                }                             
            });
        }
    }
    
    
</script>