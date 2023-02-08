@component('mail::message')
<h1>{{$user->titulo}}</h1>
<p>{!! $user->mensagem !!} </p>

{{ config('app.name') }}
@endcomponent
