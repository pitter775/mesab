<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Funcao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;



class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(User $model){
      return view("pages.usuarios.index");
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
      $dados_lista  = DB::table('users AS u')
      ->leftjoin('funcaos', 'funcaos.id', '=', 'u.funcaos_id')
      ->leftjoin('departamentos', 'departamentos.id', '=', 'u.departamentos_id')
      ->leftjoin('tarifas', 'tarifas.funcaos_id', '=', 'u.funcaos_id')
      ->select('*', 'u.id AS uid')
      ->get();
       return view("pages.usuarios.lista", compact('dados_lista','add_anima'));
    }

    public function add_create($add_anima){
      $funcao = Funcao::all(); 
      $departamento = Departamento::all();
      return view("pages.usuarios.create", compact('funcao','add_anima','departamento'));   
    }

    public function store(Request $request){
      $id_geral = $request->input('id_geral');   
      
      $password = $request->input('password');    
      $horas = $request->input('horas');   
      
      if($id_geral == ''){
          $tem = User::where('email', $request->input('email'))->get();
          if(!count($tem) == 0){return 'erro, Já existe esse email cadastrado no sistema.';}
        // CADASTRA
        $dados = new User();
      }else{
        // ATUALIZA
        $dados = User::find($id_geral);
        if($dados->email !== $request->input('email')){
          $tem = User::where('email', $request->input('email'))->get();
          if(!count($tem) == 0){return 'erro, Já existe esse email cadastrado no sistema.';}
        }
      }
      $dados->name = $request->input('name');
      $dados->email = $request->input('email');
      $dados->tarifa = $request->input('tarifa');
      $dados->funcaos_id = $request->input('funcaos_id');
      $dados->departamentos_id = $request->input('departamentos_id');
      $dados->contrato = 'CLT';
      if(isset($password)){
        if($password !== ''){
          $dados->password = Hash::make($request->input('password')); 
        }        
      }
      if(isset($horas)){
        if($horas == 1){
          $dados->horas_ilimitadas = $horas; 
        }else{
          $dados->horas_ilimitadas = 0; 
        }     
      }else{
        $dados->horas_ilimitadas = 0; 
      }
      $dados->perfil = $request->input('perfil');      
      $dados->save();     
      return $dados->id;
    }
    public function editar($id){
      $funcao = Funcao::all(); 
      $departamento = Departamento::all();
      $dados_editar  = DB::table('users AS u')
      ->leftjoin('funcaos', 'funcaos.id', '=', 'u.funcaos_id')
      ->leftjoin('departamentos', 'departamentos.id', '=', 'u.departamentos_id')
      ->leftjoin('tarifas', 'tarifas.funcaos_id', '=', 'u.funcaos_id')
      ->select('*', 'u.id AS uid')
      ->where('u.id', $id)
      ->first();
      return view("pages.usuarios.editar", compact('dados_editar','funcao','departamento'));  
  }

  public function delete($id){
    $deletar = User::find($id);
    if(isset($deletar)){
        try {
            $deletar->delete();
            return 'Removido com sucesso!';
        }catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                return 'Erro, esse usuario esta comprometido em outro relacionamento.';
            }
        }
    }
}
}
