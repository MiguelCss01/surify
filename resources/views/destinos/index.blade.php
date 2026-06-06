<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Destinos de Surify</title>
</head>
<body>
    <h1>Nuestros Destinos Turísticos</h1>

    <ul>
        {{-- Esto es Blade: un "foreach" que recorre la lista que nos mandó el controlador --}}
        @foreach($destinos as $destino)
            <li>
                <strong>{{ $destino->nombre }}</strong> 
                <br>
                {{ $destino->descripcion }}
            </li>
        @endforeach
    </ul>

</body>
</html>