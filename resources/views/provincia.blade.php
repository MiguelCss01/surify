@extends('layouts.app')

@section('title', 'Surify - ' . ($provincia ? $provincia->nombre : $nombre))

@section('content')
    <!-- // Front-End: Diseñar la pantalla de la provincia específica aquí -->
    <!-- // Datos disponibles desde el controlador (Back-End): -->
    <!-- // - $nombre: El nombre de la provincia que se está visitando (string). -->
    <!-- // - $provincia: Modelo de la Provincia (si existe en la BD) con campos: nombre, descripcion, imagen_url, region. -->
    <!-- // - $destinos: Colección de destinos asociados a esta provincia. -->

    <div>
        <h1>[Front-End: Diseñar Detalle de Provincia y Listado de Destinos Aquí]</h1>
        
        <h2>Provincia: {{ $provincia ? $provincia->nombre : $nombre }}</h2>

        <h3>Destinos Recomendados en esta Provincia:</h3>
        
        <!-- // Ejemplo de bucle para recorrer los destinos: -->
        <!--
        @if($destinos->isEmpty())
            <p>No se encontraron destinos turísticos cargados para esta provincia.</p>
        @else
            <ul>
                @foreach($destinos as $destino)
                    <li>
                        <strong>{{ $destino->nombre }}</strong> (Precio: {{ $destino->rango_precio }})
                        <p>{{ $destino->descripcion }}</p>
                        <a href="{{ route('destinos.show', ['id' => $destino->id]) }}">Ver Ficha del Destino</a>
                    </li>
                @endforeach
            </ul>
        @endif
        -->
    </div>
@endsection
