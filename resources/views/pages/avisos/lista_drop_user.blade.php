<style>.hid_mem{display: none};</style>
@foreach($dados_lista as $key => $value)

<a class="dropdown-item item-aviso" data-toggle="modal" data-target="#myModal_aviso" href="#">
    <p class="avtiti"> {{$value->titulo}} </p>
    <div class="avmen"> {!!$value->mensagem!!}</div>
    <div class="hid_mem" >{!!$value->mensagem!!}</div>
</a>

@endforeach

<script>

        $( ".avmen" ).each(function( index ) {
            var avmen = $(this);
            avmen.text(avmen.text().substring(0,100)+'...');
        });

    $(".item-aviso").click(function(e) {           
        e.preventDefault(); 
        avtiti =  $(this).children( ".avtiti" ).html();
        avmen =  $(this).children( ".hid_mem" ).html();
        $('.avtiti_mod').html(avtiti);
        $('.avmen_mod').html(avmen);        
    });
</script>