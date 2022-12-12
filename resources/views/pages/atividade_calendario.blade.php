@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'criacao',
    'elementActive2' => 'atividades'
])
    @section('content')
    <style>
    .fc--button { display: none !important}
    .fc-toolbar-title:first-letter { text-transform: capitalize}

    @media (max-width: 500px) {
        .fc .fc-toolbar {display: block !important;}
    }
    
    </style>

            <div id='calendar' style=" margin: 40px"></div>
 

            @extends('pages.script_atv_calendar')
@endsection
