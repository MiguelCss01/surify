@extends('layouts.app')

@section('title', 'Surify - ' . $destino->nombre)

@section('content')
    <!-- // Front-End: Diseñar la Ficha de Detalle de un Destino aquí -->
    <!-- // Datos disponibles desde el controlador (Back-End): -->
    <!-- // - $destino: El modelo del Destino. Campos útiles: nombre, descripcion, rango_precio, categoria, imagen_url. -->
    <!-- // - $destino->provincia: La provincia a la que pertenece el destino. -->
    <!-- // - $destino->eventos: Listado de eventos que suceden en este destino. -->
    <!-- // - $destino->resenas: Listado de reseñas escritas por otros usuarios. -->
    <!-- //             Cada reseña contiene: $resena->user->name, $resena->calificacion, $resena->comentario, $resena->imagenes. -->

    <div>
        <h1>[Front-End: Diseñar Ficha del Destino: {{ $destino->nombre }}]</h1>

        <!-- // Sección de Eventos de este Destino -->
        <h3>Eventos programados:</h3>
        <!-- Iterar sobre $destino->eventos -->

        <!-- // Sección de Comentarios y Reseñas -->
        <h3>Reseñas de la Comunidad:</h3>
        <!-- Iterar sobre $destino->resenas -->

        <!-- // Formulario para agregar una reseña (Solo para usuarios autenticados) -->
        <!-- // IMPORTANTE: Conservar las rutas, el @csrf y los nombres de los inputs. -->
        <!--
        @auth
            <form action="{{ route('resenas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="destino_id" value="{{ $destino->id }}">
                
                <label for="calificacion">Calificación:</label>
                <select name="calificacion">
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>

                <label for="comentario">Tu opinión:</label>
                <textarea name="comentario" required></textarea>

                <button type="submit">Enviar Reseña</button>
            </form>
        @else
            <p>Inicia sesión para dejar una reseña.</p>
        @endauth
        -->
    </div>
@endsection
