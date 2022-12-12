<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\Contrato;
use App\Models\Contrato_produto;
use App\Models\Contrato_produto_atividade;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;


class Contrato_produto_atividadeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.contrato_produto_atividades.index");
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
      $dados_lista  = DB::table('contrato_produto_atividades AS u')
        ->join('contrato_produtos', 'contrato_produtos.id', '=', 'u.contrato_produtos_id')
        ->join('contratos', 'contratos.id', '=', 'contrato_produtos.contratos_id')
        ->join('produtos', 'produtos.id', '=', 'contrato_produtos.produtos_id')
        ->join('atividades', 'atividades.id', '=', 'u.atividades_id')
        ->select('*', 'u.id AS id')
        ->get();

       return view("pages.contrato_produto_atividades.lista", compact('dados_lista','add_anima'));
    }
    public function add_create($add_anima){      
      $contratos = Contrato::all();      
      return view("pages.contrato_produto_atividades.create", compact('contratos','add_anima'));
    }
    public function editar($id){
        $contratos = Contrato::all();
        $produtos = Produto::all();
        $dados_editar  = DB::table('contrato_produto_atividades AS u')
        ->join('contratos', 'contratos.id', 'u.contratos_id')
        ->join('produtos', 'produtos.id', 'u.produtos_id')
        ->select('*', 'u.id AS id')
        ->where('u.id', $id)
        ->first();
        return view("pages.contrato_produto_atividades.editar", compact('dados_editar','contratos','produtos'));  
    }
    public function store(Request $request){ 
      if (isset($request->replicar)){
        $contrato_produtos = Contrato_produto::where([['produtos_id',$request->input('produtos_id')]])->get();        
        foreach($contrato_produtos as $contpro){
          $id_contrato_produto = $contpro->id;
          $mensagem = 'erro, Já existiam alguns dos relaciomentos com as atividades selecionadas';
          $ids = [];
          $retorno = $mensagem;
          // CADASTRA 
          foreach ($request->input('atividades_id') as $idativ){    
            if (Contrato_produto_atividade::where([ ['contrato_produtos_id', $id_contrato_produto],['atividades_id',  $idativ] ])->count() == 0) {     
              $dados = new Contrato_produto_atividade();
              $dados->contrato_produtos_id = $id_contrato_produto;
              $dados->atividades_id = $idativ;
              $dados->users_id_atualizou = Auth::user()->id;
              $dados->save();
              array_push($ids, $dados->id);
              $retorno = $ids; 
            }  
          }          
        }
        $ids = json_encode($ids); 
        return $retorno;

      }else{
        $contrato_produto = Contrato_produto::where([['contratos_id',$request->input('contratos_id')], ['produtos_id',$request->input('produtos_id')]])->first();
        $id_contrato_produto = $contrato_produto->id;
        $mensagem = 'erro, Já existem relaciomentos com a atividade selecionada';
        $ids = [];
        $retorno = $mensagem;
        
        // CADASTRA 
        foreach ($request->input('atividades_id') as $idativ){    
          if (Contrato_produto_atividade::where([ ['contrato_produtos_id', $id_contrato_produto],['atividades_id',  $idativ] ])->count() == 0) {     
            $dados = new Contrato_produto_atividade();
            $dados->contrato_produtos_id = $id_contrato_produto;
            $dados->atividades_id = $idativ;
            $dados->users_id_atualizou = Auth::user()->id;
            $dados->save();
            array_push($ids, $dados->id);
            $retorno = $ids; 
          }  
        } 
        $ids = json_encode($ids); 
        return $retorno;
      }
    }
    public function delete($id){
        $deletar = Contrato_produto_atividade::find($id);
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
    public function get_produto(Request $request){
      
      $contrato_produto  = DB::table('contrato_produtos AS u')
        ->join('contratos', 'contratos.id', '=', 'u.contratos_id')
        ->join('produtos', 'produtos.id', '=', 'u.produtos_id')
        ->where('u.contratos_id',$request->contrato)
        ->select('*', 'produtos.id AS id')
        ->get();


      $html = '<div class="md-form"><select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form get-select" name="produtos_id" id="produtos_id" required>';
      $html .='<option value="" selected disabled></option>';
      foreach ($contrato_produto as $value){
        $html .='<option value="'.$value->id.'">'.$value->prdescricao.'</option>';
      }
      $html .= '</select><label for="produtos_id" class="active">Selecione um produto</label></div>';
      return $html;
    }
    public function get_atividade(Request $request){
      

      $atividades = Atividade::all();

      $html = '<div class="md-form"><select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form get-select2" name="atividades_id[]" id="atividades_id" multiple required>';
      $html .='<option value="" selected disabled></option>';
      foreach ($atividades as $value){
        $html .='<option value="'.$value->id.'">'.$value->atdescricao.'</option>';
      }
      $html .= '</select><label for="atividades_id" class="active">Selecione uma ou mais Atividades</label></div>';

      $html .= '<div class="switch switchacord2 pequeno" style="margin-left: 0; padding-left:0; margin-top: 10px" >
                    <label><input type="checkbox" style="width: 20px;" name="replicar" value="1" class=" checklever " >
                    <span class="lever" style="margin-left: 0; padding-left:0"></span> Replicar em todos os contratos que possuem o mesmo produto.</label> 
                </div>';
      return $html;
    }

    /*
   AJAX request
   */
   public function get_atividade_dataajax(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    // Total records
    $totalRecords = Contrato_produto_atividade::select('count(*) as allcount')->count();
    
    
    $totalRecordswithFilter = DB::table('contrato_produto_atividades AS u')
        ->join('contrato_produtos', 'contrato_produtos.id', '=', 'u.contrato_produtos_id')
        ->join('contratos', 'contratos.id', '=', 'contrato_produtos.contratos_id')
        ->join('produtos', 'produtos.id', '=', 'contrato_produtos.produtos_id')
        ->join('atividades', 'atividades.id', '=', 'u.atividades_id')
        ->where('contratos.ctnome', 'like', '%' .$searchValue . '%')
        ->orWhere('u.id', 'like', '%' .$searchValue . '%')
        ->orWhere('contratos.ctnumero', 'like', '%' .$searchValue . '%')
        ->orWhere('atividades.atdescricao', 'like', '%' .$searchValue . '%')
        ->orWhere('produtos.prdescricao', 'like', '%' .$searchValue . '%')
        ->select('*', 'u.id AS id')
        ->count();

    // Fetch records
    $records  = DB::table('contrato_produto_atividades AS u')
        ->join('contrato_produtos', 'contrato_produtos.id', '=', 'u.contrato_produtos_id')
        ->join('contratos', 'contratos.id', '=', 'contrato_produtos.contratos_id')
        ->join('produtos', 'produtos.id', '=', 'contrato_produtos.produtos_id')
        ->join('atividades', 'atividades.id', '=', 'u.atividades_id')
        ->select('u.id AS id', 'contratos.ctnome as ctnome', 'contratos.ctnumero as ctnumero', 'atividades.atdescricao as atdescricao', 'produtos.prdescricao as prdescricao')
        ->where('contratos.ctnome', 'like', '%' .$searchValue . '%')
        ->orWhere('u.id', 'like', '%' .$searchValue . '%')
        ->orWhere('contratos.ctnumero', 'like', '%' .$searchValue . '%')
        ->orWhere('atividades.atdescricao', 'like', '%' .$searchValue . '%')
        ->orWhere('produtos.prdescricao', 'like', '%' .$searchValue . '%')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


    $data_arr = array();
    
    foreach($records as $record){
       $id = $record->id;
       $ctnumero = $record->ctnumero.'-'.$record->ctnome.' <i class="fas fa-arrows-alt-h" style="font-size: 12px; "></i> '.$record->prdescricao;
       $setinha = '<i class="fas fa-arrows-alt-h" style="font-size: 20px; "></i>';
       $atdescricao = $record->atdescricao;
       $acao = '<a href="#" class="btn btn-outline-danger btn-rounded btn-sm waves-effect" onclick="return deletar_item('.$record->id.')"><i class="fas fa-trash-alt"></i></a>';


       $data_arr[] = array(
         "id" => $id,
         'setinha'=>$setinha,
         "ctnumero" => $ctnumero,
         "atdescricao" => $atdescricao,
         "acao" => $acao,

       );
    }

    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordswithFilter,
       "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
  }
}
