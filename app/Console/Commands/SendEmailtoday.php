<?php

namespace App\Console\Commands;

use App\Http\Controllers\AvisosController;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\newDisparo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use stdClass;

class SendEmailtoday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar email para usuarios que não preencheu as horas do dia.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //verificar quem nao preencheu as horas do dia e enviar o email dizendo para preencher 

        $userEmails = $this->userpreenche();

        foreach ($userEmails as $value){         

            $user = new stdClass();
            $user->name = $value['name'];
            $user->email = $value['email'];
            $user->titulo = 'Diário de Ativos - Lembrete.';
            $user->ultimo = $value['ultimodia'];

            $user->mensagem = ''.$value['name'].', bom dia! <br> Passando para lembrar da importância  do preenchimento do Diário Ativos. 
                              Você já preencheu '.$value['total'].' horas, e seu último preenchimento foi no dia '.$value['ultimodia'].' <br> 
                              É importante que no final do Mês, o calendário esteja preenchido para agilizar o processo. <br> 
                              Certos de sua colaboração, desde já agradecemos! <br><br> Att., <br> Gestão e Controle Inovasan';

            $user->subject = 'Diário de Ativos - Lembrete.';
            // if($value['id'] == 12){
                newDisparo::dispatch($user)->delay(now()->addSecond('2'));        
            // }
        }

    }    
    
    public function userpreenche(){       

        $alluser = User::all();
        $userArray = [];
        foreach($alluser as $val){
            $horas = $this->totalhorasmes($val->id);            
            $ultimodia = $this->ultimodia($val->id);            
            $userArray[] = ['id'=>$val->id, 'name'=>$val->name, 'email'=>$val->email, 'total'=>$horas, 'ultimodia'=>$ultimodia] ;
        }
        return $userArray;
    }

    public function totalhorasmes($iduser){
        $data_inicio = mktime(0, 0, 0, date('m')  , 1 , date('Y'));        
        $data_inicio = date('Y-m-d',$data_inicio);

        $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        $data_fim = date('Y-m-d',$data_fim);

        $eventos = DB::select( DB::raw(
        "SELECT users.id AS iduser, users.name, users.email, sum( time_to_sec (e.horas)) as total
            FROM eventos As e
            LEFT JOIN users ON users.id = e.users_id
            LEFT JOIN periodos ON periodos.id = e.periodos_id            
            WHERE periodos.datainicio BETWEEN '$data_inicio' AND '$data_fim' AND users.id = $iduser
            GROUP BY users.name DESC limit 1"             
        )); 
        if(isset($eventos[0]->total)){
            return $this->horas_segundos2($eventos[0]->total);  
        }else{
            return 0;
        }
    }

    public function ultimodia($iduser){
        $ultimoregisto = DB::select( DB::raw(
            "SELECT users.id AS iduser, users.name, users.email, periodos.datafim
                FROM eventos As e
                LEFT JOIN users ON users.id = e.users_id
                LEFT JOIN periodos ON periodos.id = e.periodos_id            
                WHERE users.id = $iduser
                GROUP BY periodos.datafim DESC limit 1"            
            )); 

            if(isset($ultimoregisto[0]->datafim)){
                $ultimoregistro = date( 'd/m/Y' , strtotime($ultimoregisto[0]->datafim));
            }else{
                $ultimoregistro = '"sem dados registrados"';
            }
        return $ultimoregistro;
    }

    public function horas_segundos2($total){
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        return $horas . "." . $minutos;
    }

    public function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return $key;
            }
        }
        return null;
     }
}
