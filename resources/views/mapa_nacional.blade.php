@extends('layouts.app')

@section('title', 'Surify - Mapa Nacional')

@section('content')
    <!-- // Front-End: Diseñar la pantalla del Mapa Nacional (selección de provincia) aquí -->
    <!-- // Datos disponibles desde el controlador (Back-End): -->
    <!-- // - $provincias: Colección con todas las provincias de la base de datos. -->
    
    <div>
        <h1>[Front-End: Diseñar Mapa Nacional / Selección de Provincias Aquí]</h1>
        <p>Iterar sobre la variable <code>$provincias</code> para construir el grid o mapa interactivo.</p>

        <!-- // Ejemplo de bucle para recorrer las provincias: -->
        <!--
        @if($provincias->isEmpty())
            <p>No hay provincias registradas en la base de datos todavía.</p>
        @else
            <ul>
                @foreach($provincias as $provincia)
                    <li>
                        <strong>{{ $provincia->nombre }}</strong> (Región: {{ $provincia->region }})
                        <br>
                        <a href="{{ route('provincia.show', ['nombre' => $provincia->nombre]) }}">Explorar destinos</a>
                    </li>
                @endforeach
            </ul>
        @endif
        -->
    </div>
@endsection
