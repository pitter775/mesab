<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Contrato_produto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;


class Contrato_produtoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.contrato_produtos.index");
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
      $dados_lista  = DB::table('contrato_produtos AS u')
        ->join('contratos', 'contratos.id', '=', 'u.contratos_id')
        ->join('produtos', 'produtos.id', '=', 'u.produtos_id')
        ->select('*', 'u.id AS id')
        ->get();

       return view("pages.contrato_produtos.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){   
      $contratos = Contrato::all();
      $produtos = Produto::all();
      return view("pages.contrato_produtos.create", compact('contratos','produtos','add_anima'));
    }
    public function editar($id){
        $contratos = Contrato::all();
        $produtos = Produto::all();
        $dados_editar  = DB::table('contrato_produtos AS u')
        ->join('contratos', 'contratos.id', '=', 'u.contratos_id')
        ->join('produtos', 'produtos.id', '=', 'u.produtos_id')
        ->select('*', 'u.id AS id')
        ->where('u.id', $id)
        ->first();
        return view("pages.contrato_produtos.editar", compact('dados_editar','contratos','produtos'));  
    }
    public function store(Request $request){
        $id_geral = $request->input('id_geral');      
        
        if($id_geral == ''){
          $tem = Contrato_produto::where([['contratos_id', $request->input('contratos_id')],['produtos_id', $request->input('produtos_id')]])->get();          
          if(!count($tem) == 0){return 'erro, Já existe esse relacionamento no sistema.';}
          // CADASTRA          
          $dados = new Contrato_produto();
        }else{
          // ATUALIZA
          $dados = Contrato_produto::find($id_geral);
          if($dados->contratos_id !== $request->input('contratos_id') && $dados->produtos_id !== $request->input('produtos_id') ){
            $tem = Contrato_produto::where([['contratos_id', $request->input('contratos_id')],['produtos_id', $request->input('produtos_id')]])->get();   
            if(!count($tem) == 0){return 'erro, Já existe esse relacionamento no sistema.';}
          }
        }
        $dados->contratos_id = $request->input('contratos_id');
        $dados->produtos_id = $request->input('produtos_id');
        $dados->csppep = $request->input('csppep');
        $dados->cspdescricao = $request->input('cspdescricao');
        $dados->users_id_atualizou = Auth::user()->id;
        $dados->save();     
        return $dados->id;
    }
    public function delete($id){
        $deletar = Contrato_produto::find($id);
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
