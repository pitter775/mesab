<?php

namespace App\Http\Controllers;
use App\Models\Feria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;



class FeriasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.ferias.index");
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
       $dados_lista  = DB::table('ferias AS f')
        ->join('users', 'users.id', '=', 'f.users_id')
        ->select('*', 'f.id AS id', 'f.status As status')
        ->get();
       return view("pages.ferias.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){
        $usuarios = User::orderBy('name')->get();
      return view("pages.ferias.create", compact('add_anima', 'usuarios')); 
    }

    public function editar($id){
        
        $dados_editar  = DB::table('ferias AS f')
        ->join('users', 'users.id', '=', 'f.users_id')
        ->select('*', 'f.id AS id', 'f.status As status')
        ->where('f.id', $id)
        ->first();
        return view("pages.ferias.editar", compact('dados_editar'));  
    }

    public function store(Request $request){
        $id_geral = $request->input('id_geral'); 
        $datainicio = $this->dateEmMysql($request->input('datainicio'));
        $datafim = $this->dateEmMysql($request->input('datafim'));       
           
        
        if($id_geral == ''){
          // CADASTRA          
          $dados = new Feria();
          $dados->datainicio = $datainicio;
          $dados->datafim = $datafim;
          $dados->users_id = $request->input('usuario');
        }else{
          // ATUALIZA
          $dados = Feria::find($id_geral);
          $dados->status = $request->input('status');
        }

        $dados->save();     
        return $dados->id; 
    }
    public function delete($id){
        $deletar = Feria::find($id);
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
    public static function dateEmMysql($dateSql){
      $ano= substr($dateSql, 6);
      $mes= substr($dateSql, 3,-5);
      $dia= substr($dateSql, 0,-8);
      return $ano."-".$mes."-".$dia;
    }
}
