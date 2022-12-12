<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\Contrato;
use App\Models\Departamento;
use App\Models\Departamento_atividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class Departamento_atividadeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.departamento_atividade.index");
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
      $dados_lista  = DB::table('departamento_atividades AS u')
        ->join('atividades', 'atividades.id', '=', 'u.daatividades_id')
        ->select('*', 'u.id AS id')
        ->get();

       return view("pages.departamento_atividade.lista", compact('dados_lista','add_anima'));
    }
    public function add_create($add_anima){      
      $departamentos = Departamento::all();      
      return view("pages.departamento_atividade.create", compact('departamentos','add_anima'));
    }
    public function editar($id){
        $departamento = Departamento::all();
        $dados_editar  = DB::table('departamento_atividades AS u')
        ->join('contratos', 'contratos.id', 'u.contratos_id')
        ->join('produtos', 'produtos.id', 'u.produtos_id')
        ->select('*', 'u.id AS id')
        ->where('u.id', $id)
        ->first();
        return view("pages.departamento_atividade.editar", compact('dados_editar','contratos','produtos'));  
    }
    public function store(Request $request){ 

        // $departamento_atividade = Departamento_atividade::where([['dadepartamentos_id',$request->input('dadepartamentos_id')], ['daatividades_id',$request->input('daatividades_id')]])->first();
        $mensagem = 'erro, Já existem relaciomentos com a atividade selecionada';
        $ids = [];
        $retorno = $mensagem;
        
        // CADASTRA 
        foreach ($request->input('daatividades_id') as $idativ){    
          if (Departamento_atividade::where([ ['dadepartamentos_id', $request->input('dadepartamentos_id')],['daatividades_id',  $idativ] ])->count() == 0) {     
            $dados = new Departamento_atividade();
            $dados->dadepartamentos_id = $request->input('dadepartamentos_id');
            $dados->daatividades_id = $idativ;
            $dados->users_id_atualizou = Auth::user()->id;
            $dados->save();
            array_push($ids, $dados->id);
            $retorno = $ids; 
          }  
        } 
        $ids = json_encode($ids); 
        return $retorno;
      
    }
    public function delete($id){
        $deletar = Departamento_atividade::find($id);
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

    public function get_atividade(Request $request){

      $atividades = Atividade::all();
      $html = '<div class="md-form"><select searchable="Procurar..." class="mdb-select colorful-select dropdown-primary md-form get-select2" name="daatividades_id[]" id="daatividades_id" multiple required>';
      $html .='<option value="" selected disabled></option>';
      foreach ($atividades as $value){
        $html .='<option value="'.$value->id.'">'.$value->atdescricao.'</option>';
      }
      $html .= '</select><label for="daatividades_id" class="active">Selecione uma ou mais Atividades</label></div>';
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
    $totalRecords = Departamento_atividade::select('count(*) as allcount')->count();
    
    
    $totalRecordswithFilter = DB::table('departamento_atividades AS u')
       
        ->join('atividades', 'atividades.id', '=', 'u.daatividades_id')
        ->join('departamentos', 'departamentos.id', '=', 'u.dadepartamentos_id')
        ->Where('u.id', 'like', '%' .$searchValue . '%')    
        ->orWhere('atividades.atdescricao', 'like', '%' .$searchValue . '%')
        ->select('*', 'u.id AS id')
        ->count();

    // Fetch records
    $records  = DB::table('departamento_atividades AS u')
        ->join('atividades', 'atividades.id', '=', 'u.daatividades_id')
        ->join('departamentos', 'departamentos.id', '=', 'u.dadepartamentos_id')
        ->select('u.id AS id', 'departamentos.depnome', 'atividades.atdescricao as atdescricao')
        ->Where('u.id', 'like', '%' .$searchValue . '%')
        ->orWhere('atividades.atdescricao', 'like', '%' .$searchValue . '%')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


    $data_arr = array();
    
    foreach($records as $record){
       $id = $record->id;
       $depnome = $record->depnome;
       $setinha = '<i class="fas fa-arrows-alt-h" style="font-size: 20px; "></i>';
       $atdescricao = $record->atdescricao;
       $acao = '<a href="#" class="btn btn-outline-danger btn-rounded btn-sm waves-effect" onclick="return deletar_item('.$record->id.')"><i class="fas fa-trash-alt"></i></a>';


       $data_arr[] = array(
         "id" => $id,
         "depnome" => $depnome,
         'setinha'=>$setinha,
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
