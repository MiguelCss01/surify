<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permiso;
use App\Models\Provincia;
use App\Models\Destino;
use App\Models\Evento;
use App\Models\Gastronomia;
use App\Models\Resena;
use App\Models\ImagenResena;
use App\Models\Favorito;
use App\Models\DestinoVisitado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Roles
        $adminRole = Role::firstOrCreate(
            ['nombre' => 'Admin'],
            ['descripcion' => 'Administrador total de la plataforma']
        );

        $turistaRole = Role::firstOrCreate(
            ['nombre' => 'Turista'],
            ['descripcion' => 'Usuario turista que explora y reseña destinos']
        );

        // 2. Crear Permisos
        $crearDestino = Permiso::firstOrCreate(
            ['nombre' => 'crear_destino'],
            ['descripcion' => 'Permiso para crear nuevos destinos turísticos']
        );

        $eliminarComentario = Permiso::firstOrCreate(
            ['nombre' => 'eliminar_comentario'],
            ['descripcion' => 'Permiso para moderar y borrar comentarios/reseñas']
        );

        // Asociar permisos a Roles
        if (!$adminRole->permisos()->where('nombre', 'crear_destino')->exists()) {
            $adminRole->permisos()->attach($crearDestino);
        }
        if (!$adminRole->permisos()->where('nombre', 'eliminar_comentario')->exists()) {
            $adminRole->permisos()->attach($eliminarComentario);
        }

        // 3. Crear Usuarios
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@surify.com'],
            [
                'name' => 'Admin Surify',
                'password' => Hash::make('admin123'),
                'biografia' => 'Creador y administrador de Surify.',
            ]
        );
        if (!$adminUser->roles()->where('nombre', 'Admin')->exists()) {
            $adminUser->roles()->attach($adminRole);
        }

        $turistaUser = User::firstOrCreate(
            ['email' => 'turista@example.com'],
            [
                'name' => 'Juan Viajero',
                'password' => Hash::make('password'),
                'biografia' => 'Amante de la Patagonia, la gastronomía andina y del buen folklore.',
                'avatar' => 'https://api.dicebear.com/7.x/adventurer/svg?seed=Juan'
            ]
        );
        if (!$turistaUser->roles()->where('nombre', 'Turista')->exists()) {
            $turistaUser->roles()->attach($turistaRole);
        }

        // 4. Crear Provincias (DBML: region: Patagonia, Cuyo, NOA, NEA, Pampeana, Litoral)
        $neuquen = Provincia::firstOrCreate(
            ['nombre' => 'Neuquén'],
            [
                'descripcion' => 'Provincia caracterizada por sus imponentes lagos, bosques andinos, volcanes y actividades de montaña.',
                'imagen_url' => 'https://images.unsplash.com/photo-1596120202517-8e6f1f452033?w=800',
                'region' => 'Patagonia'
            ]
        );

        $rioNegro = Provincia::firstOrCreate(
            ['nombre' => 'Río Negro'],
            [
                'descripcion' => 'Hogar de Bariloche, el lago Nahuel Huapi, el cerro Catedral y la maravillosa ruta de los Siete Lagos.',
                'imagen_url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800',
                'region' => 'Patagonia'
            ]
        );

        $salta = Provincia::firstOrCreate(
            ['nombre' => 'Salta'],
            [
                'descripcion' => 'La linda. Famosa por su arquitectura colonial, viñedos de altura en Cafayate y cerros de colores.',
                'imagen_url' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?w=800',
                'region' => 'NOA'
            ]
        );

        // 5. Crear Destinos de Prueba
        try {
            $destinoSanMartin = Destino::firstOrCreate(
                ['nombre' => 'San Martín de los Andes'],
                [
                    'provincia_id' => $neuquen->id,
                    'descripcion' => 'Una encantadora ciudad de montaña a orillas del Lago Lácar. Es el punto de inicio de la mundialmente famosa Ruta de los Siete Lagos. Ofrece esquí en invierno (Cerro Chapelco) y trekking, kayak y pesca con mosca en verano.',
                    'rango_precio' => 'Alto',
                    'categoria' => 'Aventura',
                    'ubicacion' => DB::raw("ST_GeomFromText('POINT(-71.3489 -40.1548)', 4326)"),
                    'imagen_url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=500',
                    'activo' => true,
                ]
            );

            $destinoBariloche = Destino::firstOrCreate(
                ['nombre' => 'San Carlos de Bariloche'],
                [
                    'provincia_id' => $rioNegro->id,
                    'descripcion' => 'El destino turístico más importante de la Patagonia. Famosa por sus chocolates artesanales, cervecerías locales y el imponente Cerro Catedral. Ideal para visitar todo el año.',
                    'rango_precio' => 'Alto',
                    'categoria' => 'Aventura',
                    'ubicacion' => DB::raw("ST_GeomFromText('POINT(-71.3082 -41.1335)', 4326)"),
                    'imagen_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=500',
                    'activo' => true,
                ]
            );

            $destinoCafayate = Destino::firstOrCreate(
                ['nombre' => 'Cafayate'],
                [
                    'provincia_id' => $salta->id,
                    'descripcion' => 'Corazón de los Valles Calchaquíes en Salta. Famoso por sus bodegas que producen el vino Torrontés de altura y la espectacular Quebrada de las Conchas con sus formaciones de roca arcillosa.',
                    'rango_precio' => 'Medio',
                    'categoria' => 'Cultural',
                    'ubicacion' => DB::raw("ST_GeomFromText('POINT(-65.9760 -26.0731)', 4326)"),
                    'imagen_url' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?w=500',
                    'activo' => true,
                ]
            );
        } catch (\Exception $e) {
            // Fallback si no está PostGIS habilitado localmente
            $destinoSanMartin = Destino::firstOrCreate(
                ['nombre' => 'San Martín de los Andes'],
                [
                    'provincia_id' => $neuquen->id,
                    'descripcion' => 'Una encantadora ciudad de montaña a orillas del Lago Lácar.',
                    'rango_precio' => 'Alto',
                    'categoria' => 'Aventura',
                    'ubicacion' => null,
                    'imagen_url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=500',
                    'activo' => true,
                ]
            );

            $destinoBariloche = Destino::firstOrCreate(
                ['nombre' => 'San Carlos de Bariloche'],
                [
                    'provincia_id' => $rioNegro->id,
                    'descripcion' => 'El destino turístico más importante de la Patagonia.',
                    'rango_precio' => 'Alto',
                    'categoria' => 'Aventura',
                    'ubicacion' => null,
                    'imagen_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=500',
                    'activo' => true,
                ]
            );

            $destinoCafayate = Destino::firstOrCreate(
                ['nombre' => 'Cafayate'],
                [
                    'provincia_id' => $salta->id,
                    'descripcion' => 'Corazón de los Valles Calchaquíes en Salta. Famoso por sus bodegas.',
                    'rango_precio' => 'Medio',
                    'categoria' => 'Cultural',
                    'ubicacion' => null,
                    'imagen_url' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?w=500',
                    'activo' => true,
                ]
            );
        }

        // 6. Crear Eventos de Prueba
        $eventoChapelco = Evento::firstOrCreate(
            ['nombre' => 'Apertura de Temporada Cerro Chapelco'],
            [
                'provincia_id' => $neuquen->id,
                'destino_id' => $destinoSanMartin->id,
                'tipo' => 'Deportivo',
                'fecha_inicio' => '2026-06-20',
                'fecha_fin' => '2026-06-21',
                'rango_precio' => 'Alto',
                'imagen_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500',
                'activo' => true
            ]
        );

        $eventoChocolate = Evento::firstOrCreate(
            ['nombre' => 'Fiesta Nacional del Chocolate'],
            [
                'provincia_id' => $rioNegro->id,
                'destino_id' => $destinoBariloche->id,
                'tipo' => 'Gastronómico',
                'fecha_inicio' => '2026-04-02',
                'fecha_fin' => '2026-04-05',
                'rango_precio' => 'Bajo',
                'imagen_url' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=500',
                'activo' => true
            ]
        );

        $eventoSerenata = Evento::firstOrCreate(
            ['nombre' => 'Serenata a Cafayate'],
            [
                'provincia_id' => $salta->id,
                'destino_id' => $destinoCafayate->id,
                'tipo' => 'Musical',
                'fecha_inicio' => '2026-02-19',
                'fecha_fin' => '2026-02-22',
                'rango_precio' => 'Medio',
                'imagen_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=500',
                'activo' => true
            ]
        );

        // 7. Crear Gastronomía
        Gastronomia::firstOrCreate(
            ['nombre' => 'Cordero Patagónico al Asador'],
            [
                'provincia_id' => $rioNegro->id,
                'descripcion' => 'Exquisitez patagónica cocinada a fuego lento durante horas, logrando una carne extremadamente tierna y sabrosa.',
                'categoria' => 'Carnes',
                'imagen_url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=500'
            ]
        );

        Gastronomia::firstOrCreate(
            ['nombre' => 'Empanadas Salteñas'],
            [
                'provincia_id' => $salta->id,
                'descripcion' => 'Las empanadas más jugosas y famosas de Argentina. Rellenas de carne cortada a cuchillo, papa, huevo y cebolla de verdeo.',
                'categoria' => 'Tradicional',
                'imagen_url' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=500'
            ]
        );

        // 8. Crear Reseñas
        $resenaDestino = Resena::firstOrCreate(
            [
                'user_id' => $turistaUser->id,
                'destino_id' => $destinoSanMartin->id,
            ],
            [
                'calificacion' => 5,
                'titulo' => 'Increíble viaje en verano',
                'comentario' => '¡San Martín de los Andes es hermoso! La Ruta de los Siete Lagos es un recorrido obligatorio. Todo impecable, un aire super puro y los chocolates increíbles.',
                'anonima' => false,
                'aprobada' => true,
            ]
        );

        // Asociar imagen a la reseña
        ImagenResena::firstOrCreate(
            [
                'resena_id' => $resenaDestino->id,
                'url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400'
            ]
        );

        Resena::firstOrCreate(
            [
                'user_id' => $turistaUser->id,
                'destino_id' => $destinoCafayate->id,
            ],
            [
                'calificacion' => 4,
                'titulo' => 'Buenas bodegas y paisajes únicos',
                'comentario' => 'Muy buenas bodegas y paisajes. Recomiendo alquilar bici para recorrer la zona de bodegas y probar las empanadas salteñas en el centro de Cafayate.',
                'anonima' => false,
                'aprobada' => true,
            ]
        );

        Resena::firstOrCreate(
            [
                'user_id' => $turistaUser->id,
                'evento_id' => $eventoChocolate->id,
            ],
            [
                'calificacion' => 5,
                'titulo' => 'Ideal para golosos',
                'comentario' => '¡Increíble la barra de chocolate gigante que hacen en la calle Mitre! Muy familiar y divertido.',
                'anonima' => false,
                'aprobada' => true,
            ]
        );

        // 9. Crear Favoritos
        Favorito::firstOrCreate([
            'user_id' => $turistaUser->id,
            'destino_id' => $destinoSanMartin->id,
        ]);

        Favorito::firstOrCreate([
            'user_id' => $turistaUser->id,
            'evento_id' => $eventoChocolate->id,
        ]);

        // 10. Crear Destinos Visitados
        DestinoVisitado::firstOrCreate([
            'user_id' => $turistaUser->id,
            'destino_id' => $destinoSanMartin->id,
            'visitado_en' => '2026-01-15',
        ]);
    }
}
