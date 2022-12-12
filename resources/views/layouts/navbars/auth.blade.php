<div class="sidebar animation-area"> 
  
    <div class="divfiltro anima"> </div>
    <div class="logo">
        <a href="" class="simple-text logo-mini">
            <!-- <img class="avatar border-gray" src="{{ asset('/paper/img/avatar.png') }}" alt="..."> -->
            <img class="avatar border-gray" src="{{ asset('paper') }}/img/timesheet.png" style="width: 30px; margin-right: 20px">
        </a>
        <!-- <a href="" class="simple-text logo-normal" style="font-size: 10px;  color:#222">{{ __(auth()->user()->name)}}</a>        -->
        <a href="" class="simple-text logo-normal" style="font-size: 12px;  color:#222"> <img class="avatar border-gray" src="{{ asset('paper') }}/img/timesheet.png" style="width: 20px; margin-right: 5px"> Diário de Ativos</a>       
    </div>
    <div class="sidebar-wrapper" >
        <ul class="nav">
            <?php
                //Controle de acesso ao menu
                use Illuminate\Support\Facades\Auth;
                $menu = 'menu_consulta';
                // $menu_adm = ['usuarios','criacao','clientes','contratos','produtos','atividades','alocacoes','tarifas'];
                // $menu_consulta = ['horas'];
            
                $acesso = Auth::user()->perfil;
                
                if($acesso == 2){$menu =  'menu_adm';}             
                if($acesso == 0){$menu =  'menu_consulta';}
                if($acesso == 1){$menu =  'menu_consulta';}
            ?>   
            
          
            <li class="{{ $elementActive == 'criacao' ? 'active' : '' }}" @if( $menu ==  'menu_consulta') style="display:none" @endif>
                <a data-toggle="collapse" href="#pagesExamples" aria-expanded="false" class="{{ $elementActive == 'criacao' ? '' : 'collapse' }}" >
                    <i class="far fa-copy"></i>
                    <p>Criação<b class="caret" style="margin-top: -15px; right: -20px"> <i style="font-size: 15px;" class="fas fa-angle-down fa-xs"></i> </b></p>
                </a>
                <div class="collapse {{ $elementActive == 'criacao' ? 'show' : '' }}" id="pagesExamples" >
                    <ul class="nav">
                        
                        <li class="{{ $elementActive2 == 'atividades' ? 'active' : '' }}">
                            <a href="/atividades">
                                <span class="sidebar-mini-icon"><i class="fas fa-snowboarding"></i></span>
                                <span class="sidebar-normal"> Atividades </span>
                            </a>
                        </li>
                        <li class="{{ $elementActive2 == 'contratos' ? 'active' : '' }}">
                            <a href="/contratos">
                                <span class="sidebar-mini-icon"><i class="fas fa-briefcase"></i></span>
                                <span class="sidebar-normal"> Contratos </span>
                            </a>
                        </li>
                        <li class="{{ $elementActive2 == 'departamentos' ? 'active' : '' }}">
                            <a href="/departamentos">
                                <span class="sidebar-mini-icon"><i class="fas fa-graduation-cap"></i></span>
                                <span class="sidebar-normal"> Departamentos </span>
                            </a>
                        </li>

                        <li class="{{ $elementActive2 == 'feriados' ? 'active' : '' }}">
                            <a href="/feriados">
                                <span class="sidebar-mini-icon"><i class="fas fa-calendar-check"></i></span>
                                <span class="sidebar-normal"> Feriados </span>
                            </a>
                        </li> 
                        
                        <li class="{{ $elementActive2 == 'funcaos' ? 'active' : '' }}">
                            <a href="/funcaos">
                                <span class="sidebar-mini-icon"><i class="far fa-address-book"></i></span>
                                <span class="sidebar-normal"> Funções </span>
                            </a>
                        </li>
                        <li class="{{ $elementActive2 == 'avisos' ? 'active' : '' }}">
                            <a href="/avisos">
                                <span class="sidebar-mini-icon"><i class="far fa-envelope"></i></span>
                                <span class="sidebar-normal"> Mensagens </span>
                            </a>
                        </li>
                     
                        <li class="{{ $elementActive2 == 'tarifas' ? 'active' : '' }}">
                            <a href="/tarifas">
                                <span class="sidebar-mini-icon"><i class="fas fa-dollar-sign"></i></span>
                                <span class="sidebar-normal"> Tarifas </span>
                            </a>
                        </li> 
                        @if(Auth::user()->id !== 214 )
                        <li class="{{ $elementActive2 == 'usuarios' ? 'active' : '' }}">
                            <a href="/usuarios">
                                <span class="sidebar-mini-icon"><i class="fas fa-users"></i></span>
                                <span class="sidebar-normal"> Usuários </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'relacionamentos' ? 'active' : '' }}" @if( $menu ==  'menu_consulta') style="display:none" @endif>
                <a data-toggle="collapse" href="#pagesExamples2" aria-expanded="false" class="{{ $elementActive == 'relacionamentos' ? '' : 'collapse' }}">
                    <i class="fas fa-code-branch"></i>
                    <p>
                            Relacionamentos
                        <b class="caret" style="margin-top: -15px; right: -20px"> <i style="font-size: 15px;" class="fas fa-angle-down fa-xs"></i> </b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'relacionamentos' ? 'show' : '' }}" id="pagesExamples2">
                    <ul class="nav">
                       
                        <li class="{{ $elementActive2 == 'departamento_atividade' ? 'active' : '' }}">
                            <a href="/departamento_atividade">
                                <span class="sidebar-mini-icon"><i class="fas fa-sitemap"></i></span>
                                <span class="sidebar-normal"> Departamento <b>></b> Atividade </span>
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            

            <li class="{{ $elementActive == 'home' ? 'active' : '' }}">
                <a href="/home">             
                    <i class="far fa-chart-bar"></i>
                    <p>Home</p>
                </a>
            </li>
           
            <li class="{{ $elementActive == 'horas' ? 'active' : '' }}">
                <a href="/horas">
                <i class="far fa-clock"></i>
                    <p>Adicionar Horas</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'meuscontratos' ? 'active' : '' }}" >
                <a href="/meuscontratos">
                <i class="fas fa-briefcase"></i>
                    <p>Meus Contratos</p>
                </a>
            </li> 
      
        </ul>        
    </div>
    <ul class="box-area">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
	</ul>

    
</div>


