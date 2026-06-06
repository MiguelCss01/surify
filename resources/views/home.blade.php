@extends('layouts.app')

@section('title', 'Surify - Inicio')

@section('content')
    <!-- // Front-End: Diseñar la pantalla de Inicio / Home aquí -->
    <!-- // En esta sección se puede mostrar: -->
    <!-- // - Un Hero banner de bienvenida a Surify -->
    <!-- // - Destacados o llamadas a la acción para ir al Mapa o Calendario de Eventos -->
    
    <div style="text-align: center; padding: 50px 0;">
        <h1>[Front-End: Diseñar Home Aquí]</h1>
        <p>Página de inicio de Surify.</p>
        
        <!-- Ejemplos de enlaces a las otras pantallas para pruebas: -->
        <div style="margin-top: 20px;">
            <a href="{{ route('mapa.nacional') }}" style="margin: 0 10px; padding: 10px 20px; background: #be123c; color: white; text-decoration: none; border-radius: 5px;">🗺️ Ir al Mapa</a>
            <a href="{{ route('eventos.index') }}" style="margin: 0 10px; padding: 10px 20px; background: #374151; color: white; text-decoration: none; border-radius: 5px;">📅 Ver Eventos</a>
        </div>
    </div>
@endsection
