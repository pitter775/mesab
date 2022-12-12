<?php

namespace App\Http\Controllers;
use App\Models\Feriado;
use App\Models\Feriados_tipo;
use App\Models\User;
use App\Models\Feriado_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class FeriadoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $feriados = $this->dias_feriados('2021');
        return view("pages.feriados.index", compact('feriados'));
    }
    public function dias_feriados($ano = null){

        if ($ano === null)
        {
            $ano = intval(date('Y'));
        }

        $pascoa     = easter_date($ano); // Limite de 1970 ou após 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
        $dia_pascoa = date('j', $pascoa);
        $mes_pascoa = date('n', $pascoa);
        $ano_pascoa = date('Y', $pascoa);
        $feriados_descricao = [];
        //$feriados = array(
            // Tatas Fixas dos feriados Nacionail Basileiras
            
            $feriados_descricao[mktime(0, 0, 0, 1,  1,   $ano)] = 'Confraternização Universal';
            $feriados_descricao[mktime(0, 0, 0, 4,  21,  $ano)] = 'Tiradentes';
            $feriados_descricao[mktime(0, 0, 0, 5,  1,   $ano)] = 'Dia do Trabalhador';
            $feriados_descricao[mktime(0, 0, 0, 9,  7,   $ano)] = 'Dia da Independência';
            $feriados_descricao[mktime(0, 0, 0, 10,  12,   $ano)] = 'N. S. Aparecida';
            $feriados_descricao[mktime(0, 0, 0, 11,  2,   $ano)] = 'Todos os santos';
            $feriados_descricao[mktime(0, 0, 0, 11,  15,   $ano)] = 'Proclamação da republica';
            $feriados_descricao[mktime(0, 0, 0, 12,  25,   $ano)] = 'Natal';

            $feriados_descricao[mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa)] = '2ºferia Carnaval';
            $feriados_descricao[mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa)] = '3ºferia Carnaval';
            $feriados_descricao[mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2,  $ano_pascoa)] = '6ºfeira Santa';
            $feriados_descricao[mktime(0, 0, 0, $mes_pascoa, $dia_pascoa    ,  $ano_pascoa)] = 'Pascoa';
            $feriados_descricao[mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa)] = 'Corpus Cirist';
          

            // mktime(0, 0, 0, 1,  1,   $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
            // mktime(0, 0, 0, 4,  21,  $ano), // Tiradentes - Lei nº 662, de 06/04/49
            // mktime(0, 0, 0, 5,  1,   $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
            // mktime(0, 0, 0, 9,  7,   $ano), // Dia da Independência - Lei nº 662, de 06/04/49
            // mktime(0, 0, 0, 10,  12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
            // mktime(0, 0, 0, 11,  2,  $ano), // Todos os santos - Lei nº 662, de 06/04/49
            // mktime(0, 0, 0, 11, 15,  $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
            // mktime(0, 0, 0, 12, 25,  $ano), // Natal - Lei nº 662, de 06/04/49

            // // These days have a date depending on easter
            // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa),//2ºferia Carnaval
            // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa),//3ºferia Carnaval	
            // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa),//6ºfeira Santa  
            // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa),//Pascoa
            // mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa),//Corpus Cirist
        //);


       

    
        return $feriados_descricao;
    }

    public function add_card($card){
      $cards = explode("-", $card);
      $anima_create = $cards[1] == 1?'data-aos=fade-left data-aos-delay=0':'';  
      $anima_lista = $cards[1] == 1?'data-aos=fade-left data-aos-delay=200':'';  

      switch ($cards[0]) {
        case 'lista':               
            return $this->add_lista($anima_lista);
            break;
        case 'create':
          return $this->add_create($anima_create);
            break;
      }      
    }

    public function add_lista($add_anima){
        $dados_lista = DB::table('feriados AS u')
        ->join('feriados_tipos', 'feriados_tipos.id', 'u.feriados_tipos_id')
        ->select('*', 'u.id AS id')
        ->get();
        return view("pages.feriados.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){
        $tipo_feriado = Feriados_tipo::all();
        $usuarios = User::all();
        $dados_lista = DB::table('feriados AS u')
        ->join('feriados_tipos', 'feriados_tipos.id', 'u.feriados_tipos_id')
        ->select('*', 'u.id AS id')
        ->get();

        return view("pages.feriados.create", compact('add_anima','tipo_feriado','dados_lista','usuarios'));
    }

    public function editar($id){
        $dados_editar = Feriado::find($id);
        return view("pages.feriados.editar", compact('dados_editar'));  
    }

    public function store(Request $request){
        if(isset($request->ferano)){
            $mensagem = 'erro, Já existem relaciomentos com a atividade selecionada';
            $ids = [];
            $retorno = $mensagem;

            $feriados = $this->dias_feriados($request->ferano);
            foreach($feriados as $key => $a)
            {
                if (Feriado::where([ ['fn_data', date("Y-m-d",$key)]])->count() == 0) {    
                    $dados = new Feriado();
                    $dados->fn_data = date("Y-m-d",$key);
                    $dados->fn_descricao = $a;
                    $dados->feriados_tipos_id = 1;
                    $dados->users_id_atualizou = Auth::user()->id;
                    $dados->save(); 
                    array_push($ids, $dados->id);
                    $retorno = $ids; 
                }				 
            }
            $ids = json_encode($ids); 
            return $retorno;

        }else{
            $data_feriado = date('Y-m-d', strtotime($request->input('fn_data_envio')));

            $dados = new Feriado();
            $dados->fn_data = $data_feriado;
            $dados->fn_descricao = $request->input('fn_descricao');
            $dados->feriados_tipos_id = $request->input('feriados_tipos_id');
            if($request->input('feriados_tipos_id') == 9){
                $dados->horas = $request->input('horas').':'.$request->input('minutos').':00';
            }
            if (!$request->input('todosuser')) {
                $dados->horas_user = 1;
            }
            $dados->users_id_atualizou = Auth::user()->id;
            $dados->save(); 

            if (!$request->input('todosuser')) {
                foreach($request->usuario as $key => $value){   
                    if($value){
                        $dados_user = new Feriado_users();
                        $dados_user->feriados_id = $dados->id;
                        $dados_user->users_id  = $value;
                        $dados_user->save(); 
                    }
                }                
            }

            return $dados->id;
        }
    }
    public function delete($id){
        $deletar = Feriado::find($id);

        //removendo dependencias 
        if(isset($deletar)){
            $feriado_user = Feriado_users::where('feriados_id', $id)->get();
            if(isset($feriado_user)){
                foreach($feriado_user as $fe){
                    $del = Feriado_users::find($fe->id);
                    $del->delete();
                }
            }
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
}
