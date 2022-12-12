
<?php


use Illuminate\Support\Facades\Auth;

use PhpParser\Node\Stmt\Else_;

function horas_segundos($total){
  $horas = floor($total / 3600);
  $minutos = floor(($total - ($horas * 3600)) / 60);
  $segundos = floor($total % 60);
  if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
  if(strlen($horas) == 1){ $horas = '0'.$horas;}
  return $horas . ":" . $minutos;
}


function converte_segundos($tempo){
  $segundos = 0;
  list( $h, $m, $s ) = explode( ':', $tempo ); 
  $segundos += $h * 3600; 
  $segundos += $m * 60;
  $segundos += $s;
  return $segundos;
}

function converte_em_horas($segundos){
  $horas = floor( $segundos / 3600 ); //converte os segundos em horas e arredonda caso nescessario
  $segundos %= 3600; // pega o restante dos segundos subtraidos das horas
  $minutos = floor( $segundos / 60 );//converte os segundos em minutos e arredonda caso nescessario
  $segundos %= 60;// pega o restante dos segundos subtraidos dos minutos
  return $horas.':'.$minutos;
}
?>
<style>

</style>
<div class="card card-calendar" data-aos="fade-left" data-aos-delay="0">  
    <div class="card-body">   
            
        <div id='fullCalendar'></div>
        <img src="{{ asset('paper') }}/img/seta_baixo.gif" class="setabaixo">

    </div>                    
</div>     

<script>
  
  var appUrl ="{{env('APP_URL')}}";
  var modulo = 'horas';
  if( document.readyState !== 'loading' ) {
          myInitCode();
  } else {
      document.addEventListener('DOMContentLoaded', function () {
          myInitCode();
      });
  }

  function myInitCode(){ 
    var data_inicial = new Date();
    if($('#data_voltar_calend').val()){
      data_inicial = $('#data_voltar_calend').val();
    }
    var calendarEl = document.getElementById('fullCalendar');     
    var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      center: '',
      left: 'title',   
      right: 'prevYear,prev,next,nextYear today'
    },
    buttonText: {
        today: "Hoje"
    },
    navLinks: true, // can click day/week names to navigate views
    businessHours: true, // display business hours
    editable: false,
    navLinks: true,
    selectable: true,
    weekends: false,
    height: "auto",
    selectLongPressDelay: 0,
    initialDate: data_inicial,
    events: [

      <?php
      function dias_periodo($inicio, $fim){
        $mes = 0;
        $dateRange = array(); // dias do periodo selecionado
        while($inicio <= $fim){  
            $mes = $inicio->format('m');  
            $dateRange[] = $inicio->format('Y-m-d');
  
            if($inicio->format('N') > 5 ){
              return 5;
            }
            $inicio = $inicio->modify('+1day');           
             if($fim->format('m') !== $mes ){
              return 5;
             }
            
        }
        return $dateRange;
      }
      foreach($dados_calendario as $key => $value){

        //dd($value->datainicio);
        $horas = horas_segundos($value->horas);
       
        $datetime1 = new DateTime($value->datainicio.' 00:00:00');
        $datetime2 = new DateTime($value->datafim.' 23:00:00');
        $interval = $datetime1->diff($datetime2);

        $dateRange = dias_periodo($datetime1, $datetime2);

        $contr = 0;
        $total_horas = '0';
        if (is_array($dateRange) || is_object($dateRange)){            
          foreach ($dateRange as $data){
         
            $soma = true;
            foreach($dados_lista as $fer){
     
              if($fer->fn_data == $data){     
                      
                if($fer->horas){                   
                  
                    if($fer->horas_user != 0){
                      $feriado_user = null;
                    }else{
                      $contr = $contr +1;  
                      $total_horas =  $total_horas + converte_segundos($fer->horas);
                      $soma = false;
                    }              
                
                }              
              }
            }
           
           
            if($soma){
              $total_horas =  $total_horas + converte_segundos('08:00:00');
            }

          }
        }


        $total_horas = horas_segundos($total_horas);
        // if($value->datainicio == '2021-10-14'){
        //   //dd($horas); // 25:30
        //   //dd($total_horas); // 200:00
        //   //dd($datass);
        // }

        $class = 'datafalse';
        $addhoras = '';
        if($total_horas === $horas){
          $class = 'datatrue';  
          $addhoras =  $horas;  

        }else{
          $addhoras =  $horas. ' de '.$total_horas; 
        }
        $script ='{
                  title: "'.$addhoras.' hs"'.',
            description: "';

           foreach($dados_calendario_atividade as $key2 => $value2){
             if($value->datainicio == $value2->datainicio){ 
                if($value->datainicio == $value2->datainicio){ 
                  $somasegundos = '0';
                 }
                  $somasegundos = converte_segundos($value2->horas); 
                  $script .= ' • '.converte_em_horas($somasegundos).'hs '.$value2->atdescricao;  
                  $atividade = $value2->atividades_id;   
             }
          }

           
          $script .='",
                start : "'.$value->datainicio.' 11:30:00" ,  
                   end: "'.$value->datafim.' 11:50:00",
            classNames: "'.$class.'", 
                 },';
          echo $script;
      } 
      foreach($dados_lista as $key => $value){


        if($value->feriados_tipos_id == 9){
          $class = 'dataHoras';
          if($value->horas_user == 1){
            foreach($dados_fer_user as $key => $user){
              if($value->id == $user->feriados_id ){
                if($user->users_id == Auth::user()->id){
                  echo "{
                    title: 'Preencher $value->horas ',
                     hora: '0',
              description: '$value->fn_descricao',     
                    start: '$value->fn_data 11:33:00',
                      end: '$value->fn_data 11:50:00',
                          
              classNames: '$class', 
                    },";
                }
              }

            }
            
          }else{
          echo "{
                  title: 'Preencher $value->horas ',
                   hora: '0',
            description: '$value->fn_descricao',     
                  start: '$value->fn_data 11:33:00',
                    end: '$value->fn_data 11:50:00',
                        
            classNames: '$class', 
                  },";
          }

        }
        
        elseif($value->feriados_tipos_id == 8){
          $class = 'dataferiado';
          echo "{
                  title: 'Emenda de feriado',
                   hora: '0',
            description: '$value->fn_descricao',     
                  start: '$value->fn_data 11:33:00',
                    end: '$value->fn_data 11:50:00',
                        
            classNames: '$class', 
                  },";
         
        }else{
          $class = 'dataferiado';
          echo "{
                  title: 'Feriado',
                   hora: '0',
            description: 'Feriado de $value->fn_descricao',     
                  start: '$value->fn_data 11:33:00',
                    end: '$value->fn_data 11:50:00',
                        
            classNames: '$class', 
                  },";
        }

      } 
      foreach($dados_ferias as $key => $value){
            if($value->status == 1){
              $class = 'dataferias';
              if($value->contrato == 'PJ'){
                $textofer = 'Periodo de Ausência';
              }
              if($value->contrato == 'CLT'){
                $textofer = 'Periodo de Férias';
              }
              
            }else{
              $class = 'dataferias_pend';
              if($value->contrato == 'PJ'){
                $textofer = 'Periodo de Solicitação de Ausência';
              }
              if($value->contrato == 'CLT'){
                $textofer = 'Periodo de Solicitação de Férias';
              }
            }
         
          echo "{
                  title: '$textofer',
            description: 'Período de Ausências',     
                  start: '$value->datainicio 11:33:00',
                    end: '$value->datafim 11:50:00',
                        
            classNames: '$class', 
                  },";
      }
      foreach($dados_atestados as $key => $value){
        $datafim = '';
        if($value->tipo == 'dias'){
          $datafim =$value->datafim;
        }
        if($value->tipo == 'horas'){
          $datafim =$value->datainicio;
        }

        if($value->status == 1){
          $class = 'dataferias'; 
        }else{
          $class = 'dataferias_pend';     
        }
     
        echo "{
              title: 'Atestado Médico',
        description: 'Atestado Médico',     
              start: '$value->datainicio 11:33:00',
                end: '$datafim 11:50:00',
                    
        classNames: '$class', 
              },";
      } 
      ?>
      
    ],  


      eventDidMount: function(info) {
      var tooltip = new Tooltip(info.el, {
        title: info.event.extendedProps.description,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    },
    <?php
     if(!$chamada){
    ?>
      eventClick: function(info) {
        console.log('eventClick');

        var retorno = info.event.title.split(" ");
        if(info.event.title !== 'Feriado' && info.event.title !== 'Periodo de Ausência' && retorno[0] !== 'Preencher'){
          if(info.event.hora !== '0'){
            console.log('sim');
            inicio = info.event.start;
            fim = info.event.end;
            data = [dataAtualFormatada(inicio), dataAtualFormatada(fim)];
            dados_select = {inicio:dataAtualFormatada(inicio), fim:dataAtualFormatada(fim), evento:'eventClick'};
            console.log(dados_select);
            $.get(appUrl+'/'+modulo+'/permissao_selecao', dados_select, function(retorno){
              if(retorno == 0){
                add_atividade(data,'1');
              }else{
                demo.showNotification('top','center', 'danger', 'Seleção não permitida!');
              }
            });
            
          }          
        }
        console.log('nao');
      },
      eventMouseEnter: function(info){
      //  console.log(info);
      },
      function( eventMouseEnter ) { 
      //  console.log(info);
      },
      select: function(info) {
        console.log('eventClick');
      //  console.log('info');
        console.log(info.endStr);
        dados_select = {inicio:info.startStr, fim:info.endStr, evento:'selecao'};
        $.get(appUrl+'/'+modulo+'/permissao_selecao', dados_select, function(retorno){
          //console.log(retorno);
          if(retorno == 0){
             data = [info.startStr, info.endStr];
            add_atividade(data);
          }else{
            demo.showNotification('top','center', 'danger', 'Seleção não permitida!');
          }
        });
      },
      navLinkDayClick: function(date, jsEvent) {
        console.log('navLinkDayClick');
        

        var data_inicio = new Date(date.toISOString());
        let data_inicio_ok = ((data_inicio.getFullYear() )) + "-" + ((data_inicio.getMonth() + 1)) + "-" + data_inicio.getDate();
        let data_fim_ok = ((data_inicio.getFullYear() )) + "-" + ((data_inicio.getMonth() + 1)) + "-" + ((data_inicio.getDate()+1));

        console.log(data_fim_ok);
        dados = {inicio: data_inicio_ok, fim:data_inicio_ok, data_voltar:formatDate(data_inicio_ok)}; 
        dados_select = {inicio:data_inicio_ok, fim:data_fim_ok, evento:'clickdia'};
        $.get(appUrl+'/'+modulo+'/permissao_selecao', dados_select, function(retorno){
          if(retorno == 0){            
            $( ".card-calendar" ).hide();
            $( ".card_lista_cale" ).hide();
            setTimeout(function(){ 
              $.get(appUrl+'/'+modulo+'/add/add_horas-1', dados, function(retorno){
                $('#card_horas').html(retorno);
                  $.get(appUrl+'/'+modulo+'/add/lista_horas-1', dados, function(retorno){
                    $('#card_horas_lista').html(retorno);
                  });
              });
            }, 200); 

          }else{
            demo.showNotification('top','center', 'danger', 'Seleção não permitida!');
          }
        });
      }
      <?php } ?>

    });
    var eventSource = calendar.getEventSourceById('a');
    calendar.setOption('locale', 'pt-br');
    calendar.render();
  }

function add_atividade(datas, evento = '0'){
  $('#card_horas').html('<div data-aos=zoom-in data-aos-delay=0>'+load+'</div>');
  $('#card_horas_lista').html('<div data-aos=zoom-in data-aos-delay=0>'+load+'</div>');
  aos_init();
  var data_inicio = new Date(datas[0]+ ' 22:22:22');
  var data_fim = new Date(datas[1]+ ' 22:32:22');
  if(evento !== '1'){
    data_fim.setDate(data_fim.getDate()-1);
  }
  let data_inicio_ok = ((data_inicio.getFullYear() )) + "-" + ((data_inicio.getMonth() + 1)) + "-" + data_inicio.getDate();
  let data_fim_ok = ((data_fim.getFullYear() )) + "-" + ((data_fim.getMonth() + 1)) + "-" + data_fim.getDate();
  dados = {inicio: data_inicio_ok, fim:data_fim_ok, data_voltar:datas[0]}; 
  $( ".card-calendar" ).hide();
  $( ".card_lista_cale" ).hide();
  $.get(appUrl+'/'+modulo+'/add/add_horas-1', dados, function(retorno){
    console.log('atividade add');
    $('#card_horas').html(retorno);
    $.get(appUrl+'/'+modulo+'/add/lista_horas-1', dados, function(retorno){
        $('#card_horas_lista').html(retorno);
    });
  });
}

function calendario_atual(event){
  data_atual = formatDate(event.activeRange.end);
  
  // dados = {data_atual: data_atual};  
  <?php
     if($chamada){
      // dados = {usuario: user}; 
        echo 'dados = {data_atual: data_atual, usuario: '.$chamada.'};';
      }else{
        echo 'dados = {data_atual: data_atual};';
      }
    ?>

  $.get(appUrl+'/'+modulo+'/add/lista_mes_atual-0', dados, function(retorno){
      $('#mesatual').html(retorno);
      
      $('#cardnome').html('<h5><?php echo $nomeuser ?></h5>');
      $.get(appUrl+'/'+modulo+'/add/lista_ano_atual-0', dados, function(retorno2){
          $('#anoatual').html(retorno2);
      });
  });
}
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
    return [year, month, day].join('-');
}
function dataAtualFormatada(data){    
        var dia  = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0'+dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0'+mes : mes,
        anoF = data.getFullYear();
    return anoF+"-"+mesF+"-"+diaF;
}


</script>