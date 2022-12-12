<?php

namespace App\Http\Controllers;
use App\Models\Atividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class AtividadeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.atividades.index");
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
      $dados_lista  = Atividade::all();
       return view("pages.atividades.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){
      return view("pages.atividades.create", compact('add_anima'));
    }

    public function editar($id){
        $dados_editar = Atividade::find($id);
        return view("pages.atividades.editar", compact('dados_editar'));  
    }

    public function store(Request $request){
        $id_geral = $request->input('id_geral');
        
        
        if($id_geral == ''){
          $tem = Atividade::where('atdescricao', $request->input('atdescricao'))->get();
          if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
          // CADASTRA          
          $dados = new Atividade();
        }else{
          // ATUALIZA
          $dados = Atividade::find($id_geral);
          if($dados->atdescricao !== $request->input('atdescricao')){
            $tem = Atividade::where('atdescricao', $request->input('atdescricao'))->get();
            if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
          }
        }
        $dados->atdescricao = $request->input('atdescricao');
        $dados->users_id_atualizou = Auth::user()->id;
        $dados->save();     
        return $dados->id;
    }
    public function delete($id){
        $deletar = Atividade::find($id);
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
