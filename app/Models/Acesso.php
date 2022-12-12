<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Session;
use PDOException;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    public function perfil_acesso(){
        $filtro = '';
        $and = '';
        if(Auth::user()->acesso == 'Consulta'){
            if(Auth::user()->tipo_consulta == 'Cliente'){
                $id_cliente = Auth::user()->clientes_id;
                if($filtro != null){ $and = ' AND';}
                if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
                $filtro .= $and.$where.' clientes.id = '.$id_cliente;               
            }
            if(Auth::user()->tipo_consulta == 'Região'){
                $regiaos_id = Auth::user()->regiaos_id;
                if($filtro != null){ $and = ' AND';}
                if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
                // $filtro .= $and.$where.' regiaos.id = '.$regiaos_id;
                $filtro .= $this->acesso_regioes($filtro, $and, $where);
            }
            if(Auth::user()->tipo_consulta == 'Gerenciadora'){
                $gerenciadoras_id = Auth::user()->gerenciadoras_id;
                if($filtro != null){ $and = ' AND';}
                if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
                $filtro .= $and.$where.' gerenciadoras.id = '.$gerenciadoras_id;
            }
        }

        

        if(Auth::user()->acesso == 'Operacional'){
            if(Auth::user()->tipo_gestor == 'CDHU'){
                $areas_id = Auth::user()->areas_id;
                if($filtro != null){ $and = ' AND';}
                if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
                $filtro .= $and.$where.' areas.id = '.$areas_id;
            }
        }

        // if($request->tipo_contrato != null){
        //     if($filtro != null){ $and = 'AND';}
        //     if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
        //     $filtro .=" $and $where tipo_contratos.id IN ($request->tipo_contrato) ";
        // }

        // if(Auth::user()->acesso == 'Operacional'){
        //     if(Auth::user()->tipo_gestor == 'Gestor'){
        //         $regiaos_id = Auth::user()->regiaos_id;
        //         if($filtro != null){ $and = ' AND';}
        //         if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
        //         $filtro .= $and.$where.' regiaos.id = '.$regiaos_id;
        //     }
        // }

        if(Auth::user()->acesso == 'Operacional'){
            if(Auth::user()->tipo_gestor == 'Gestor'){
                if($filtro != null){ $and = ' AND';}
                if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
                $filtro .= $this->acesso_regioes($filtro, $and, $where);
            }
        }




        if(Auth::user()->acesso == 'Operacional'){
            if(Auth::user()->tipo_gestor == 'Técnico'){
                $regiaos_id = Auth::user()->regiaos_id;
                if($filtro != null){ $and = ' AND';}
                if($filtro == null){ $where = ' WHERE';}else{$where = ''; }
                // $filtro .= $and.$where.' regiaos.id = '.$regiaos_id;
                $filtro .= $this->acesso_regioes($filtro, $and, $where);
            }
        }
        return $filtro;
    }
    public function acesso_regioes($filtro, $and, $where){
        $acesso_regioes = DB::table('users_regiaos AS ur')
        ->join('users', 'users.id', '=', 'ur.users_id')
        ->select('ur.regiaos_id As uregiaos_id')
        ->where([['users.id',  Auth::user()->id]])->get();
        $regioes = [];
        foreach($acesso_regioes as $value){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
            array_push($regioes, $value->uregiaos_id);
        }
        $result = array_unique($regioes);
        $ids = '';
        foreach( $result as $arr){
            $ids .= $arr.',';
        }
        $result = substr($ids, 0, -1);
        $filtro .=" $and $where regiaos.id IN ($result)";
        return $filtro;        
    }
}