dashboard = {
  cores: function() {
  var cores = ['ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
          'df7f7a','c3d278','adb2dc','7f3624','4ee524','e56f5d','86efaa','5d2221','bd2a16','5660b3',
          '860cff','9ba6c5','ede1e0','cb89d9','00a2ff','e5d524','ffe0f1','721c53','8d9919','dbf000',
          '014d92','629dd3','19c3d2','3d7479','7ff2b3','269457','31ee1e','ddee1e','e2bd27','e68733',
          '91b9ba','e9d9d8','aaa5a4','f2dbd5','aa513c','6b667a','007ead','dde8f1','006896','006896',
          'ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
          'df7f7a','c3d278','adb2dc','7f3624','4ee524','e56f5d','86efaa','5d2221','bd2a16','5660b3',
          '860cff','9ba6c5','ede1e0','cb89d9','00a2ff','e5d524','ffe0f1','721c53','8d9919','dbf000',
          '014d92','629dd3','19c3d2','3d7479','7ff2b3','269457','31ee1e','ddee1e','e2bd27','e68733',
          '91b9ba','e9d9d8','aaa5a4','f2dbd5','aa513c','6b667a','007ead','dde8f1','006896','006896',
          'ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
          'df7f7a','c3d278','adb2dc','7f3624','4ee524','e56f5d','86efaa','5d2221','bd2a16','5660b3',
          '860cff','9ba6c5','ede1e0','cb89d9','00a2ff','e5d524','ffe0f1','721c53','8d9919','dbf000',
          '014d92','629dd3','19c3d2','3d7479','7ff2b3','269457','31ee1e','ddee1e','e2bd27','e68733',
          '91b9ba','e9d9d8','aaa5a4','f2dbd5','aa513c','6b667a','007ead','dde8f1','006896','006896'];
    return cores;
  },

  tamanhotexto: function(idpont){
    var xx = '20%';
    var size = '22pt';
    if(idpont.toString().length == 1){xx = '35%'; size = '25pt'}
    if(idpont.toString().length == 2){xx = '32%'; size = '24pt'}
    if(idpont.toString().length == 3){xx = '25%'; size = '23pt'}
    if(idpont.toString().length == 4){xx = '18%'; size = '22pt'}
    if(idpont.toString().length == 5){xx = '16%'; size = '20pt'}  
    return {'xx': xx, 'size':size}
  },

  tempxml: function(fillColor, tamanhotextox, tamanhotexto, pontid ){
      return ['<?xml version="1.0"?>',
      '<svg width="26px" height="26px" viewBox="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">',                        
      '<circle  stroke-width="4" stroke="#000" fill="'+fillColor+'" opacity="0.8" cx="50%" cy="50%" r="40"/>',
      '<text x="'+tamanhotextox+'" y="60"  font-size="'+tamanhotexto+'" font-family="Tahoma"  fill="#000">'+pontid+'</text>',                        
      '</svg>'
      ].join('\n');    
  },

  eventomapa: function(request){
    $.get(request.appUrl+'/home/getpoints/local/', request.basefiltro, function(dados2){   
        let cont = 0;
        let nomeTcontrato = '';
        let nomeCliente = '';
        let nomeContrato = '';
        let contentString = '<div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">';
            contentString += '<img src="'+request.assetpaper+'/img/pinsombra.png" style="float:left; margin-right: 10px"> <span class="titulocard">' 
            + request.nomeLocal +'<br/> '+ request.address + request.bairro + ' - '+ request.cidade 
            + '</span><br/><br/>';    
                                    
        $.each(dados2, function(key, point2){
            cont = cont+1; 
            let show = '';
            let expanded = false;
            let collapsed = 'collapsed';
            if(cont ==1){show = 'show'; expanded = true; collapsed = '';}                                
            if(nomeTcontrato !== point2.nomeTcontrato){
                if(cont !== 1){
                    contentString +=
                        '</div>'+ 
                    '</div>'+
                '</div>';
                }
                contentString +=
                '<div class="card card-plain">'+                                
                    '<div class="card-header" role="tab" id="cardunico'+point2.id+'" style="border:none">'+
                    ' <a  data-toggle="collapse" data-parent="#accordion" href="#collapse'+point2.id+'" aria-expanded="'+expanded+'" aria-controls="collapse'+point2.id+'" class="titulocard '+collapsed+'" style="border:none;">'+
                        '' + point2.nomeTcontrato +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="text-shadow:initial" class="nc-icon nc-minimal-down"></i>'+
                        '</a>'+
                    '</div>'+
                    '<div id="collapse'+point2.id+'" class="collapse '+show+'" role="tabpanel" aria-labelledby="cardunico'+point2.id+'" style="padding:0; border:none">'+
                        '<div class="card-body" style="padding:0; padding-top: 10px; padding-bottom: 20px; border:none">';
                        if(nomeCliente !== point2.nomeCliente){
                            contentString += '<div style="margin-top: 10px"><span class="titulocard" >Cliente</span><span class="textocard" >' + point2.nomeCliente + '</span><br/></div>'; 
                        }
                        if(nomeContrato !== point2.nomeContrato){
                            contentString += '<span class="titulocard">Contrato:</span><span class="textocard">' + point2.nomeContrato + ' ' + point2.codigoContrato +'</span><br/>';
                        }
                        contentString +=  '<buttom type="buttom" class="btn btn-outline-primary btn-round btn-sm btcam2" style="padding: 5px; border-radius: 20px; padding-right: 10px; margin-top: 10px; padding-left: 10px; font-size: 10px;" target="_blank" data-toggle="modal" data-target="#myModal2" onclick="ver_ois('+point2.id+')" >'
                        contentString +=  '<i class="nc-icon nc-zoom-split" ></i> Ver OIS '+point2.id+'</buttom>';
            }else{
                        if(nomeCliente !== point2.nomeCliente){
                            contentString += '<div style="margin-top: 10px"><span class="titulocard" >Cliente</span><span class="textocard" >' + point2.nomeCliente + '</span><br/></div>'; 
                        }
                        if(nomeContrato !== point2.nomeContrato){
                            contentString += '<span class="titulocard">Contrato:</span><span class="textocard">' + point2.nomeContrato + ' ' + point2.codigoContrato +'</span><br/>';
                        }
                        contentString +=  '<buttom type="buttom" class="btn btn-outline-primary btn-round btn-sm btcam2" target="_blank" data-toggle="modal" data-target="#myModal2" onclick="ver_ois('+point2.id+')" ><i class="nc-icon nc-zoom-split" ></i> OIS '+point2.id+'</buttom>';
            }
            if(cont == dados2.length){
                contentString +=
                        '</div>'+ 
                    '</div>'+
                '</div>';
            }
            nomeTcontrato = point2.nomeTcontrato;
            nomeCliente = point2.nomeCliente;
            nomeContrato = point2.nomeContrato;            
        });
        contentString +='</div>';
        request.infowindow.setContent(contentString);
        request.infowindow.open( request.map, request.marker);        
    }); 
  }

};
