<?php

namespace App\Http\Controllers;
use App\Models\Aviso;
use App\Models\Aviso_para;
use App\Models\Aviso_visto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;
use App\Jobs\newDisparo;
use stdClass;

class AvisosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
      return view("pages.avisos.index");
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
      $dados_lista  = Aviso::all();
       return view("pages.avisos.lista", compact('dados_lista','add_anima'));
    }
    public function add_create($add_anima){
      $usuarios = User::orderBy('name')->get();
      return view("pages.avisos.create", compact('add_anima','usuarios')); 
    }
    public function editar($id){
        $dados_editar = Aviso::find($id);
        $usuarios = User::orderBy('name')->get();
        return view("pages.avisos.editar", compact('dados_editar','usuarios'));  
    }
    public function store(Request $request){
      $id_geral = $request->input('id_geral');
      $enviaremail = $request->input('enviar_email');
      

      if($id_geral == ''){     
        $dados_aviso = new Aviso();
      }else{
        $dados_aviso = Aviso::find($id_geral);
      }
        $dados_aviso->titulo = $request->input('titulo');
        $dados_aviso->mensagem = $request->input('mensagem');
        $dados_aviso->save(); 
        $aviso_id =  $dados_aviso->id;

        if($request->usuario){
          foreach($request->usuario as $key => $value){   
            if($value){
              $dados_para = new Aviso_para(); 
              $dados_para->avisos_id = $aviso_id;
              $dados_para->users_id = $value;
              $dados_para->save(); 
            }
            if (isset($enviaremail)) {

              $user = new stdClass();
              $user->name = User::where('id',$value)->first()->name;
              $user->email = User::where('id',$value)->first()->email;
              $user->titulo = $request->input('titulo');
              $user->mensagem = $request->input('mensagem');
              $user->subject = $request->input('titulo');
              newDisparo::dispatch($user)->delay(now()->addSecond('2'));
            }
              
          }
        }

        
        return $aviso_id;
      
    }
    public function delete($id){
        

        $enviados = Aviso_para::where('avisos_id', $id)->get();
        $enviados_v = Aviso_visto::where('avisos_id', $id)->get();
        foreach($enviados as $value){
          $deletar = Aviso_para::find($value->id);
          $deletar->delete();
        }
        foreach($enviados_v as $value){
          $deletar = Aviso_visto::find($value->id);
          $deletar->delete();
        }
        $deletar = Aviso::find($id);
        $deletar->delete();
        return 'Removido com sucesso!';
        
        // if(isset($deletar)){
        //     try {
        //         $deletar->delete();
        //         return 'Removido com sucesso!';
        //     }catch (PDOException $e) {
        //         if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
        //             return 'Erro, esse item esta comprometido em outro relacionamento.';
        //         }
        //     }
        // }
    }
    public function aviso_qnt(){
      $avisos = Aviso_para::where('users_id', Auth::user()->id)->count();
      return $avisos;
    }
    public function aviso_qnt_novo(){
        $avisos_para = Aviso_para::where('users_id', Auth::user()->id)->count();
        $avisos_visto = Aviso_visto::where('users_id', Auth::user()->id)->count();
        $resul = $avisos_para - $avisos_visto;
        return $resul;
    }
    public function aviso_user(){
      $dados_lista = DB::table('avisos AS a')
        ->join('aviso_paras', 'aviso_paras.avisos_id', '=', 'a.id')
        ->select('*', 'a.id as id')
        ->where('aviso_paras.users_id', Auth::user()->id)
        ->get();

      return view("pages.avisos.lista_drop_user", compact('dados_lista'));
    }
    public function aviso_visto(){
      $vistos = DB::table('avisos AS a')
      ->join('aviso_paras', 'aviso_paras.avisos_id', '=', 'a.id')
      ->select('*', 'a.id as id')
      ->where('aviso_paras.users_id', Auth::user()->id)
      ->get();
      foreach($vistos as $value){
        $tem = Aviso_visto::where([['avisos_id', $value->id],['users_id', Auth::user()->id]])->count();
        if($tem == 0){
          $ddvisto = new Aviso_visto();
          $ddvisto->avisos_id = $value->id;
          $ddvisto->users_id = Auth::user()->id;
          $ddvisto->save();
        }
      }
    }
    public function enviar_email(){
      $user = new stdClass();
      $user->name = 'pitter web';
      $user->email = 'pitter775@gmail.com';
      $user->titulo = 'teste';
      $user->mensagem = 'teste teste555544444455';
      $user->subject = 'subjectivoss';
      newDisparo::dispatch($user)->delay(now()->addSecond('2'));
    }
}
