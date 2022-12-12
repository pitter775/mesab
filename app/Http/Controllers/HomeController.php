<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contrato;
use App\Models\Atividade;
use App\Models\Departamento;
use App\Models\Evento;
use App\Models\Funcao;
use App\Models\Periodo;
use App\Models\Produto;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function get_card(Request $request)
    {
        switch ($request->card) {
            case 'card_horas':
                return $this->card_horas($request);
                break;
            case 'card_pequenos':
                return $this->card_pequenos($request);
                break;
            case 'card_filtros':
                return $this->card_filtros($request);
                break;
            case 'card_contratos':
                return $this->card_contratos($request);
                break;
            case 'card_produtos':
                return $this->card_produtos($request);
                break;
            case 'card_atividades':
                return $this->card_atividades($request);
                break;
            case 'card_equipes':
                return $this->card_equipes($request);
                break;
            case 'card_alocacaos':
                return $this->card_alocacaos($request);
                break;
            case 'card_alocacaos_dep':
                return $this->card_alocacaos_dep($request);
                break;
            case 'card_funcaos':
                return $this->card_funcaos($request);
                break;
            case 'card_f_pequenos':
                return $this->card_f_pequenos($request);
                break;
            case 'card_departamentos':
                return $this->card_departamentos($request);
                break;
            case 'card_usuarios':
                return $this->card_usuarios($request);
                break;
            case 'card_user':
                return $this->card_user($request);
                break;
            case 'card_relatorio':
                return $this->card_relatorio($request);
                break;
            case 'card_relatorio_completo':
                return $this->card_relatorio_completo($request);
                break;
        }
    }

    function searchForId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
    }
    public function totalhorasmes($iduser)
    {
        $data_inicio = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $data_inicio = date('Y-m-d', $data_inicio);

        $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        $data_fim = date('Y-m-d', $data_fim);


        $eventos = DB::select(DB::raw(
            "SELECT users.id AS iduser, users.name, users.email, sum( time_to_sec (e.horas)) as total
            FROM eventos As e
            LEFT JOIN users ON users.id = e.users_id
            LEFT JOIN periodos ON periodos.id = e.periodos_id            
            WHERE periodos.datainicio BETWEEN '$data_inicio' AND '$data_fim' AND users.id = $iduser
            GROUP BY users.name DESC limit 1"
        ));
        if (isset($eventos[0]->total)) {
            return $eventos[0]->total;
        } else {
            return 0;
        }
    }
    public function ultimodia($iduser)
    {
        $ultimoregisto = DB::select(DB::raw(
            "SELECT users.id AS iduser, users.name, users.email, periodos.datafim
                FROM eventos As e
                LEFT JOIN users ON users.id = e.users_id
                LEFT JOIN periodos ON periodos.id = e.periodos_id            
                WHERE users.id = $iduser
                GROUP BY periodos.datafim DESC limit 1"
        ));

        if (isset($ultimoregisto[0]->datafim)) {
            $ultimoregistro = date('d/m/Y', strtotime($ultimoregisto[0]->datafim));
        } else {
            $ultimoregistro = '"sem dados registrados"';
        }
        return $ultimoregistro;
    }
    public function userpreenche()
    {

        $alluser = User::all();
        $userArray = [];

        foreach ($alluser as $val) {
            $horas = $this->totalhorasmes($val->id);
            $ultimodia = $this->ultimodia($val->id);
            $userArray[] = ['id' => $val->id, 'name' => $val->name, 'email' => $val->email, 'total' => $horas, 'ultimodia' => $ultimodia];
        }
        return $userArray;
    }
    public function atu_banco()
    {

        // $request = array('data_inicio' =>'01/01/2021', 'data_fim'=> '31/12/2021', 'usuario'=>32, 'contrato'=>null, 'municipio'=>null, 'produto'=>null, 'departamento'=>null, 'atividade'=>56, 'empreendimento'=>null, 'equipe'=>null, 'alocacao'=>null, 'funcao'=>null);
        // $request = (object)$request;

        // // total horas por empreendimento
        // $colunas = 'e.id AS id,  users.email, users.name, contratos.ctnome, atividades.atdescricao, e.horas, periodos.datainicio';
        // $groupBy = '';    
        // $orderBy = 'ORDER BY periodos.datainicio asc';        
        // $veratividade = $this->filtros($request, $colunas, $groupBy, $orderBy); 

        // return view('pages.teste', compact('veratividade'));  

        // ddd($veratividade);






        // $ultimoregisto = SELECT registro FROM tabela WHERE coluna = 23 ORDER BY id DESC limit 1;
        // $ultimoregisto = DB::select( DB::raw(
        //     "SELECT users.id AS iduser, users.name, users.email, periodos.datafim
        //         FROM eventos As e
        //         LEFT JOIN users ON users.id = e.users_id
        //         LEFT JOIN periodos ON periodos.id = e.periodos_id            
        //         WHERE users.id = '12'
        //         GROUP BY periodos.datafim DESC limit 1"            
        //     ));   


        // $alluser = User::all();

        // foreach($alluser  as $val){

        // }

        // $userEmails = $this->userpreenche();


        // $userEmails = $this->userpreenche();

        // ddd($userEmails);

        // // $data_inicio = date("Y-m-d");
        // // $data_fim = date("Y-m-d");
        // $data_inicio = '2021-06-15';
        // $data_fim = '2021-06-15';
        // $eventos = DB::select( DB::raw(
        //     "SELECT users.id AS iduser, users.name, users.email, sum( time_to_sec (e.horas)) as total
        //      FROM eventos As e
        //        LEFT JOIN users ON users.id = e.users_id
        //        LEFT JOIN periodos ON periodos.id = e.periodos_id             
        //        WHERE periodos.datainicio BETWEEN '$data_inicio' AND '$data_fim'
        //        GROUP BY users.name"            
        //     ));

        // $fulluser = User::orderBy('name')->get();
        // $userArray = [];
        // foreach($fulluser as $value){
        //     $userArray[] = ['id'=>$value->id, 'name'=>$value->name, 'email'=>$value->email];
        // }

        // foreach($eventos as $value){
        //     if($value->total == '28800'){ 
        //         $key = $this->searchForId($value->iduser, $userArray);
        //         if($key!==false){
        //             unset($userArray[$key]);
        //         }
        //     }
        // }

        // foreach($userArray as $value){
        //     ddd($value['name']);
        // }

        // ddd($userArray);



        $evento = Evento::all();
        foreach ($evento as $value) {
            if ($value->users_id == 42) {
                $periodo = Periodo::find($value->periodos_id);
                //   if($periodo->datainicio > '2021-02-00' &&  $periodo->datainicio < '2021-02-30'){           
                if ($periodo->datainicio >= '2022-02-01') {
                    $novo = Evento::find($value->id);
                    $novo->tarifa = '153,03';
                    // $novo->alocacaos_id = 18; //apoio 14 - obras 18 - proj pac 13 - gestao 42
                    // $novo->departamentos_id = 7; //jica 9 - M02 8 - vio 12 - me01 7
                    $novo->funcaos_id = 22; // engenheiro jr 12;  engeito seniior 11 ; tecnologo 19; engenheiro pleno 22
                    //$novo->equipes_id = 3;
                    $novo->save();
                    echo 'ok - ';
                }
                // $usuario = User::find($value->users_id);
                // $novo = Evento::find($value->id);
                // $novo->departamentos_id = $usuario->departamentos_id;
                // $novo->save();    
            }
        }
        echo '<br>';
        echo 'terminou';

        //  por favor modificar o usuario Ericles Medeiros da Silva - a partir de 01/09/2021 em diante tarifa 0, frente 2
        //  e o usuario Gustavo Nunes - a partir de 01/09/2021 em diante tarifa R$ 151,54, frente 3

        //normalmente uso esse aqui para fazer as alterações

        // $evento = Evento::all();
        //             foreach($evento as $value){
        //                 if($value->users_id == 157){
        //                      $periodo = Periodo::find($value->periodos_id);
        //                       //if($periodo->datainicio < '2020-07-31' &&  $periodo->datainicio > '2021-09-01'){
        //                      if($periodo->datainicio > '2020-11-31'){
        //                         $novo = Evento::find($value->id);
        //                        // $novo->tarifa = '123,15';
        //                         // $novo->alocacaos_id = 42; //apoio 14 - obras 18 - proj pac 13 - gestao 42
        //                         // $novo->departamentos_id = 7; //jica 9 - M02 8 - vio 12 - me01 7
        //                          $novo->funcaos_id = 20; // enjenheiro jr 12;  enjeito seniior 11, tecnologo 19 enjeiro pleno 22
        //                         // $novo->equipes_id = 3;  
        //                         $novo->save();  
        //                         echo 'ok ->'.$value->id. ' -'; 
        //                      }
        //                     // $usuario = User::find($value->users_id);
        //                     // $novo = Evento::find($value->id);
        //                     // $novo->departamentos_id = $usuario->departamentos_id;
        //                     // $novo->save();    
        //                 }

        //     }  
        //     echo '<br>';
        //     echo 'terminou';   




        //         // alterar uma atividade de um usuario em um periodo de tempo.
        //         $evento = Evento::all();
        //         $alt = true;
        //         foreach($evento as $value){
        //             if($value->users_id == 32){
        //                    // $periodo = Periodo::find($value->periodos_id);
        //                   //  if($periodo->datainicio < '2020-07-19' &&  $periodo->datainicio > '2021-07-22'){
        //                   //  $novo = Evento::find($value->id);         

        //                      if($value->atividades_id == 56){
        //                         $novo = Evento::find($value->id); 
        //                         echo  $value->atividades_id ;      
        //                         if($alt){                                
        //                             $novo->atividades_id = 18;                               
        //                             $novo->save();  
        //                             echo 'ok ->'.$value->id. ' -'; 
        //                             $alt = false;
        //                         }else{
        //                             $alt = true;
        //                         }
        //                      }
        //                  //   }
        //             }

        // }  
        // echo '<br>';
        // echo 'terminou';   


        // return $this->separa_datas('2020-01-01','2020-05-01');


        // $datas = [];

        // $dividir_datas = $this->separa_datas('2015-01-01','2020-05-10');  
        // // if($dividir_datas){
        // //     foreach($dividir_datas as $value2){
        // //         array_push($datas, $value2);
        // //     }
        // // } 

        // return $dividir_datas;




        // $antigo = Periodos_back::all();
        // foreach($antigo as $value){
        //     $perhoras = '00:00:00';
        //     $novo = new Periodo();
        //     $eventos = Eventos_back::where('periodos_id',$value->id)->first();
        //     $novo->id = $value->id;
        //     $novo->datainicio = $value->datainicio;            
        //     $novo->datafim = date('Y-m-d', strtotime('-1 days', strtotime($value->datafim))); 
        //     $novo->created_at = $value->created_at;
        //     $novo->created_at = $value->updated_at;
        //     if(isset($value->periodototal)){
        //         if(strlen($value->periodototal) == 1){ $perhoras =  '0'.$value->periodototal.':00:00';}
        //         if(strlen($value->periodototal) == 2){ $perhoras =  $value->periodototal.':00:00';}
        //         if(strlen($value->periodototal) == 3){ $perhoras =  $value->periodototal.':00:00';}
        //         if(substr($value->periodototal,0,1) == '-') {$perhoras = '00:00:00';}
        //     }
        //     $novo->perhoras = $perhoras;
        //     $novo->perstatus = $value->perstatus;
        //     $novo->users_id = isset($eventos->users_id) ? $eventos->users_id : '12';
        //     $novo->save();  

        // 19/05/21
        // }

        // $antigo = Eventos_back::all();
        // foreach($antigo as $value){
        //     // $horas = '00:00:00';
        //     if($value->periodos_id !== 0){
        //         if($value->atividades_id !== 26 && $value->atividades_id !== 20 && $value->atividades_id !== 32){
        //             if($value->produtos_id !== 12 && $value->produtos_id !== 8 && $value->produtos_id !== 17 ){
        //                 $novo = new Evento();
        //                 $usuario = User::find($value->users_id);
        //                 $novo->id = $value->id;
        //                 $novo->periodos_id = $value->periodos_id;

        //                 // if(isset($value->horas)){
        //                 //     if(strlen($value->horas) == 1){ $horas =  '0'.$value->horas.':00:00';}
        //                 //     if(strlen($value->horas) == 2){ $horas =  $value->horas.':00:00';}
        //                 //     if(strlen($value->horas) == 3){ $horas =  $value->horas.':00:00';}
        //                 // }

        //                 $novo->horas = $value->horas;
        //                 $novo->created_at = $value->created_at;
        //                 $novo->created_at = $value->updated_at;
        //                 $novo->atividades_id = $value->atividades_id;
        //                 $novo->produtos_id = $value->produtos_id;
        //                 $novo->contratos_id = $value->contratos_id;                        
        //                 $novo->equipes_id =  $usuario->equipes_id;
        //                 $novo->departamentos_id = $usuario->departamentos_id;
        //                 $novo->funcaos_id = $usuario->funcaos_id;
        //                 $novo->alocacaos_id = $usuario->alocacaos_id;
        //                 $novo->tarifa = $usuario->tarifa;
        //                 $novo->users_id = $value->users_id;
        //                 $novo->save();
        //             }  
        //         }
        //     }
        // }

        // $antigo = Contrato_site_produtos_back::all();
        // $sites_contr = Contrato_sites_back::all();
        // $contratos = Contrato::all();
        // foreach($antigo as $value){
        //      if($value->sites_id !== 23){                 
        //     //         if($value->produtos_id !== 12 && $value->produtos_id !== 8 && $value->produtos_id !== 17 ){
        //                 $novo = new Contrato_produto();
        //                 $cad = false;
        //                 $novo->id = $value->id;
        //                 $novo->contratos_id = 16;
        //                 foreach ($sites_contr as $value2){                          
        //                     if($value2->id == $value->contrato_site_id){                          
        //                         $novo->contratos_id = $value2->contratos_id;
        //                     }                            
        //                 }                        
        //                 $novo->produtos_id = $value->produtos_id;
        //                 $novo->cspstatus = $value->cspstatus;
        //                 $novo->created_at = $value->created_at;
        //                 $novo->created_at = $value->updated_at;
        //                 $novo->users_id_atualizou = 12;
        //                 foreach($contratos as $cont){
        //                     if($novo->contratos_id == $cont->id){
        //                         $novo->save();
        //                     }
        //                 }
        //             }  
        //     //     }
        // }

        // $antigo_prd_atv = Contrato_site_produto_atividades_back::all();
        // $novo_prd = Contrato_produto::all();
        // $novo_atv = Atividade::all();
        //     foreach($antigo_prd_atv as $value){
        //         $novo = new contrato_produto_atividade();   

        //         $novo->id = $value->id;
        //         $novo->contrato_produtos_id = $value->contrato_site_produto_id;
        //         $novo->atividades_id = $value->atividades_id;
        //         $novo->cspastatus = $value->cspastatus;
        //         $novo->created_at = $value->created_at;
        //         $novo->updated_at = $value->updated_at;
        //         $novo->users_id_atualizou = 12;

        //         foreach($novo_prd as $pord){
        //             if($pord->id == $novo->contrato_produtos_id){
        //                 foreach($novo_atv as $at){
        //                     if($novo->atividades_id == $at->id){
        //                         $novo->save();
        //                     }                            
        //                 }

        //             }
        //         }
        //  }

        // return $valor = $this->tarifa_segundos('183.35', '28800');

        // $request = array('data_inicio' =>'01/03/2021', 'data_fim'=> '31/03/2021', 'usuario'=>188, 'contrato'=>null, 'municipio'=>null, 'produto'=>null, 'departamento'=>null, 'atividade'=>null, 'empreendimento'=>null, 'equipe'=>null, 'alocacao'=>null, 'funcao'=>null);
        // $request = (object)$request;

        // // total horas por empreendimento
        // $colunas = 'users.id AS idempreen, users.tarifa, users.name, sum( time_to_sec (e.horas)) as total';
        // $groupBy = 'GROUP BY users.name';    
        // $orderBy = 'ORDER BY users.name ASC, periodos.datainicio ASC';        
        // $lista_empreendimentos_horas2 = $this->filtros($request, $colunas, $groupBy, $orderBy); 


        // foreach($lista_empreendimentos_horas2 as $value){
        //     // total pess por empreendimento
        //     $colunas = 'e.id AS id, users.tarifa, e.horas, users.id AS idempri, users.name';
        //     $groupBy = ''; 
        //     $orderBy = '';   
        //     $orderBy = '';
        //     $filtro_ext = 'users.id = '.$value->idempreen; 
        //     $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy,$filtro_ext);    

        //     $soma_valores = 0;
        //     $soma_segundos = 0;
        //     foreach($pessoas_horas as $value2){  
        //         $segundos = $this->converte_segundos($value2->horas);
        //         $tarifa = trim($value2->tarifa);
        //         $valor = $this->tarifa_segundos($tarifa, $segundos);
        //         echo $tarifa;
        //         echo '-';
        //         echo $segundos;
        //         echo '-';
        //         echo $valor;
        //         echo '<br>';            
        //         $soma_valores = $soma_valores + $valor;
        //         $soma_segundos =  $soma_segundos + $segundos;
        //     }

        //     echo ' - segundos: '.$soma_segundos,' -- '.$value->name.' - valor:'.$soma_valores;
        //     echo '<br>';
        //     // echo '<pre>';
        //     // var_dump($valores);
        //     // echo '</pre>';

        // }

    }
    public static function dateEmMysql($dateSql)
    {
        $ano = substr($dateSql, 6);
        $mes = substr($dateSql, 3, -5);
        $dia = substr($dateSql, 0, -8);
        return $ano . "-" . $mes . "-" . $dia;
    }
    public function index()
    {

        $datainicio = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $datafim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        $datainicio = date('d/m/Y', $datainicio);
        $datafim = date('d/m/Y', $datafim);

        return view('pages.home.home', compact('datainicio', 'datafim'));
    }
    public function card_filtros(Request $request)
    {


        $filtros = [];

        if ($request->usuario != null) {
            $filtros['usuario'] = $request->usuario;
        }
       
        if ($request->funcao != null) {
            $filtros['funcao'] = $request->funcao;
        }
        if ($request->contrato != null) {
            $filtros['contrato'] = $request->contrato;
        }
        
        if ($request->atividade != null) {
            $filtros['atividade'] = $request->atividade;
        }
        
        if ($request->departamento != null) {
            $filtros['departamento'] = $request->departamento;
        }
        

        $colunas = 'users.id AS id, users.name, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY users.name';
        $orderBy = 'ORDER BY users.name ASC';
        // $usuarios = $this->filtros($request, $colunas, $groupBy, $orderBy); 
        $usuarios = User::orderBy('name')->get();

        $colunas = 'funcaos.id AS id, funcaos.fndescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY funcaos.fndescricao';
        $orderBy = 'ORDER BY funcaos.fndescricao ASC';
        // $funcaos = $this->filtros($request, $colunas, $groupBy, $orderBy); 
        $funcaos = Funcao::orderBy('fndescricao')->get();

        $colunas = 'contratos.id AS id, contratos.ctnome, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY contratos.ctnome';
        $orderBy = 'ORDER BY contratos.ctnome ASC';
        // $contratos = $this->filtros($request, $colunas, $groupBy, $orderBy); 
        $contratos = Contrato::orderBy('ctnome')->get();

        $colunas = 'atividades.id AS id, atividades.atdescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY atividades.atdescricao';
        $orderBy = 'ORDER BY atividades.atdescricao ASC';
        // $atividades = $this->filtros($request, $colunas, $groupBy, $orderBy); 
        $atividades = Atividade::orderBy('atdescricao')->get();

        $colunas = 'departamentos.id AS id, departamentos.depnome, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY departamentos.depnome';
        $orderBy = 'ORDER BY departamentos.depnome ASC';
        // $departamentos = $this->filtros($request, $colunas, $groupBy, $orderBy); 
        $departamentos = Departamento::orderBy('depnome')->get();


        return view('pages.home.card_filtros', compact('usuarios', 'contratos', 'atividades', 'funcaos', 'departamentos', 'filtros'));
    }
    public function filtros($request, $colunas, $groupBy, $orderBy = '', $filtro_ext = '')
    {
        $data_inicio = $this->dateEmMysql($request->data_inicio);
        $data_fim = $this->dateEmMysql($request->data_fim);
        // $data_inicio = $this->dateEmMysql('01/03/2021');
        // $data_fim = $this->dateEmMysql('31/03/2021');

        $filtro = '';
        $and = '';
        $and_or = 'AND';

        if ($data_inicio != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where periodos.datainicio BETWEEN '$data_inicio' AND '$data_fim'";
        }
        if ($data_fim != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where periodos.datafim BETWEEN '$data_inicio' AND '$data_fim'";
        }
        if ($filtro_ext != '') {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where $filtro_ext ";
        }

        if ($request->usuario != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where users.id = '$request->usuario' ";
        }
        if ($request->contrato != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where contratos.id = '$request->contrato' ";
        }   
        if ($request->atividade != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where atividades.id = '$request->atividade' ";
        }
      

        if ($request->funcao != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where e.funcaos_id = '$request->funcao' ";
        }
        if ($request->departamento != null) {
            if ($filtro != null) {
                $and = ' AND';
            }
            if ($filtro == null) {
                $where = 'WHERE';
            } else {
                $where = '';
            }
            $filtro .= " $and $where e.departamentos_id = '$request->departamento' ";
        }
       
        $eventos = DB::select(DB::raw(
            "SELECT $colunas
             FROM eventos As e
               LEFT JOIN users ON users.id = e.users_id
               LEFT JOIN periodos ON periodos.id = e.periodos_id
               LEFT JOIN contratos ON contratos.id = e.contratos_id             
               LEFT JOIN atividades ON atividades.id = e.atividades_id
               LEFT JOIN funcaos ON funcaos.id = e.funcaos_id
               LEFT JOIN departamentos ON departamentos.id = e.departamentos_id
               
               $filtro
               $groupBy
               $orderBy"
        ));
        return $eventos;
    }
    public function card_horas(Request $request)
    {
        //total tarifa por usuario
        $colunas = 'e.id AS id, e.users_id, e.horas, e.tarifa';
        $groupBy = '';
        $pessoas_horas = $this->filtros($request, $colunas, $groupBy);
        $soma_valor = '0.00';

        foreach ($pessoas_horas as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $tarifa = trim($value->tarifa);
            $valor = $this->tarifa_segundos($tarifa, $segundos);
            $soma_valor = $soma_valor + $valor;
        }
        $soma_valor = number_format($soma_valor, 2, ',', '.');



        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $resultado = $this->filtros($request, $colunas, $groupBy);

        //lista de eventos
        $colunas = 'e.id AS id, periodos.datainicio,  periodos.datafim, e.horas';
        $groupBy = '';
        $orderBy = '';
        $lista_datas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //dividir periodo por data 
        $datas = [];

        foreach ($lista_datas as $value) {
            $dividir_datas = $this->separa_datas($value->datainicio, $value->datafim);
            if ($dividir_datas) {
                foreach ($dividir_datas as $value2) {
                    array_push($datas, $value2);
                }
            }
        }
        $dias1 = array_unique($datas);
        $total_dias = count($dias1);

        //total de pessoas
        $colunas = 'e.id AS id';
        $groupBy = 'GROUP BY e.users_id;';
        $pessoas = $this->filtros($request, $colunas, $groupBy);


        return view('pages.home.card_horas', compact('resultado', 'total_dias', 'pessoas', 'soma_valor'));
    }
    public function card_contratos_old(Request $request)
    {
        // total horas por contrato
        $colunas = 'contratos.id AS id, contratos.ctnome, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY contratos.ctnome';
        $orderBy = 'ORDER BY total desc';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        return view('pages.home.card_contratos', compact('lista_contratos_horas', 'total_horas'));
    }
    public function card_contratos(Request $request)
    {

        $tipo_contrato = $request->param;

        // total horas por empreendimento
        $colunas = 'contratos.id AS idempreen, users.id, e.tarifa, contratos.ctnome, contratos.cttipo, contratos.ctnumero, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY contratos.ctnome';
        $orderBy = 'ORDER BY contratos.ctnome ASC, periodos.datainicio ASC';
        $filtro_ext = null;
        if ($tipo_contrato) {
            $filtro_ext = "contratos.cttipo = '" . $tipo_contrato . "'";
        }

        $lista_empreendimentos_horas2 = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

        //total de custo por empreendimento
        $lista_contratos = [];
        $tipo_hora = 0;
        $tipo_valor = 0;
        foreach ($lista_empreendimentos_horas2 as $value) {
            // total pess por empreendimento
            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, contratos.id AS idempri, contratos.ctnome';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'contratos.id = ' . $value->idempreen;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);
            $pess = [];
            $soma_valores = 0;
            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);
                $pess[] = $value2->users_id;
                $soma_valores = $soma_valores + $valor;
                $tipo_hora = $tipo_hora +  $segundos;
                $tipo_valor = $tipo_valor +  $valor;
            }
            $pess_unicos = array_unique($pess);
            $soma_valores = number_format($soma_valores, 2, ',', '.');
            $lista_contratos[] = ['id' => $value->idempreen, 'ctnome' => $value->ctnumero . ' - ' . $value->ctnome, 'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos)];
        }

        $tipo_valor = number_format($tipo_valor, 2, ',', '.');
        $lista_contratos = collect($lista_contratos)->sortBy('total')->reverse()->toArray();

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        //total tarifa por usuario
        $colunas = 'e.id AS id, e.users_id, e.horas, e.tarifa';
        $groupBy = '';
        $pessoas_horas = $this->filtros($request, $colunas, $groupBy);
        $soma_valor = '0.00';



        foreach ($pessoas_horas as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $tarifa = trim($value->tarifa);
            $valor = $this->tarifa_segundos($tarifa, $segundos);
            $soma_valor = $soma_valor + $valor;
        }
        $soma_valor = number_format($soma_valor, 2, ',', '.');

        $contrato_ativo = $tipo_contrato;

        return view('pages.home.card_contratos', compact('soma_valor', 'total_horas', 'lista_contratos', 'contrato_ativo', 'tipo_hora', 'tipo_valor'));
    }
    public function card_produtos(Request $request)
    {
        // total horas por contrato
        $colunas = 'produtos.id AS id, produtos.prdescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY produtos.prdescricao';
        $orderBy = 'ORDER BY total desc';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        return view('pages.home.card_produtos', compact('lista_contratos_horas', 'total_horas'));
    }
    public function card_atividades(Request $request)
    {

        $lista_prod = Produto::orderBy('id', 'asc')->get();

        // total horas por contrato
        $colunas = 'atividades.id AS idativi, atividades.atdescricao, produtos.prdescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY atividades.atdescricao';
        $orderBy = 'ORDER BY total desc';
        $lista_atividades2 = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total de custo por atividade
        $lista_atividades = [];
        $tipo_hora = 0;
        $tipo_valor = 0;
        $tipo_pess = [];
        foreach ($lista_atividades2 as $value) {
            // total pess por atividade
            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, atividades.id AS idati, atividades.atdescricao, produtos.id as idprod, produtos.prdescricao';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'atividades.id = ' . $value->idativi;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

            $pess = [];
            $soma_valores = 0;
            $soma_hora = 0;
            $tipo_produto = [];
            $valor = 0;
            $tarifa = 0;
            $segundos = 0;
            //  $prod_14_hs = 0; $prod_14_vl = 0; //relatorios
            //  $prod_16_hs = 0; $prod_16_vl = 0; //desenvolvimento
            $prod_18_hs = 0;
            $prod_18_vl = 0; //orgaos e concessionarias
            $prod_22_hs = 0;
            $prod_22_vl = 0; //projetos
            $prod_47_hs = 0;
            $prod_47_vl = 0; //modelo bim
            $prod_48_hs = 0;
            $prod_48_vl = 0; //obra
            $prod_50_hs = 0;
            $prod_50_vl = 0; //geral
            $prod_51_hs = 0;
            $prod_51_vl = 0; //pacote tecnico
            $prod_t_hs = 0;
            $prod_t_vl = 0; //pacote tecnico
            $prod_52_hs = 0;
            $prod_52_vl = 0; //Pós-Obra

            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);
                $pess[] = $value2->users_id;
                $tipo_pess[] = $value2->users_id;
                $soma_valores = $soma_valores + $valor;
                $tipo_hora = $tipo_hora +  $segundos;
                $soma_hora = $soma_hora +  $segundos;
                $tipo_valor = $tipo_valor +  $valor;
                foreach ($lista_prod as $val) {
                    if ($val->id == $value2->idprod) {
                        if ($value2->idprod == 18) {
                            $prod_18_hs = $prod_18_hs +  $segundos;
                            $prod_18_vl = $prod_18_vl +  $valor;
                        }
                        if ($value2->idprod == 22) {
                            $prod_22_hs = $prod_22_hs +  $segundos;
                            $prod_22_vl = $prod_22_vl +  $valor;
                        }
                        if ($value2->idprod == 47) {
                            $prod_47_hs = $prod_47_hs +  $segundos;
                            $prod_47_vl = $prod_47_vl +  $valor;
                        }
                        if ($value2->idprod == 48) {
                            $prod_48_hs = $prod_48_hs +  $segundos;
                            $prod_48_vl = $prod_48_vl +  $valor;
                        }
                        if ($value2->idprod == 50) {
                            $prod_50_hs = $prod_50_hs +  $segundos;
                            $prod_50_vl = $prod_50_vl +  $valor;
                        }
                        if ($value2->idprod == 51) {
                            $prod_51_hs = $prod_51_hs +  $segundos;
                            $prod_51_vl = $prod_51_vl +  $valor;
                        }
                        if ($value2->idprod == 51) {
                            $prod_52_hs = $prod_52_hs +  $segundos;
                            $prod_52_vl = $prod_52_vl +  $valor;
                        }
                    }
                }
            }
            //  $tipo_produto[14] = ['hs'=>$prod_14_hs, 'vl'=>$prod_14_vl];
            //  $tipo_produto[16] = ['hs'=>$prod_16_hs, 'vl'=>$prod_16_vl];
            $tipo_produto[18] = ['hs' => $prod_18_hs, 'vl' => $prod_18_vl, 'nome' => 'Órgãos e Concessionárias'];
            $tipo_produto[22] = ['hs' => $prod_22_hs, 'vl' => $prod_22_vl, 'nome' => 'Projetos'];
            $tipo_produto[47] = ['hs' => $prod_47_hs, 'vl' => $prod_47_vl, 'nome' => 'Modelos BIM'];
            $tipo_produto[48] = ['hs' => $prod_48_hs, 'vl' => $prod_48_vl, 'nome' => 'Obra'];
            $tipo_produto[50] = ['hs' => $prod_50_hs, 'vl' => $prod_50_vl, 'nome' => 'Geral'];
            $tipo_produto[51] = ['hs' => $prod_51_hs, 'vl' => $prod_51_vl, 'nome' => 'Pacote Técnico'];
            $tipo_produto[52] = ['hs' => $prod_52_hs, 'vl' => $prod_52_vl, 'nome' => 'Pós-Obra'];
            $tipo_produto[99] = ['hs' => $soma_hora, 'vl' => $soma_valores, 'nome' => 'Total'];

            $pess_unicos = array_unique($pess);
            $lista_atividades[] = ['id' => $value->idativi, 'atdescricao' => $value->atdescricao,  'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos), 'tipoprod' => $tipo_produto];
        }

        //  dd($lista_atividades);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        //total tarifa por usuario
        $colunas = 'e.id AS id, e.users_id, e.horas, e.tarifa';
        $groupBy = '';
        $pessoas_horas = $this->filtros($request, $colunas, $groupBy);
        $soma_valor = '0.00';

        foreach ($pessoas_horas as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $tarifa = trim($value->tarifa);
            $valor = $this->tarifa_segundos($tarifa, $segundos);
            $soma_valor = $soma_valor + $valor;
        }
        $soma_valor = number_format($soma_valor, 2, ',', '.');



        return view('pages.home.card_atividades', compact('lista_atividades', 'total_horas', 'soma_valor', 'lista_prod'));
    }
    public function card_alocacaosDep(Request $request)
    {

        // $lista_dep = Departamento::orderBy('id', 'asc')->get();
        $lista_dep = Departamento::select('id', 'depnome')->get();

        // total horas por alocacao
        $colunas = 'alocacaos.id AS idaloc, alocacaos.aldescricao, departamentos.depnome, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY alocacaos.aldescricao';
        $orderBy = 'ORDER BY total desc';
        $lista_alocacaos2 = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total de custo por atividade
        $lista_alocacaos = [];
        $tipo_hora = 0;
        $tipo_valor = 0;
        $tipo_pess = [];
        foreach ($lista_alocacaos2 as $value) {
            // total pess por atividade
            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, alocacaos.id AS idati, alocacaos.aldescricao, departamentos.id as iddep, departamentos.depnome';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'alocacaos.id = ' . $value->idaloc;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

            $pess = [];
            $soma_valores = 0;
            $soma_hora = 0;
            $tipo_departamento = [];
            $valor = 0;
            $tarifa = 0;
            $segundos = 0;




            $dep_3_hs = 0;
            $dep_3_vl = 0; //MEQ  
            $dep_4_hs = 0;
            $dep_4_vl = 0; //MEP
            $dep_5_hs = 0;
            $dep_5_vl = 0; //MES
            $dep_6_hs = 0;
            $dep_6_vl = 0; //ME
            $dep_7_hs = 0;
            $dep_7_vl = 0; //ME-01
            $dep_8_hs = 0;
            $dep_8_vl = 0; //ME-02
            $dep_9_hs = 0;
            $dep_9_vl = 0; //Jica
            $dep_10_hs = 0;
            $dep_10_vl = 0; //Inovasan
            $dep_11_hs = 0;
            $dep_11_vl = 0; //Outros
            $dep_12_hs = 0;
            $dep_12_vl = 0; //Vio     
            $dep_14_hs = 0;
            $dep_14_vl = 0; //Tev
            $dep_15_hs = 0;
            $dep_15_vl = 0; //Cetesb
            $dep_16_hs = 0;
            $dep_16_vl = 0; //Pura



            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);
                $pess[] = $value2->users_id;
                $tipo_pess[] = $value2->users_id;
                $soma_valores = $soma_valores + $valor;
                $tipo_hora = $tipo_hora +  $segundos;
                $soma_hora = $soma_hora +  $segundos;
                $tipo_valor = $tipo_valor +  $valor;
                foreach ($lista_dep as $val) {
                    if ($val->id == $value2->iddep) {
                        if ($value2->iddep == 3) {
                            $dep_3_hs = $dep_3_hs +  $segundos;
                            $dep_3_vl = $dep_3_vl +  $valor;
                        }
                        if ($value2->iddep == 4) {
                            $dep_4_hs = $dep_4_hs +  $segundos;
                            $dep_4_vl = $dep_4_vl +  $valor;
                        }
                        if ($value2->iddep == 5) {
                            $dep_5_hs = $dep_5_hs +  $segundos;
                            $dep_5_vl = $dep_5_vl +  $valor;
                        }
                        if ($value2->iddep == 6) {
                            $dep_6_hs = $dep_6_hs +  $segundos;
                            $dep_6_vl = $dep_6_vl +  $valor;
                        }

                        if ($value2->iddep == 7) {
                            $dep_7_hs = $dep_7_hs +  $segundos;
                            $dep_7_vl = $dep_7_vl +  $valor;
                        }
                        if ($value2->iddep == 8) {
                            $dep_8_hs = $dep_8_hs +  $segundos;
                            $dep_8_vl = $dep_8_vl +  $valor;
                        }
                        if ($value2->iddep == 9) {
                            $dep_9_hs = $dep_9_hs +  $segundos;
                            $dep_9_vl = $dep_9_vl +  $valor;
                        }
                        if ($value2->iddep == 10) {
                            $dep_10_hs = $dep_10_hs +  $segundos;
                            $dep_10_vl = $dep_10_vl +  $valor;
                        }
                        if ($value2->iddep == 11) {
                            $dep_11_hs = $dep_11_hs +  $segundos;
                            $dep_11_vl = $dep_11_vl +  $valor;
                        }
                        if ($value2->iddep == 12) {
                            $dep_12_hs = $dep_12_hs +  $segundos;
                            $dep_12_vl = $dep_12_vl +  $valor;
                        }
                        if ($value2->iddep == 14) {
                            $dep_14_hs = $dep_14_hs +  $segundos;
                            $dep_14_vl = $dep_14_vl +  $valor;
                        }
                        if ($value2->iddep == 15) {
                            $dep_15_hs = $dep_15_hs +  $segundos;
                            $dep_15_vl = $dep_15_vl +  $valor;
                        }
                        if ($value2->iddep == 16) {
                            $dep_16_hs = $dep_16_hs +  $segundos;
                            $dep_16_vl = $dep_16_vl +  $valor;
                        }
                    }
                }
            }
            $tipo_departamento[3] = ['hs' => $dep_3_hs, 'vl' => $dep_3_vl, 'nome' => 'MEQ'];
            $tipo_departamento[4] = ['hs' => $dep_4_hs, 'vl' => $dep_4_vl, 'nome' => 'MEP'];
            $tipo_departamento[5] = ['hs' => $dep_5_hs, 'vl' => $dep_5_vl, 'nome' => 'MES'];
            $tipo_departamento[6] = ['hs' => $dep_6_hs, 'vl' => $dep_6_vl, 'nome' => 'ME'];
            $tipo_departamento[7] = ['hs' => $dep_7_hs, 'vl' => $dep_7_vl, 'nome' => 'ME-01'];
            $tipo_departamento[8] = ['hs' => $dep_8_hs, 'vl' => $dep_8_vl, 'nome' => 'ME-02'];
            $tipo_departamento[9] = ['hs' => $dep_9_hs, 'vl' => $dep_9_vl, 'nome' => 'Jica'];
            $tipo_departamento[10] = ['hs' => $dep_10_hs, 'vl' => $dep_10_vl, 'nome' => 'Inovasan'];
            $tipo_departamento[11] = ['hs' => $dep_11_hs, 'vl' => $dep_11_vl, 'nome' => 'Outros'];
            $tipo_departamento[12] = ['hs' => $dep_12_hs, 'vl' => $dep_12_vl, 'nome' => 'Vio'];
            $tipo_departamento[14] = ['hs' => $dep_14_hs, 'vl' => $dep_14_vl, 'nome' => 'Tev'];
            $tipo_departamento[15] = ['hs' => $dep_15_hs, 'vl' => $dep_15_vl, 'nome' => 'Cetesb'];
            $tipo_departamento[16] = ['hs' => $dep_16_hs, 'vl' => $dep_16_vl, 'nome' => 'Pura'];
            $tipo_departamento[99] = ['hs' => $soma_hora, 'vl' => $soma_valores, 'nome' => 'Total'];


            $pess_unicos = array_unique($pess);
            $lista_alocacaos[] = ['id' => $value->idaloc, 'aldescricao' => $value->aldescricao,  'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos), 'tipodep' => $tipo_departamento];
        }

        // dd($lista_alocacaos);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        //total tarifa por usuario
        $colunas = 'e.id AS id, e.users_id, e.horas, e.tarifa';
        $groupBy = '';
        $pessoas_horas = $this->filtros($request, $colunas, $groupBy);
        $soma_valor = '0.00';

        foreach ($pessoas_horas as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $tarifa = trim($value->tarifa);
            $valor = $this->tarifa_segundos($tarifa, $segundos);
            $soma_valor = $soma_valor + $valor;
        }
        $soma_valor = number_format($soma_valor, 2, ',', '.');

        return view('pages.home.card_alocacaosDep', compact('lista_alocacaos', 'total_horas', 'soma_valor', 'lista_dep'));
    }
    public function card_equipes(Request $request)
    {
        // total horas por contrato
        $colunas = 'equipes.id AS id, equipes.eqnome, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY equipes.eqnome';
        $orderBy = 'ORDER BY equipes.eqnome ASC';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        return view('pages.home.card_equipes', compact('lista_contratos_horas', 'total_horas'));
    }
    public function card_alocacaos(Request $request)
    {
        // total horas por contrato
        $colunas = 'alocacaos.id AS id, alocacaos.aldescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY alocacaos.aldescricao';
        $orderBy = 'ORDER BY total desc';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);



        // tranzendo o custo 
        $cont = 0;
        foreach ($lista_contratos_horas as $value) {

            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, alocacaos.id AS idaloc, alocacaos.aldescricao';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'alocacaos.id = ' . $value->id;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

            $pess = [];
            $soma_valores = 0;
            $soma_hora = 0;
            $valor = 0;
            $tarifa = 0;
            $segundos = 0;

            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);

                $pess[] = $value2->users_id;

                $soma_valores = $soma_valores + $valor;
                $soma_hora = $soma_hora +  $segundos;
            }
            // $soma_valores = number_format($soma_valores,2, ',', '.');
            $pess_unicos = array_unique($pess);
            $lista_alocacoes[] = ['id' => $value->id, 'aldescricao' => $value->aldescricao,  'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos)];
            $cont =   $cont + 1;
        }


        $lista_alocacoes = (object) $lista_alocacoes;

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);


        return view('pages.home.card_alocacaos', compact('lista_alocacoes', 'total_horas', 'lista_contratos_horas'));
    }
    public function card_alocacaos_dep(Request $request)
    {
        $tipo_produto = $request->param;

        // Departamentos
        $colunas = 'departamentos.id AS id, departamentos.depnome';
        $groupBy = 'GROUP BY departamentos.depnome';
        $orderBy = 'ORDER BY departamentos.depnome ASC';
        $departamentos = $this->filtros($request, $colunas, $groupBy, $orderBy);


        if ($tipo_produto == '') {
            $tipo_produto = $departamentos[0]->depnome;
        }

        // total horas por contrato
        $colunas = 'alocacaos.id AS id, departamentos.depnome, alocacaos.aldescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY alocacaos.aldescricao';
        $orderBy = 'ORDER BY total desc';
        $filtro_ext = null;
        if ($tipo_produto) {
            $filtro_ext = "departamentos.depnome = '" . $tipo_produto . "'";
        }
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

        $totaldep = 0;
        $cont = 0;
        $totaldepH = 0;
        $totaldepR = 0;
        $lista_alocacoes[] = '';
        foreach ($lista_contratos_horas as $value) {
            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, alocacaos.id AS idaloc, alocacaos.aldescricao';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'alocacaos.id = ' . $value->id;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

            $pess = [];
            $soma_valores = 0;
            $soma_hora = 0;
            $valor = 0;
            $tarifa = 0;
            $segundos = 0;


            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);

                $pess[] = $value2->users_id;

                $soma_valores = $soma_valores + $valor;
                $soma_hora = $soma_hora +  $segundos;
            }
            $pess_unicos = array_unique($pess);
            $lista_alocacoes[] = ['id' => $value->id, 'aldescricao' => $value->aldescricao,  'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos)];
            $cont =   $cont + 1;
            $totaldepH = $totaldepH + $soma_hora;
            $totaldepR = $totaldepR + $soma_valores;
        }


        //total tarifa por usuario
        $colunas = 'e.id AS id, e.users_id, e.horas, e.tarifa';
        $groupBy = '';
        $pessoas_horas = $this->filtros($request, $colunas, $groupBy);
        $soma_valor_t = '0.00';

        foreach ($pessoas_horas as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $tarifa = trim($value->tarifa);
            $valor = $this->tarifa_segundos($tarifa, $segundos);
            $soma_valor_t = $soma_valor_t + $valor;
        }

        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);



        return view('pages.home.card_alocacaos_dep', compact('lista_contratos_horas', 'total_horas', 'soma_valor_t', 'departamentos', 'tipo_produto', 'lista_alocacoes', 'totaldepH', 'totaldepR'));
    }
    public function card_funcaos(Request $request)
    {
        // total horas por contrato
        $colunas = 'funcaos.id AS id, funcaos.fndescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY funcaos.fndescricao';
        $orderBy = 'ORDER BY total desc';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        return view('pages.home.card_funcaos', compact('lista_contratos_horas', 'total_horas'));
    }
    public function card_departamentos(Request $request)
    {
        // total horas por contrato
        $colunas = 'departamentos.id AS id, departamentos.depnome, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY departamentos.depnome';
        $orderBy = 'ORDER BY total desc';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        return view('pages.home.card_departamentos', compact('lista_contratos_horas', 'total_horas'));
    }

    public function card_relatorio(Request $request)
    {

        $data_inicio = $this->dateEmMysql($request->data_inicio);
        $data_fim = $this->dateEmMysql($request->data_fim);
        $dividir_datas = $this->separa_datas($data_inicio, $data_fim);

        $datas_meses = [];
        $primeiro_dia = '';
        $ultimo_dia = '';
        $cont_datas = 0;
        $muda_mes = '';
        foreach ($dividir_datas as $datas) {
            $mes = explode("-", $datas);
            if ($cont_datas == 0) {
                $primeiro_dia =  $datas;
            }
            if ($muda_mes == '') {
                $muda_mes = $mes[1];
            }
            if ($muda_mes !== $mes[1]) {
                $ultimo_dia = $dividir_datas[$cont_datas - 1];
                $primeiro_dia = $primeiro_dia;
                $datas_meses[] = ['primeiro_dia' => $primeiro_dia, 'ultimo_dia' => $ultimo_dia];
                $muda_mes = $mes[1];
                $primeiro_dia =  $datas;
            }
            $cont_datas = $cont_datas + 1;

            if (count($dividir_datas) == $cont_datas) {
                // dd($datas_meses);
                $ultimo_dia = $dividir_datas[$cont_datas - 1];
                $datas_meses[] = ['primeiro_dia' => $primeiro_dia, 'ultimo_dia' => $ultimo_dia];
            }
        }



        $lista_usuario_mes = [];

        foreach ($datas_meses as $datas) {
            $request->data_inicio = date('d/m/Y', strtotime($datas['primeiro_dia']));
            $request->data_fim = date('d/m/Y', strtotime($datas['ultimo_dia']));
            $colunas = 'users.id AS idempreen, users.name, users.email, sum( time_to_sec (e.horas)) as total, funcaos.fndescricao';
            $groupBy = 'GROUP BY users.name';
            $orderBy = 'ORDER BY users.name ASC';
            $lista_usuarios = $this->filtros($request, $colunas, $groupBy, $orderBy);
            $lista_usuarios_data = [];


            foreach ($lista_usuarios as $value) {
                $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, users.id AS idempri, users.name';
                $groupBy = '';
                $orderBy = '';
                $orderBy = '';
                $filtro_ext = 'users.id = ' . $value->idempreen;
                $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

                $soma_valores = 0;
                foreach ($pessoas_horas as $value2) {
                    $segundos = $this->converte_segundos($value2->horas);
                    $tarifa = trim($value2->tarifa);
                    $valor = $this->tarifa_segundos($tarifa, $segundos);

                    $soma_valores = $soma_valores + $valor;
                }

                $soma_valores = number_format($soma_valores, 2, ',', '.');
                $lista_usuarios_data[] = ['id' => $value->idempreen, 'name' => $value->name, 'cargo' => $value->fndescricao,  'data_inicio' => $datas['primeiro_dia'], 'data_fim' => $datas['ultimo_dia'], 'total' => $value->total, 'custo' => $soma_valores];
            }
            $lista_usuario_mes[] = ['lista_user' => $lista_usuarios_data];
        }
        return view('pages.home.card_relatorio', compact('lista_usuario_mes'));
    }
    public function card_usuarios(Request $request)
    {

        $tipo_produto = $request->param;


        // total de emprendimentos
        $colunas = 'e.id AS id, funcaos.fndescricao';
        $groupBy = 'GROUP BY e.users_id;';
        $filtro_ext = null;
        $orderBy = null;
        if ($tipo_produto) {
            $filtro_ext = "funcaos.fndescricao = '" . $tipo_produto . "'";
        }

        $totaluser = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);


        //lista de empreendimentos
        $colunas = 'users.id AS id, users.name, funcaos.fndescricao';
        $groupBy = 'GROUP BY e.users_id';
        $orderBy = 'ORDER BY users.name ASC, periodos.datainicio ASC';
        $filtro_ext = null;
        if ($tipo_produto) {
            $filtro_ext = "funcaos.fndescricao = '" . $tipo_produto . "'";
        }
        $lista_empreendimentos = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

        //lista de eventos
        $colunas = 'users.id AS id, users.name, periodos.datainicio,  periodos.datafim, e.horas';
        $groupBy = '';
        $orderBy = 'ORDER BY users.name ASC, periodos.datainicio ASC';
        $filtro_ext = null;
        if ($tipo_produto) {
            $filtro_ext = "funcaos.fndescricao = '" . $tipo_produto . "'";
        }
        $lista_empreendimentos_eventos = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

        //dividir periodo por data 
        $datas_segundos_empreendimentos = [];
        $segundos = 0;
        foreach ($lista_empreendimentos_eventos as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $dividir_datas = $this->separa_datas($value->datainicio, $value->datafim);
            $conta_registro = count($dividir_datas);
            $segundos_dividido = $segundos / $conta_registro;
            foreach ($dividir_datas as $value2) {
                array_push($datas_segundos_empreendimentos, $value2 . '<>' . $value->name . '<>' . $segundos_dividido);
            }
        }

        // total horas por empreendimento
        $colunas = 'users.id AS idempreen, users.name, users.email, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY users.name';
        $orderBy = 'ORDER BY users.name ASC';
        $filtro_ext = null;
        if ($tipo_produto) {
            $filtro_ext = "funcaos.fndescricao = '" . $tipo_produto . "'";
        }
        $lista_empreendimentos_horas2 = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

        //total de custo por empreendimento
        $lista_empreendimentos_horas22 = [];
        foreach ($lista_empreendimentos_horas2 as $value) {
            // total pess por empreendimento
            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, users.id AS idempri, users.name';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'users.id = ' . $value->idempreen;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);
            $pess = [];
            $soma_valores = 0;
            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);
                $pess[] = $value2->users_id;
                $soma_valores = $soma_valores + $valor;
            }
            $pess_unicos = array_unique($pess);
            $soma_valores = number_format($soma_valores, 2, ',', '.');
            $lista_empreendimentos_horas22[] = ['id' => $value->idempreen, 'name' => $value->name, 'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos)];
        }


        $alluser = User::all();
        $userinativo = [];
        $tem = false;
        foreach ($alluser as $user) {
            $tem = false;
            foreach ($lista_empreendimentos as $ativo) {
                if ($user->id == $ativo->id) {
                    $tem = true;
                }
            }
            if (!$tem) {
                $userinativo[] = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email];
            }
        }

        $userinativo2 = $this->super_unique($userinativo, 'name');

        // array_unique($userinativo, SORT_REGULAR);

        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);

        return view('pages.home.card_usuarios', compact('totaluser', 'datas_segundos_empreendimentos', 'lista_empreendimentos', 'lista_empreendimentos_eventos', 'lista_empreendimentos_horas22', 'total_horas', 'userinativo2', 'tipo_produto'));
    }
    public function card_user(Request $request)
    {
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $resultado = $this->filtros($request, $colunas, $groupBy);

        //lista de eventos
        $colunas = 'e.id AS id, periodos.datainicio,  periodos.datafim, e.horas';
        $groupBy = '';
        $orderBy = '';
        $lista_datas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        //dividir periodo por data 
        $datas = [];
        foreach ($lista_datas as $value) {
            $dividir_datas = $this->separa_datas($value->datainicio, $value->datafim);
            if ($dividir_datas) {
                foreach ($dividir_datas as $value2) {
                    array_push($datas, $value2);
                }
            }
        }
        $dias1 = array_unique($datas);
        $total_dias = count($dias1);

        //total de pessoas
        $colunas = 'e.id AS id';
        $groupBy = 'GROUP BY e.users_id;';
        $pessoas = $this->filtros($request, $colunas, $groupBy);


        return view('pages.home.card_user', compact('resultado', 'total_dias', 'pessoas'));
    }
    public function card_pequenos(Request $request)
    {
        // total horas por contrato - obra
        $colunas = 'contratos.id AS idempreen, users.id, e.tarifa, contratos.ctnome, contratos.ctnumero, contratos.cttipo, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY contratos.ctnome';
        $orderBy = 'ORDER BY contratos.ctnome ASC, periodos.datainicio ASC';
        $lista_contrato_obra2 = $this->filtros($request, $colunas, $groupBy, $orderBy);


        $obra_custo = 0;
        $obra_hora = 0;
        $obra_pess = [];
        $sabesp_custo = 0;
        $sabesp_hora = 0;
        $sabesp_pess = [];
        $apoio_custo = 0;
        $apoio_hora = 0;
        $apoio_pess = [];
        $automacao_custo = 0;
        $automacao_hora = 0;
        $automacao_pess = [];
        $jica_custo = 0;
        $jica_hora = 0;
        $jica_pess = [];
        $pura_custo = 0;
        $pura_hora = 0;
        $pura_pess = [];

        foreach ($lista_contrato_obra2 as $value) {
            // total pess por contrato
            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, contratos.id AS idempri, contratos.ctnome, contratos.cttipo';
            $groupBy = '';
            $orderBy = '';
            $filtro_ext = 'contratos.id = ' . $value->idempreen;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

            foreach ($pessoas_horas as $value2) {

                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);

                if ($value2->cttipo == 'Obra') {
                    $obra_pess[] = $value2->users_id;
                    $obra_custo = $obra_custo + $valor;
                    $obra_hora = $obra_hora + $segundos;
                }
                if ($value2->cttipo == 'Sabesp') {
                    $sabesp_pess[] = $value2->users_id;
                    $sabesp_custo = $sabesp_custo + $valor;
                    $sabesp_hora = $sabesp_hora + $segundos;
                }
                if ($value2->cttipo == 'Apoio') {
                    $apoio_pess[] = $value2->users_id;
                    $apoio_custo = $apoio_custo + $valor;
                    $apoio_hora = $apoio_hora + $segundos;
                }
                if ($value2->cttipo == 'Automação') {
                    $automacao_pess[] = $value2->users_id;
                    $automacao_custo = $automacao_custo + $valor;
                    $automacao_hora = $automacao_hora + $segundos;
                }
                if ($value2->cttipo == 'Jica') {
                    $jica_pess[] = $value2->users_id;
                    $jica_custo = $jica_custo + $valor;
                    $jica_hora = $jica_hora + $segundos;
                }
                if ($value2->cttipo == 'Pura') {
                    $pura_pess[] = $value2->users_id;
                    $pura_custo = $pura_custo + $valor;
                    $pura_hora = $pura_hora + $segundos;
                }
            }
        }



        $obra_custo = number_format($obra_custo, 2, ',', '.');
        $sabesp_custo = number_format($sabesp_custo, 2, ',', '.');
        $apoio_custo = number_format($apoio_custo, 2, ',', '.');
        $automacao_custo = number_format($automacao_custo, 2, ',', '.');
        $jica_custo = number_format($jica_custo, 2, ',', '.');
        $pura_custo = number_format($pura_custo, 2, ',', '.');

        $obra_hora = $this->horas_segundos($obra_hora);
        $sabesp_hora = $this->horas_segundos($sabesp_hora);
        $apoio_hora = $this->horas_segundos($apoio_hora);
        $automacao_hora = $this->horas_segundos($automacao_hora);
        $jica_hora = $this->horas_segundos($jica_hora);
        $pura_hora = $this->horas_segundos($pura_hora);

        $obra_pess = array_unique($obra_pess);
        $obra_pess = count($obra_pess);
        $sabesp_pess = array_unique($sabesp_pess);
        $sabesp_pess = count($sabesp_pess);
        $apoio_pess = array_unique($apoio_pess);
        $apoio_pess = count($apoio_pess);
        $automacao_pess = array_unique($automacao_pess);
        $automacao_pess = count($automacao_pess);
        $jica_pess = array_unique($jica_pess);
        $jica_pess = count($jica_pess);
        $pura_pess = array_unique($pura_pess);
        $pura_pess = count($pura_pess);

        $lista_contrato_tipo = [
            'obra_custo' => $obra_custo,
            'obra_hora' => $obra_hora,
            'obra_pess' => $obra_pess,

            'sabesp_custo' => $sabesp_custo,
            'sabesp_hora' => $sabesp_hora,
            'sabesp_pess' => $sabesp_pess,

            'apoio_custo' => $apoio_custo,
            'apoio_hora' => $apoio_hora,
            'apoio_pess' => $apoio_pess,

            'automacao_custo' => $automacao_custo,
            'automacao_hora' => $automacao_hora,
            'automacao_pess' => $automacao_pess,

            'jica_custo' => $jica_custo,
            'jica_hora' => $jica_hora,
            'jica_pess' => $jica_pess,

            'pura_custo' => $pura_custo,
            'pura_hora' => $pura_hora,
            'pura_pess' => $pura_pess,
        ];

        //total tarifa 
        $colunas = 'e.id AS id, e.users_id, e.tarifa, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY e.users_id;';
        $pessoas_horas = $this->filtros($request, $colunas, $groupBy);
        $soma_valor = 0;
        $soma_time = 0;
        foreach ($pessoas_horas as $value) {
            $horas = $this->horas_segundos($value->total);
            $tarifa = str_replace(',', '.', $value->tarifa);
            $valor = (float)$tarifa * intval($horas);
            $soma_valor = $soma_valor + $valor;
            $soma_time = $soma_time + $horas;
        }
        $soma_valor = number_format($soma_valor, 2, ',', '.');

        $totais = ['total_custo' => $soma_valor, 'total_time' => $soma_time];










        $colunas = 'e.id AS id';
        $groupBy = 'GROUP BY e.users_id;';
        $pessoas1 = $this->filtros($request, $colunas, $groupBy);
        $pessoas = count($pessoas1);
        $pessoas_full = User::select('count(*) as allcount')->count();

        $colunas = 'e.id AS id';
        $groupBy = 'GROUP BY e.contratos_id;';
        $contratos1 = $this->filtros($request, $colunas, $groupBy);
        $contratos = count($contratos1);
        $contratos_full = Contrato::select('count(*) as allcount')->count();

        // $colunas = 'e.id AS id';
        // $groupBy = 'GROUP BY e.produtos_id;';
        // $produtos1 = $this->filtros($request, $colunas, $groupBy);
        // $produtos = count($produtos1);
        // $produtos_full = Produto::select('count(*) as allcount')->count();

        $colunas = 'e.id AS id';
        $groupBy = 'GROUP BY e.atividades_id;';
        $atividades1 = $this->filtros($request, $colunas, $groupBy);
        $atividades = count($atividades1);
        $atividades_full = Atividade::select('count(*) as allcount')->count();

        return view('pages.home.card_pequenos', compact('lista_contrato_tipo', 'totais', 'pessoas', 'pessoas_full', 'contratos', 'contratos_full', 'atividades', 'atividades_full'));
    }
    public function card_f_pequenos(Request $request)
    {
        // total horas por contrato
        $colunas = 'funcaos.id AS id, funcaos.fndescricao, sum( time_to_sec (e.horas)) as total';
        $groupBy = 'GROUP BY funcaos.fndescricao';
        $orderBy = 'ORDER BY total desc';
        $lista_contratos_horas = $this->filtros($request, $colunas, $groupBy, $orderBy);

        // tranzendo o custo 
        $cont = 0;
        $soma_valor_t = '0.00';
        foreach ($lista_contratos_horas as $value) {

            $colunas = 'e.id AS id, e.users_id, e.tarifa, e.horas, funcaos.id AS idfun, funcaos.fndescricao';
            $groupBy = '';
            $orderBy = '';
            $orderBy = '';
            $filtro_ext = 'funcaos.id = ' . $value->id;
            $pessoas_horas = $this->filtros($request, $colunas, $groupBy, $orderBy, $filtro_ext);

            $pess = [];
            $soma_valores = 0;
            $soma_hora = 0;
            $valor = 0;
            $tarifa = 0;
            $segundos = 0;

            foreach ($pessoas_horas as $value2) {
                $segundos = $this->converte_segundos($value2->horas);
                $tarifa = trim($value2->tarifa);
                $valor = $this->tarifa_segundos($tarifa, $segundos);

                $pess[] = $value2->users_id;

                $soma_valores = $soma_valores + $valor;
                $soma_valor_t = $soma_valor_t + $valor;
                $soma_hora = $soma_hora +  $segundos;
            }
            $pess_unicos = array_unique($pess);
            $lista_funcaos[] = ['id' => $value->id, 'fndescricao' => $value->fndescricao,  'total' => $value->total, 'custo' => $soma_valores, 'totaluser' => count($pess_unicos)];
            $cont =   $cont + 1;
        }


        $lista_funcaos = (object) $lista_funcaos;


        //total em horas
        $colunas = 'e.id AS id, sum( time_to_sec (e.horas)) as total';
        $groupBy = '';
        $total_horas = $this->filtros($request, $colunas, $groupBy);



        return view('pages.home.card_f_pequenos', compact('lista_funcaos', 'total_horas', 'soma_valor_t', 'lista_contratos_horas'));
    }
    function converte_segundos($tempo)
    {
        $segundos = 0;
        list($h, $m, $s) = explode(':', $tempo);
        $segundos += $h * 3600;
        $segundos += $m * 60;
        $segundos += $s;
        return $segundos;
    }
    function horas_segundos($total)
    {
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        if (strlen($minutos) == 1) {
            $minutos = '0' . $minutos;
        }
        if (strlen($horas) == 1) {
            $horas = '0' . $horas;
        }

        return $horas;
    }
    function horas_segundos_full($total)
    {
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        // if(strlen($minutos) == 1){ $minutos = '0'.$minutos;}
        // if(strlen($horas) == 1){ $horas = '0'.$horas;}
        return $horas . '.' . $minutos;
    }
    function separa_datas($dateStart, $dateEnd)
    {
        $dateRange = array();
        $mes = 0;
        $dateStart     = new DateTime($dateStart);
        $dateEnd     = new DateTime($dateEnd);

        while ($dateStart <= $dateEnd) {
            $mes = $dateStart->format('m');
            $dateRange[] = $dateStart->format('Y-m-d');
            // if($dateStart->format('N') > 5 ){
            //   return 5;
            // }

            $dateStart = $dateStart->modify('+1day');
            //  if($dateEnd->format('m') !== $mes ){
            //   return 5;
            //  }            
        }
        return $dateRange;
    }
    function tarifa_segundos($tarifa, $segundos)
    {
        $tarifa = str_replace(',', '.', $tarifa);
        $tarifa_segundo = $tarifa / 3600;
        $total_tarifa = $tarifa_segundo * $segundos;
        return $total_tarifa;
    }
    function super_unique($array, $key)
    {
        $temp_array = [];
        foreach ($array as &$v) {
            if (!isset($temp_array[$v[$key]]))
                $temp_array[$v[$key]] = &$v;
        }
        $array = array_values($temp_array);
        return $array;
    }
    function array_sort($arr)
    {
        if (empty($arr)) return $arr;
        foreach ($arr as $k => $a) {
            if (!is_array($a)) {
                arsort($arr); // could be any kind of sort
                return $arr;
            } else {
                $arr[$k] = $this->array_sort($a);
            }
        }
        return $arr;
    }
    function card_relatorio_completo(Request $request)
    {
        $data_inicio = $this->dateEmMysql($request->data_inicio);
        $data_fim = $this->dateEmMysql($request->data_fim);
        $dividir_datas = $this->separa_datas($data_inicio, $data_fim);
        $request->data_inicio = date('d/m/Y', strtotime($data_inicio));
        $request->data_fim = date('d/m/Y', strtotime($data_fim));

        $colunas = 'users.id AS iduser, users.name, e.tarifa, e.horas, e.contratos_id, contratos.ctnome, contratos.ctnumero, periodos.datainicio';
        $groupBy = '';
        $orderBy = 'ORDER BY users.name ASC, contratos.ctnome, periodos.datainicio';
        $lista_usuarios_full = $this->filtros($request, $colunas, $groupBy, $orderBy);

        $lista_usuarios_data = [];

        foreach ($lista_usuarios_full as $value) {
            $segundos = $this->converte_segundos($value->horas);
            $tarifa = trim($value->tarifa);
            $valor = $this->tarifa_segundos($tarifa, $segundos);
            $lista_usuarios_data[] = ['iduser' => $value->iduser, 'segundos'=> $segundos, 'nome' => $value->name, 'valor' => $valor, 'contrato' => $value->ctnome, 'ctnumero'=>$value->ctnumero, 'periodoinit' => $value->datainicio];
        }

        //dd( $lista_usuarios_data);

     

        $valorContrato = 0;
        $segundosContrato = 0;
        $valortotal = 0;
        $segundostotal = 0;
        $mes = '';
        $contrato = '';             
        $user = '';               
        $tablefull = [];
        $contratosGr = [];
        $meses = [];
        $contdata = 0;

        foreach ($lista_usuarios_data as $value) {
            $contdata = $contdata + 1;
            $dateStart     = new DateTime($value['periodoinit']);
            $mes = $dateStart->format('m-y');

            if ($value['nome'] == $user) {
                if ($value['contrato'] == $contrato) {
                    $valorContrato = $valorContrato + $value['valor'];
                    $segundosContrato = $segundosContrato + $value['segundos'];
                    $meses[] = $mes;

                }else{
                    $segundosContrato = $this->horas_segundos($segundosContrato);
                    $contratosGr[] = ['contrato'=> $value['ctnumero'].'- '.$contrato, 'segundosContrato'=>$segundosContrato, 'valorContrato'=>$valorContrato, 'mes'=> $meses];
                    $contrato = $value['contrato'];
                    $valorContrato = $value['valor'];
                    $segundosContrato = $value['segundos'];
                    $meses[] = $mes;
                }
                $valortotal = $valortotal + $value['valor'];
                $segundostotal = $segundostotal + $value['segundos'];
            } else {
                $segundostotal = $this->horas_segundos($segundostotal);
                $segundosContrato = $this->horas_segundos($segundosContrato);
                $contratosGr[] = ['contrato'=> $value['ctnumero'].'- '.$contrato, 'segundosContrato'=>$segundosContrato, 'valorContrato'=>$valorContrato, 'mes'=> $meses];
                $tablefull[] = ['nome'=> $user,  'contratos'=> $contratosGr, 'total'=>$valortotal, 'segundosTotal'=>$segundostotal];     

                $contratosGr = []; 
                $meses = [];  
                $meses[] = $mes;
                $user =  $value['nome'];
                $contrato = $value['contrato'];
                $valortotal = $value['valor'];  
                $valorContrato = $value['valor'];                        
                $segundosContrato = $value['segundos'];
                $segundostotal = $value['segundos'];                        
            }

            if(count($lista_usuarios_data) == $contdata){
                $segundostotal = $this->horas_segundos($segundostotal);
                $segundosContrato = $this->horas_segundos($segundosContrato);
                $contratosGr[] = ['contrato'=> $contrato, 'segundosContrato'=>$segundosContrato, 'valorContrato'=>$valorContrato, 'mes'=> $meses];
                $tablefull[] = ['nome'=> $user, 'contratos'=> $contratosGr, 'total'=>$valortotal, 'segundosTotal'=>$segundostotal]; 
            }
        }

        //dd($tablefull);

        return view('pages.home.card_relatorio_completo', compact('tablefull'));

    }    
}
