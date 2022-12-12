<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Funcao;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class TarifaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.tarifas.index");
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
      $dados_lista = DB::table('tarifas AS t')
        ->join('funcaos', 'funcaos.id', '=', 't.funcaos_id')
        ->select('*', 't.id as id')
        ->get();
       return view("pages.tarifas.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){
        $funcao = Funcao::all();
        return view("pages.tarifas.create", compact('funcao','add_anima'));  
    }

    public function editar($id){
        $funcao = Funcao::all();
        $dados_editar = Tarifa::find($id);
        return view("pages.tarifas.editar", compact('dados_editar','funcao'));  
    }

    public function store(Request $request){
        $id_geral = $request->input('id_geral');        
        
        
        if($id_geral == ''){ 
          $tem = Tarifa::where([['funcaos_id', $request->input('funcaos_id')]])->get();
          if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
          // CADASTRA          
          $dados = new Tarifa();
        }else{
          // ATUALIZA
          $dados = Tarifa::find($id_geral);
          // if($dados->funcaos_id !== $request->input('funcaos_id') && $dados->equipes_id !== $request->input('equipes_id') ){
          //   $tem = Tarifa::where([['funcaos_id', $request->input('funcaos_id')],['equipes_id', $request->input('equipes_id')]])->get();
          //   if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
          // }
        }
        $dados->funcaos_id = $request->input('funcaos_id');
        $dados->valor = $request->input('valor');
        $dados->save();     
        return $dados->id;
    }
    public function delete($id){
        $deletar = Tarifa::find($id);
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
    public function gettarifa(Request $request){

      $tarifa = DB::table('tarifas as t')
      ->where([
         ['t.funcaos_id', $request->funcao]
      ])
      ->select('valor')
      ->first();

      return $tarifa->valor;

  }
}
