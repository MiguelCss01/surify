@extends('layouts.app')

@section('title', 'Surify - ' . $evento->nombre)

@section('content')
    <!-- // Front-End: Diseñar la Ficha de Detalle de un Evento aquí -->
    <!-- // Datos disponibles desde el controlador (Back-End): -->
    <!-- // - $evento: El modelo del Evento. Campos útiles: nombre, tipo, fecha_inicio, fecha_fin, rango_precio, imagen_url. -->
    <!-- // - $evento->provincia: La provincia donde ocurre el evento. -->
    <!-- // - $evento->destino: El destino turístico específico donde ocurre el evento (opcional). -->
    <!-- // - $evento->resenas: Listado de reseñas asociadas al evento. -->
    
    <div>
        <h1>[Front-End: Diseñar Detalle de Evento: {{ $evento->nombre }}]</h1>
        
        <p>Tipo: {{ $evento->tipo }}</p>
        <p>Fecha de inicio: {{ $evento->fecha_inicio->format('d/m/Y') }}</p>

        <!-- // Sección de Reseñas de este Evento -->
        <h3>Reseñas de los asistentes:</h3>
        <!-- Iterar sobre $evento->resenas -->

        <!-- // Formulario para agregar una reseña al evento (Solo para usuarios autenticados) -->
        <!-- // IMPORTANTE: Conservar las rutas, el @csrf y los nombres de los inputs. -->
        <!--
        @auth
            <form action="{{ route('resenas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                
                <label for="calificacion">Calificación:</label>
                <select name="calificacion">
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>

                <label for="comentario">Tu opinión sobre el evento:</label>
                <textarea name="comentario" required></textarea>

                <button type="submit">Enviar Reseña</button>
            </form>
        @else
            <p>Inicia sesión para dejar una reseña sobre este evento.</p>
        @endauth
        -->
    </div>
@endsection
