<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Atestado;
use App\Models\Feria;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;
use DateTime;

class ProfileController extends Controller
{
    public function add_card($card){
        $cards = explode("-", $card);
        $anima_create = $cards[1] == 1?'data-aos=fade-left data-aos-delay=0':'';  
        $anima_lista = $cards[1] == 1?'data-aos=fade-left data-aos-delay=200':'';  
  
        switch ($cards[0]) {
            case 'lista':               
                return $this->add_lista($anima_lista);
                break;
            case 'lista_atestado':               
                return $this->add_lista_atestado($anima_lista);
                break;
            case 'create':
                return $this->add_create($anima_create);
                break;
        }      
      }

    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        // dd('01', auth()->user()->id);
        auth()->user()->update($request->all());

        return back()->withStatus(__('Perfil atualizado com sucesso!'));
    }

    public function password(PasswordRequest $request){
       


        $dados = User::find(auth()->user()->id);
        $dados->password = Hash::make($request->get('password')); 
        $dados->save();
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        
        return back()->withPasswordStatus(__('Senha atualizada com sucesso.'));


    }
    public function store_atestado(Request $request){

        $user = $request->input('usuario');
        if(isset($user)){
            $user = $user;
        }else{
            $user = Auth::user()->id;
        }

        $tipo = $request->input('tipo');
        $nameFile = null;
        if ($request->hasFile('arquivo2') && $request->file('arquivo2')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->arquivo2->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->arquivo2->storeAs('public',$nameFile);           
        }

        if($tipo == 'dias'){
            $datainicio = $this->dateEmMysql($request->input('datainicio_at'));
            $datafim = $this->dateEmMysql($request->input('datafim_at'));
            $tem = Atestado::where([['datainicio', $datainicio],['users_id', $user]])->get();
            if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
            if($request->input('datainicio_at') == ''){return 'erro, Informar a data.';}
            if($request->input('datafim_at') == ''){return 'erro, Informar a data.';}
            if($nameFile == null){return 'erro, Adicione uma foto.';}


 
            $dateStart 	= new DateTime($datainicio);      
            $dateEnd 	= new DateTime($datafim);
            $dateRange = array();
            $mes = 0;
            // while($dateStart <= $dateEnd){    
            //     $mes = $dateStart->format('m');    
            //     $dateRange[] = $dateStart->format('Y-m-d');
      
            //     if($dateStart->format('N') > 5 ){
            //       return 5;
            //     }
            //     $dateStart = $dateStart->modify('+1day');           
            //      if($dateEnd->format('m') !== $mes ){
            //       return 5;
            //      }
                
            // }
            $horasf = 8*count($dateRange);

            $horasf = $horasf.':00:00';

        
            $dados = new Atestado();
            $dados->datainicio = $datainicio;
            $dados->datafim = $datafim;
            $dados->tipo = $request->input('tipo');
            $dados->horas = $horasf;
            
            $dados->foto = $nameFile;
            $dados->users_id = $user;


            $dados->save();     
            return $dados->id;  
        }

        if($tipo == 'horas'){
            $datainicio = $this->dateEmMysql($request->input('datahora'));
            $tem = Atestado::where([['datainicio', $datainicio],['users_id', Auth::user()->id]])->get();
            if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
            if($request->input('datahora') == ''){return 'erro, Informar a data.';}
            if($request->input('horas_at') == ''){return 'erro, Informar as horas.';}
            if($nameFile == null){return 'erro, Adicione o Atestado.';}
        
            $dados = new Atestado();
            $dados->datainicio = $datainicio;
            $dados->datafim = $datainicio;
            $dados->horas = $request->input('horas_at');
            $dados->tipo = $request->input('tipo');
            $dados->foto = $nameFile;
            $dados->users_id = Auth::user()->id;
            $dados->save();     
            return $dados->id;  
        }
        
    }
    public function store_ferias(Request $request){

        $datainicio = $this->dateEmMysql($request->input('datainicio'));
        $datafim = $this->dateEmMysql($request->input('datafim'));

        $tem = Feria::where([['datainicio', $datainicio],['users_id', Auth::user()->id]])->get();
        if(!count($tem) == 0){return 'erro, Já existe esse item cadastrado no sistema.';}
     
        $dados = new Feria();
        $dados->datainicio = $datainicio;
        $dados->datafim = $datafim;
        $dados->users_id = Auth::user()->id;
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
    public function delete_atestado($id){
        $deletar = Atestado::find($id);
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
    public function store_anexo(Request $request){
        $nameFile = null;
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->arquivo->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->arquivo->storeAs('public',$nameFile); 

            $dados = User::find(Auth::user()->id);
            $dados->foto = $nameFile;
            $dados->save();
          
        }
    }
    public function add_lista($add_anima){
        $dados_lista_ferias  = Feria::where('users_id', Auth::user()->id)->get();
        return view("profile.lista_ferias", compact('dados_lista_ferias','add_anima'));
    }
    public function add_lista_atestado($add_anima){
        $dados_lista_atestado  = Atestado::where('users_id', Auth::user()->id)->get();
        return view("profile.lista_atestado", compact('dados_lista_atestado','add_anima'));
    }
    public static function dateEmMysql($dateSql){
        $ano= substr($dateSql, 6);
        $mes= substr($dateSql, 3,-5);
        $dia= substr($dateSql, 0,-8);
        return $ano."-".$mes."-".$dia;
    }
    
}
