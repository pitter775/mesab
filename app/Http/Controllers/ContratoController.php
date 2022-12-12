<?php

namespace App\Http\Controllers;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class ContratoController extends Controller 
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.contratos.index");
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
            case 'relacionamento':
            return $this->add_relacionamento($anima_create);
                break;
        }      
    }
    public function add_relacionamento(){
        $contratos = Contrato::all();
        return view("pages.contratos.relacionamentos", compact('contratos'));
    }

  
    public function add_lista($add_anima){

        $dados_lista  = DB::table('contratos AS u')
        ->select('*', 'u.id AS id')
        ->get();
       return view("pages.contratos.lista", compact('dados_lista','add_anima'));
    }
    public function add_create($add_anima){
        return view("pages.contratos.create", compact('add_anima'));   
    }
    public function editar($id){

        $dados_editar  = DB::table('contratos AS u')
        ->select('*', 'u.id AS id')
        ->where('u.id', $id)
        ->first();
        return view("pages.contratos.editar", compact('dados_editar'));  
    }
    public function store(Request $request){
        $id_geral = $request->input('id_geral');
        
        if($id_geral == ''){
            $tem = Contrato::where('ctnome', $request->input('ctnome'))->get();
            if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
            // CADASTRA          
            $dados = new Contrato();
        }else{
            // ATUALIZA
            $dados = Contrato::find($id_geral);

            if($dados->ctnome !== $request->input('ctnome')){
                $tem = Contrato::where('ctnome', $request->input('ctnome'))->get();
                if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';} 
            }
        }
        $dados->ctnumero = $request->input('ctnumero');
        $dados->ctnome = $request->input('ctnome');
        $dados->ctdescricao = $request->input('ctdescricao');
        $dados->ctlocalizacao = $request->input('ctlocalizacao');
        $dados->ctsituacao = $request->input('ctsituacao');
        $dados->cttipo = $request->input('cttipo');
        $dados->ctapelido = $request->input('ctapelido');
        $dados->users_id_atualizou = Auth::user()->id;
        $dados->save();     
        return $dados->id;
    }
    public function delete($id){
        $deletar = Contrato::find($id);
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
