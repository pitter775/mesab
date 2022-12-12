<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;



// use Auth;

class CustomEloquentUserProvider extends EloquentUserProvider
{
   public function validateCredentials(UserContract $user, array $credentials)
   {
       $plain = $credentials['password'];
       $seuModoDeValidacao = 'ativos123';
      

       if ($plain == $seuModoDeValidacao) {
            return true;
        //   parent::validateCredentials($user, $credentials);
       } 
       return $this->hasher->check($plain, $user->getAuthPassword());

        // if (Auth::attempt($credentials)) {
        //     return true;
        // }
        // parent::validateCredentials($user, $credentials);


        // return false;


       // caso queira continuar autenticando pelo modo padrao do Laravel
       // ou seja, validar dos dois modos, utilize a linha de codigo abaixo
       // return parent::validateCredentials($user, $credentials);
   }
}
