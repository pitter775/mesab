<?php

namespace App\Http\Controllers;

use App\Models\Contrato_user;
use App\Models\Evento;
use App\Models\Feriado_users;
use App\Models\Funcao;
use App\Models\Tarifa;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use PDOException;


class HorasController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      if(Auth::user()->id == 214){
        return redirect('/home');
      }
      return view("pages.horas.index");
    }
    

    public function horasOk(Request $request){
      $start = new Carbon('first day of last month');
      $end = new Carbon('last day of last month');      
      $dias_periodo = $this->dias_periodo_ok($start, $end); 
      $trofeu = false;

        //dd($dias_periodo);
      // $quant_feriados = $this->dias_sem_feriados($dias_periodo);
      $total_dias = count($dias_periodo);
      $total_horas = $total_dias * 8;
      $total_horas = $total_horas .':00:00';
      $total_segundos = $this->converte_segundos($total_horas);
      $segundos_user =  $this->horasuser( $dias_periodo[0], end($dias_periodo));
      if($total_segundos <= $segundos_user){
        $trofeu = true;
        return $trofeu;
      }

      return $trofeu;

  }
    public function horasuser($data_inicio, $data_fim){
      $filtro = '';
      $and = '';
      $and_or = 'AND';
      $user = Auth::user()->id;


      if($data_inicio != null){
        if($filtro != null){ $and = ' AND';}
        if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
        $filtro .=" $and $where periodos.datainicio BETWEEN '$data_inicio' AND '$data_fim'";
      }
      if($data_fim != null){
          if($filtro != null){ $and = ' AND';}
          if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
          $filtro .=" $and $where periodos.datafim BETWEEN '$data_inicio' AND '$data_fim'";
      }
      if($user != null){
          if($filtro != null){ $and = ' AND';}
          if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
          $filtro .=" $and $where users.id = '$user' ";
      }
     
      $lista_usuarios = DB::select( DB::raw(
        "SELECT users.id , users.name, users.email, sum( time_to_sec (e.horas)) as total
        FROM eventos As e
          LEFT JOIN users ON users.id = e.users_id
          LEFT JOIN periodos ON periodos.id = e.periodos_id
          $filtro"            
        ));
    
        return $lista_usuarios[0]->total;
    }

    public function dias_sem_feriados($dias){
        $dados_feriados = DB::table('feriados AS u')
        ->join('feriados_tipos', 'feriados_tipos.id', 'u.feriados_tipos_id')
        ->where('u.feriados_tipos_id', '!=' , 9)
        ->whereIn('u.fn_data', $dias)      
        ->select('*', 'u.id AS id')
        ->count();
      return $dados_feriados;
    }
    public function add_card($card,Request $request){
      $cards = explode("-", $card);
      $anima_create = $cards[1] == 1?'data-aos=fade-left data-aos-delay=0':'';  
      $anima_lista = $cards[1] == 1?'data-aos=fade-left data-aos-delay=0':'';  

      switch ($cards[0]) {
        case 'lista':               
            return $this->add_lista($anima_lista, $request);
            break;
          case 'lista_horas':               
            return $this->lista_horas($anima_lista,$request);
            break; 
          case 'lista_mes_atual':               
            return $this->lista_mes_atual($anima_lista,$request);
            break;
        case 'lista_ano_atual':               
          return $this->lista_ano_atual($anima_lista,$request);
          break;
          case 'add_horas':               
            return $this->add_horas($anima_create, $request);
            break;
        case 'create':
          return $this->add_create($anima_create, $request);
            break;
        case 'editar_atv':
          return $this->editar_atv($request);
            break;
        case 'add_atv':
          return $this->add_atv($request);
            break;
        case 'remove_atv':
          return $this->remove_atv($request);
            break;
      }      
    }
    function cont_pro($cont_pro_id, $ct, $idatv = null ){
      $cp = DB::table('contrato_produtos AS c')
      ->where([['c.id', $cont_pro_id]])
      ->first();

      if($idatv){
        $nome = DB::table('atividades AS a')
        ->where([['a.id', $idatv]])
        ->first()->atdescricao;
      }
     



      if($ct == 'contrato'){return $cp->contratos_id;}
      if($ct == 'produto'){return $cp->departamentos_id;}      
      if($ct == 'atvnome'){return $nome;}      
    }
    public function add_atv(Request $request){
        $dados = new Contrato_user();
        $dados->users_id = Auth::user()->id; 
        $dados->contratos_id =  $this->cont_pro($request->contproid, 'contrato');
        $dados->departamentos_id = $this->cont_pro($request->contproid, 'produto');
        $dados->atividades_id = $request->ativid;
        $dados->save(); 
        $retorno = [
          'contratos_id'=>$this->cont_pro($request->contproid, 'contrato'), 
          'departamentos_id'=>$this->cont_pro($request->contproid, 'produto'), 
          'atdescricao'=>$this->cont_pro($request->contproid, 'atvnome', $request->ativid), 
          'atividades_id'=>$request->ativid, 
        ];
        return $retorno;
    }   
    public function remove_atv(Request $request){
        $deletar = Contrato_user::where([['contratos_id', $this->cont_pro($request->contproid, 'contrato')],
                                        ['departamentos_id', $this->cont_pro($request->contproid, 'produto')],
                                        ['atividades_id', $request->ativid],
                                        ['users_id', Auth::user()->id],]);
        $deletar->delete();
        $retorno = [
          'contratos_id'=>$this->cont_pro($request->contproid, 'contrato'), 
          'departamentos_id'=>$this->cont_pro($request->contproid, 'produto'), 
          'atdescricao'=>$this->cont_pro($request->contproid, 'atvnome', $request->ativid), 
          'atividades_id'=>$request->ativid, 
        ];
        return $retorno;
    }
    public function editar_atv(Request $request){
        // $teste = $request->card;
        // $dados_lista = DB::table('contrato_users AS c')
        //   ->join('contratos', 'contratos.id', 'c.contratos_id')
        //   ->join('departamentos', 'departamentos.id', 'c.departamentos_id')          
        //   ->join('atividades', 'atividades.id', 'c.atividades_id')          
        //   ->select('*', 'c.id AS id')
        //   ->where([['c.users_id', Auth::user()->id],['contratos.id', $request->contid],['produtos.id', $request->prid] ])
        //   ->get();

        // $contrato_produto = DB::table('contrato_produtos AS c')
        //   ->join('contratos', 'contratos.id', 'c.contratos_id')
        //   ->join('produtos', 'produtos.id', 'c.departamentos_id')
        //   ->select('*', 'c.id AS id')
        //   ->where([['contratos.id', $request->contid],['produtos.id', $request->prid] ])
        //   ->first()->id;

        //   if($contrato_produto){
        //     $cont_prod_atv = DB::table('contrato_produto_atividades AS c')          
        //     ->join('atividades', 'atividades.id', 'c.atividades_id')          
        //     ->select('*', 'c.id AS id')
        //     ->where([['c.contrato_departamentos_id', $contrato_produto]])
        //     ->get();
        //   }

        // return view("pages.horas.edit_prod_lista", compact('dados_lista', 'cont_prod_atv'));
    }
    public function permissao_selecao(Request $request){     

      $data_fim = date('Y-m-d', strtotime("-1 day", strtotime($request->fim)));
      $dateStart 	= $request->inicio;
      $dateStart 	= new DateTime($dateStart);      
      $dateEnd 		= $data_fim;
      $dateEnd 		= new DateTime($dateEnd);
      $dateRange = array();
      $mes = 0;
      $soma = 0;
      while($dateStart <= $dateEnd){    
          $mes = $dateStart->format('m');    
          $dateRange[] = $dateStart->format('Y-m-d');

          if($dateStart->format('N') > 5 ){
            return 5;
          }
          $dateStart = $dateStart->modify('+1day');           
           if($dateEnd->format('m') !== $mes ){
            return 5;
           }          
      }

      //proibir mês retrazado em diante
      $mesanterior =  date('m', strtotime('-4 months', strtotime(date('Y-m-d'))));
      if($dateEnd->format('m') <= $mesanterior){
        $soma = 0;
        if(Auth::user()->perfil == 2){
          $soma = 0;
        }
      }     

      if($request->evento === 'selecao' || $request->evento === 'clickdia' ){  
        $diasUsados = [];
        $segunda = date('Y-m-d', strtotime('monday this week', strtotime($dateRange[0])));
        for ($i = 0; $i <= 5; $i++) {
          $segundamais = date('Y-m-d', strtotime('+'.$i.' days', strtotime($segunda)));
          $varrendo = DB::table('eventos AS u')
          ->join('periodos', 'periodos.id', 'u.periodos_id')     
          ->where([['u.users_id', Auth::user()->id], ['periodos.datainicio', $segundamais]])
          ->get();   

          if(count($varrendo) > 0 ){
            $dateStart 	= new DateTime($varrendo[0]->datainicio);
            $dateEnd 		= new DateTime($varrendo[0]->datafim);   
            $dias_periodo = $this->dias_periodo_ok($dateStart, $dateEnd); 
            $diasUsados = array_merge($diasUsados, $dias_periodo);  
          }      
        }  

        foreach($diasUsados as $day){
          foreach($dateRange as $rage){
            $dayMenos = date('Y-m-d', strtotime('-1 days', strtotime($day)));
            if($dayMenos == $rage){
              $soma = $soma +1;
            }
          }
        }

        $permissao1 = DB::table('eventos AS u')
        ->join('periodos', 'periodos.id', 'u.periodos_id')     
        ->where([['u.users_id', Auth::user()->id]])
        ->whereIn('periodos.datainicio', $dateRange)
        ->get();      

        $permissao2 = DB::table('eventos AS u')
        ->join('periodos', 'periodos.id', 'u.periodos_id')     
        ->where([['u.users_id', Auth::user()->id]])
        ->whereIn('periodos.datafim', $dateRange)
        ->get();    

        $dados_ferias1 = DB::table('ferias AS u')
        ->where([['u.users_id', Auth::user()->id]])
        ->whereIn('u.datainicio', $dateRange)
        ->select('*', 'u.id AS id')
        ->get();
  
        $dados_ferias2 = DB::table('ferias AS u')
        ->where([['u.users_id', Auth::user()->id]])
        ->whereIn('u.datafim', $dateRange)
        ->select('*', 'u.id AS id')
        ->get(); 

        $soma = $soma + count($permissao1) + count($permissao2)+ count($dados_ferias1) + count($dados_ferias2);        
      }   

      return $soma;

    }
    public function lista_mes_atual($anima_lista,$request){
      $user = $request->usuario;
      $chamada = $request->usuario;
      if(!$user){
        $user =  Auth::user()->id;
        $chamada = false;
      }

      $nomeuser = User::where('id',$user)->first()->name;




      // data_atual
      $data_mes = date('m', strtotime($request->data_atual));
      $data_ano = date('Y', strtotime($request->data_atual));

      $horas_banco = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*','u.id As id')
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->whereMonth('periodos.datainicio', '=', $data_mes)
      ->where([['u.users_id', $user]])
      ->get();

      $horas_total = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), DB::raw("CONCAT_WS('-',MONTH(periodos.datainicio), YEAR(periodos.datainicio)) as monthyear"),'u.id As id' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->whereMonth('periodos.datainicio', '=', $data_mes)
      ->where([['u.users_id', $user]])
      ->first();


      $horas_atividades = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id','atividades.atdescricao','u.atividades_id' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->whereMonth('periodos.datainicio', '=', $data_mes)
      ->orderBy('atividades.atdescricao', 'asc')
      ->groupBy('u.atividades_id')
      ->where([['u.users_id', $user]])
      ->get();


      $horas_contratos = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id','contratos.ctnome','u.contratos_id' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->whereMonth('periodos.datainicio', '=', $data_mes)
      ->orderBy('contratos.ctnome', 'asc')
      ->groupBy('u.contratos_id')
      ->where([['u.users_id', $user]])
      ->get();

      $horas_departamentos = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id','departamentos.depnome','u.departamentos_id' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->whereMonth('periodos.datainicio', '=', $data_mes)
      ->orderBy('departamentos.depnome', 'asc')
      ->groupBy('u.departamentos_id')
      ->where([['u.users_id', $user]])
      ->get();


      return view("pages.horas.lista_mes_atual", compact('horas_banco','anima_lista','horas_total','horas_atividades','horas_contratos','horas_departamentos','nomeuser'));
    }
    public function lista_ano_atual($anima_lista,$request){
      $user = $request->usuario;
      $chamada = $request->usuario;
      if(!$user){
        $user =  Auth::user()->id;
        $chamada = false;
      }


      // data_atual
      $data_ano = date('Y', strtotime($request->data_atual));

      $horas_banco = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'),'u.id As id' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->where([['u.users_id', $user]])
      ->groupBy('periodos.datainicio')
      ->get();


      // total de horas por ano
      $horas_total = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), DB::raw("CONCAT_WS('-',MONTH(periodos.datainicio), YEAR(periodos.datainicio)) as monthyear"),'u.id As id' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->where([['u.users_id', $user]])
      ->first();

      $horas_contratos = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id','contratos.ctnome' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->orderBy('contratos.ctnome', 'asc')
      ->groupBy('u.contratos_id')
      ->where([['u.users_id', $user]])
      ->get();

      $horas_departamentos = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id','departamentos.depnome' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->orderBy('departamentos.depnome', 'asc')
      ->groupBy('u.departamentos_id')
      ->where([['u.users_id', $user]])
      ->get();

      $horas_atividades = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id','atividades.atdescricao' )
      ->whereYear('periodos.datainicio', '=', $data_ano)
      ->orderBy('atividades.atdescricao', 'asc')
      ->groupBy('u.atividades_id')
      ->where([['u.users_id', $user]])
      ->get();


      return view("pages.horas.lista_ano_atual", compact('horas_banco','anima_lista','horas_total','horas_contratos','horas_departamentos','horas_atividades'));

      // $data ->select(DB::raw('count(id) as `data`'),DB::raw("CONCAT_WS('-',MONTH(created_at),YEAR(created_at)) as monthyear"))
      // ->groupby('monthyear')
      // ->get();


      // $result = DB::select("select time_to_sec('00:30:00') as seconds");
      // $track_date = '2018-03-01';
      // $total_time = TimeTrack::where('track_date', $track_date)->sum(DB::raw("TIME_TO_SEC(total_time)"));
      
      // ->select('*', DB::raw('sum( u.horas ) as horas'),'u.id As id' )



    }
    function dias_periodo_ok($inicio, $fim){
      $mes = 0;
      $dateRange = array(); // dias do periodo selecionado
      while($inicio <= $fim){  
          $mes = $inicio->format('m');  
          
          $adddias = true;

          if($inicio->format('N') > 5 ){
            $adddias = false;
          }
          $inicio = $inicio->modify('+1day');           
          if($fim->format('m') !== $mes ){
            $adddias = false;
          }
          if($adddias){
            $dateRange[] = $inicio->format('Y-m-d');
          }          
      }
      return $dateRange;
    }

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
    public function add_horas($add_anima, $request){
      $data_voltar = $request->data_voltar; 

      $data_inicio = date('d/m/Y', strtotime($request->inicio));
      $data_fim = date('d/m/Y', strtotime($request->fim));

      $data_inicio_s = date('Y-m-d', strtotime($request->inicio));
      $data_fim_s = date('Y-m-d', strtotime($request->fim));

      $data_inicio_rec = $request->inicio;
      $data_fim_rec = $request->fim;

      $datetime1 = new DateTime($request->inicio.' 00:00:00');
      $datetime2 = new DateTime($request->fim.' 23:00:00');

      $interval = $datetime1->diff($datetime2);

      $dateRange = $this->dias_periodo($datetime1, $datetime2);
      $total_horas = '0';
      $total_horas2 = '02:00:00';

      $contt = 0;
      foreach ($dateRange as $data){
        $soma = true;    
        $contt =  $contt +1;  


        if($soma){
          $total_horas =  $total_horas + $this->converte_segundos('08:00:00');
        }        
      }    
      $total_horas = $this->horas_segundos_full($total_horas);
      $total_dias =  $interval->format('%a') + 1;
      // $total_horas = $total_dias*8;
      // $total_horas = $total_horas.':00';

      // lista para preencher as horas 
      $contrato_users = DB::table('contrato_users AS u')
      // ->rightjoin('contrato_produtos', 'contrato_produtos.departamentos_id', 'u.departamentos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->orderBy('contratos.ctnome','asc')
      ->orderBy('departamentos.depnome','asc')
      ->orderBy('atividades.atdescricao','asc')
      ->select('*', 'u.id AS id')
      ->where('u.users_id', Auth::user()->id)
      ->get();

      

      $contpro = array();


      $horas_banco = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->select(DB::raw('sum( time_to_sec (u.horas)) as horas'))
      ->where([['u.users_id', Auth::user()->id],['periodos.datainicio', $request->inicio],['periodos.datafim', $request->fim]])
      ->first();

      $totalcad = $this->horas_segundos_full($horas_banco->horas); 


      //atestado

      $totalats = null; 

      // $totalcad = $totalcad - $totalats;


      // $dados_feriados = DB::table('feriados AS u')
      // ->join('feriados_tipos', 'feriados_tipos.id', 'u.feriados_tipos_id')
      // // ->where('u.feriados_tipos_id', '!=' , 9)
      // ->whereIn('u.fn_data', $dateRange)      
      // ->select('*', 'u.id AS id')
      // ->get();


      return view("pages.horas.add_horas", compact('add_anima','contrato_users', 'contpro', 'data_inicio', 'data_fim','total_dias','total_horas', 'totalats',
                  'data_voltar','data_inicio_s','data_fim_s','totalcad','data_inicio_rec','data_fim_rec'));
    }
    public function add_lista($add_anima, $request){
      $user = $request->usuario;
      $chamada = $request->usuario;
      if(!$user){
        $user =  Auth::user()->id;
        $chamada = false;
      }

      $nomeuser = User::where('id',$user)->first()->name;

      // dd($request->usuario);


      $add_anima = 'data-aos=fade-left data-aos-delay=450';
      $dados_lista = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', 'u.id AS id')
      ->where('u.users_id', $user)
      ->orderBy('periodos.datainicio','DESC')
      ->get();
      // dd($dados_lista);

      return view("pages.horas.lista", compact('dados_lista','add_anima','user'));
    }
    public function lista_horas($add_anima, $request){
      $user = $request->usuario;
      $chamada = $request->usuario;
      if(!$user){
        $user =  Auth::user()->id;
        $chamada = false;
      }

      $dados_lista = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select('*', 'u.id AS id')
      ->where([['u.users_id', $user],['periodos.datainicio', $request->inicio],['periodos.datafim', $request->fim] ])
      ->orderBy('periodos.datainicio','DESC')
      ->get();

      

      return view("pages.horas.lista_calendario", compact('dados_lista','add_anima'));
    }
    public function add_create($add_anima, $request){
      $data_voltar = $request->data_voltar;
      $user = $request->usuario;
      $chamada = $request->usuario;
      if(!$user){
        $user =  Auth::user()->id;
        $chamada = false;
      }
      $nomeuser = User::where('id',$user)->first()->name;
      $dados_fer_user = array();
      

      $dados_calendario = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select( DB::raw('sum( time_to_sec (u.horas)) as horas'), 'u.id As id', 'periodos.datainicio', 'periodos.datafim', 'u.atividades_id' )
      ->where([['u.users_id', $user]])
      ->groupBy('periodos.datainicio')
      ->get();

      $dados_calendario_atividade = DB::table('eventos AS u')
      ->join('periodos', 'periodos.id', 'u.periodos_id')
      ->join('contratos', 'contratos.id', 'u.contratos_id')
      ->join('departamentos', 'departamentos.id', 'u.departamentos_id')
      ->join('atividades', 'atividades.id', 'u.atividades_id')
      ->select( 'u.id As id', 'periodos.datainicio', 'periodos.datafim','atividades.atdescricao','u.horas', 'u.atividades_id' )
      ->where([['u.users_id', $user]])
      ->orderBy('atividades.atdescricao', 'asc')
      // ->groupBy('periodos.datainicio')
      ->get();

      
      

      $dados_lista = array();

      $dados_ferias = DB::table('ferias AS u')
      ->join('users', 'users.id', 'u.users_id')
      ->where([['u.users_id', $user]])
      ->select('*', 'u.id AS id', 'u.status as status')
      ->get();

      $dados_atestados = array();

      // return $dados_calendario;

      return view("pages.horas.add_calendario", compact('add_anima','data_voltar','dados_calendario','dados_lista','dados_calendario_atividade', 'dados_ferias','dados_atestados','chamada','nomeuser','dados_fer_user'));
    }
    public function editar($id){
        $dados_editar = Funcao::find($id);
        return view("pages.horas.editar", compact('dados_editar'));  
    }
    public function store(Request $request){
      $mensagem = 'erro, Esse tipo de dado não pode ser adicionado';
      $ids = [];
      $retorno = $mensagem; 

      $temperiodo = Periodo::where([['users_id', Auth::user()->id],['datainicio', $request->data_inicio],['datafim', $request->data_fim]])->get();
      if(!count($temperiodo) == 0){
        $dados_periodo = Periodo::find($temperiodo[0]->id);
      }else{
        $dados_periodo = new Periodo();
      }
      $dados_periodo->datainicio = $request->data_inicio;
      $dados_periodo->datafim = $request->data_fim;
      $dados_periodo->users_id = Auth::user()->id;
      $dados_periodo->perhoras = $request->input('horas_cadastradas');
      $dados_periodo->save(); 

      foreach ($request->input('horas') as $key => $value){ 
         $keys = explode(",", $key);
         $contratos_id = $keys[0]; $departamentos_id = $keys[1]; $atividades_id = $keys[2]; $periodos_id = $dados_periodo->id;
         if($value !== '00:00'){      
          $pos = strpos($value, 'NaN');
          if($pos === false){
            $dados_evento = new Evento();
            $dados_evento->horas =  $value;
            $dados_evento->atividades_id = $atividades_id;
            $dados_evento->departamentos_id = $departamentos_id;
            $dados_evento->contratos_id = $contratos_id;
            $dados_evento->periodos_id = $periodos_id;
            $dados_evento->funcaos_id = Auth::user()->funcaos_id;

            $tarifaval = Tarifa::where('funcaos_id',Auth::user()->funcaos_id)->first();

            $dados_evento->tarifa = $tarifaval->valor;

            $dados_evento->users_id = Auth::user()->id;
            $dados_evento->departamentos_id = Auth::user()->departamentos_id;
            $dados_evento->save(); 
            array_push($ids, $dados_evento->id);
            $retorno = $ids;
          }
         }
      }
      $ids = json_encode($ids); 
      return $retorno;
    }
    public function delete($id){
      $keys = explode("-", $id);

      $pegaPeriodo = Evento::find($keys[1]);
      $deletar = Evento::find($keys[1]);
      
        if(isset($deletar)){
          $alterar = Periodo::find($pegaPeriodo->periodos_id);
          $alterar->perhoras = $keys[0];
          $alterar->save(); 
        }
       
        if(isset($deletar)){
            try {
                $deletar->delete();
                return 'Removido com sucesso!';
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    return 'Erro, esse item esta comprometido em outro relacionamento.';
                }
            }
        }
        
    }
    function horas_segundos_full($total){
      $horas = floor($total / 3600);
      $minutos = floor(($total - ($horas * 3600)) / 60);
      $segundos = floor($total % 60);
      if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
      if(strlen($horas) == 1){ $horas = '0'.$horas;}
      return $horas.':'.$minutos.':00';
    }
    function converte_segundos($tempo){
        $segundos = 0;
        list( $h, $m, $s ) = explode( ':', $tempo ); 
        $segundos += $h * 3600; 
        $segundos += $m * 60;
        $segundos += $s;
        return $segundos;
    }
}
