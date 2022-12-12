<div class="card">
    <div class="card-header">                                   
        <h5 style="margin-top: -5px;"><i class="fas fa-snowboarding"></i> Atividades </h5>
        <ul class="navint">
            <li data-id="Todos" class="ativo btnavintat">Tudo</li>
            @foreach($lista_prod as $key => $value)
                <li data-id="{{$value->id}}" class="btnavintat">{{$value->prdescricao}}</li>
            @endforeach
        </ul>
    </div>

              
