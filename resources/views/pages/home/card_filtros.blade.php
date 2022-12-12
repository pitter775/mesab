
<style>
    
</style>

  @if(Auth::user()->perfil == 2)
    <div class="col-md-4" >
        <div class="md-form">
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="usuario" id="usuario" >
                <option value="" disabled selected></option>                                            
                <option value="">Selecione...</option>                                            
                @foreach($usuarios as $key => $value)
                    @if(isset($filtros['usuario']))
                        <option value="{{$value->id ?? ''}}" selected>{{$value->name ?? ''}}</option>   
                        @else
                        <option value="{{$value->id ?? ''}}">{{$value->name ?? ''}}</option>                            
                        @endif                         
                @endforeach                                                     
            </select> 
            <label for="usuario" class="active"><i class="fas fa-users" style="color: #444; margin-right: 5px"></i>  Usuários</label>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="md-form">                                
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="funcao" id="funcao" >
                <option value="" disabled selected></option>  
                <option value="">Selecione...</option>                                                
                @foreach($funcaos as $key => $value)
                    @if(isset($filtros['funcao']))
                    <option value="{{$value->id ?? ''}}" selected>{{$value->fndescricao ?? ''}}</option>
                    @else
                    <option value="{{$value->id ?? ''}}">{{$value->fndescricao ?? ''}}</option>
                    @endif
                @endforeach                                                     
            </select> 
            <label for="funcao" class="active"> <i class="far fa-address-book" style="color: #444; margin-right: 5px"></i>  Funções</label> 
        </div>
    </div>

    <div class="col-md-4">
        <div class="md-form">                                
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="departamento" id="departamento" >
                <option value="" disabled selected></option>     
                <option value="">Selecione...</option>                                             
                @foreach($departamentos as $key => $value)
                    @if(isset($filtros['departamento']))
                    <option value="{{$value->id ?? ''}}" selected>{{$value->depnome ?? ''}}</option>
                    @else
                    <option value="{{$value->id ?? ''}}">{{$value->depnome ?? ''}}</option>
                    @endif
                @endforeach                                                     
            </select> 
            <label for="departamento" class="active"> <i class="fas fa-graduation-cap" style="color: #444; margin-right: 5px"></i>  Departamentos</label> 
        </div>
    </div>

                          
  @endif


    <div class="col-md-4">
        <div class="md-form">                                
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="contrato" id="contrato" >
                <option value="" disabled selected></option>  
                <option value="">Selecione...</option>                                                
                @foreach($contratos as $key => $value)
                    @if(isset($filtros['contrato']))
                    <option value="{{$value->id ?? ''}}" selected>{{$value->ctnumero ?? ''}} - {{$value->ctnome ?? ''}}</option>
                    @else
                    <option value="{{$value->id ?? ''}}">{{$value->ctnumero ?? ''}} - {{$value->ctnome ?? ''}}</option>
                    @endif
                @endforeach                                                     
            </select> 
            <label for="contrato" class="active"> <i class="fas fa-briefcase" style="color: #444; margin-right: 5px"></i>  Contratos</label>
        </div>
    </div>
    {{-- <div class="col-md-4">
        <div class="md-form">                                
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="produto" id="produto" >
                <option value="" disabled selected></option>   
                <option value="">Selecione...</option>                                              
                @foreach($produtos as $key => $value)
                    @if(isset($filtros['produto']))
                    <option value="{{$value->id ?? ''}}" selected>{{$value->prdescricao ?? ''}}</option>
                    @else
                    <option value="{{$value->id ?? ''}}">{{$value->prdescricao ?? ''}}</option>
                    @endif
                @endforeach                                                     
            </select> 
            <label for="produto" class="active"> <i class="fas fa-shield-alt" style="color: #444; margin-right: 5px"></i>  Produtos</label> 
        </div>
    </div> --}}
    <div class="col-md-4">
        <div class="md-form" >                                
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="atividade" id="atividade" >
                <option value="" disabled selected></option>   
                <option value="">Selecione...</option>                                               
                @foreach($atividades as $key => $value)
                    @if(isset($filtros['atividade']))
                    <option value="{{$value->id ?? ''}}" selected>{{$value->atdescricao ?? ''}}</option>
                    @else
                    <option value="{{$value->id ?? ''}}">{{$value->atdescricao ?? ''}}</option>
                    @endif
                @endforeach                                                     
            </select> 
            <label for="atividade" class="active"> <i class="fas fa-snowboarding" style="color: #444; margin-right: 5px"></i>  Atividades</label> 
        </div>
    </div>
    
    {{-- <div class="col-md-8">
        <div class="md-form">                                
            <select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form" name="empreendimento" id="empreendimento" >
                <option value="" disabled selected></option>     
                <option value="">Selecione...</option>                                             
                @foreach($empreendimentos as $key => $value)
                    @if(isset($filtros['empreendimento']))
                    <option value="{{$value->id ?? ''}}" selected>{{$value->epdescricao ?? ''}}</option>
                    @else
                    <option value="{{$value->id ?? ''}}">{{$value->epdescricao ?? ''}}</option>
                    @endif
                @endforeach                                                     
            </select> 
            <label for="empreendimento" class="active"> <i class="far fa-building" style="color: #444; margin-right: 5px"></i>  Empreendimentos</label> 
        </div>
    </div> --}}

    <div class="col-md-12">
        <button type="submit" class="btn btn-outline-primary btn-sm btn-rounded waves-effect "><i class="fas fa-search"></i> Filtrar</button>                                                                     
        <button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect btlimpar"><i class="fas fa-broom"></i> Limpar</button>
    </div> 

    @if(Auth::user()->perfil == 0)
        <!-- <div id="card_user"></div> -->
    @endif




<script>
    $('.dvfiltros').hide();
    $(document).ready(function () {
        $('.mdb-select').materialSelect();     
        $('.form-control').trigger("change");
        $('.dropdown-content, .select-dropdown').perfectScrollbar(); 
        $('.dvfiltros').show();        
    });

</script>