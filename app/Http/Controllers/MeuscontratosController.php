<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\Contrato;
use App\Models\Contrato_produto;
use App\Models\contrato_produto_atividade;
use App\Models\Contrato_user;
use App\Models\Funcao;
use App\Models\Meuscontratos;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;


class MeuscontratosController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.meuscontratos.index");
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
        $dados_lista = DB::table('contrato_users AS t')
        ->join('contratos', 'contratos.id', '=', 't.contratos_id')
        ->join('atividades', 'atividades.id', '=', 't.atividades_id')
        ->where([['t.users_id', Auth::user()->id]])
        ->select('*', 't.id AS id')
        ->get();

        return view("pages.meuscontratos.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){
        $contratos = Contrato::all();
        return view("pages.meuscontratos.create", compact('add_anima','contratos'));  
    }

    public function get_produtos($id){
       
        $departamentos_atv = DB::table('departamento_atividades AS d')
        ->join('atividades', 'atividades.id', '=', 'd.daatividades_id')
        ->join('departamentos', 'departamentos.id', '=', 'd.dadepartamentos_id')
        ->where([['d.dadepartamentos_id', Auth::user()->departamentos_id]])
        ->orderBy('atividades.atdescricao','asc')
        ->select('*', 'd.id AS id')
        ->get();

        $contrato_id = $id;

        // dd($departamentos_atv);

        return view("pages.meuscontratos.get_departamentos", compact('contrato_id', 'departamentos_atv'));  
    }

    public function store(Request $request){
        $mensagem = 'erro, Já existem relaciomentos com a atividade selecionada';
        $ids = [];
        $retorno = $mensagem; 

        foreach($request->atividades as $key => $value){ 
            $keys = explode(",", $key);
            if (Contrato_user::where([ 
                ['contratos_id', $request->input('contratos_id')],
                ['departamentos_id',  $keys[0]], 
                ['atividades_id', $value], 
                ['users_id', Auth::user()->id] ])->count() == 0) {        
                             
                $dados = new Contrato_user();
                $dados->contratos_id = $request->input('contratos_id');
                $dados->departamentos_id = $keys[0];
                $dados->atividades_id = $value;
                $dados->users_id = Auth::user()->id;
                $dados->save(); 
                array_push($ids, $dados->id);
                $retorno = $ids;  
            }  
        }
        $ids = json_encode($ids); 
        return $retorno;
    }
    public function delete($id){
        $deletar = Contrato_user::find($id);
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
