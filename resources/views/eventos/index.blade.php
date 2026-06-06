@extends('layouts.app')

@section('title', 'Surify - Eventos y Festividades')

@section('content')
    <!-- // Front-End: Diseñar la pantalla de Calendario o Listado de Eventos aquí -->
    <!-- // Datos disponibles desde el controlador (Back-End): -->
    <!-- // - $eventos: Colección con todos los eventos de la base de datos (ordenados por fecha). -->
    <!-- //             Campos útiles de cada evento: nombre, tipo, fecha_inicio, fecha_fin, rango_precio, imagen_url. -->
    <!-- //             También cuenta con la relación $evento->destino y $evento->provincia. -->

    <div>
        <h1>[Front-End: Diseñar Listado de Eventos / Festividades Aquí]</h1>
        
        <!-- // Ejemplo de bucle para recorrer los eventos: -->
        <!--
        @if($eventos->isEmpty())
            <p>No hay eventos registrados en la base de datos.</p>
        @else
            <ul>
                @foreach($eventos as $evento)
                    <li>
                        <strong>{{ $evento->nombre }}</strong> ({{ $evento->tipo }})
                        <br>
                        Fecha: {{ $evento->fecha_inicio->format('d/m/Y') }}
                        @if($evento->destino)
                            - Destino: {{ $evento->destino->nombre }}
                        @endif
                        <br>
                        <a href="{{ route('eventos.show', ['id' => $evento->id]) }}">Ver Detalles del Evento</a>
                    </li>
                @endforeach
            </ul>
        @endif
        -->
    </div>
@endsection
