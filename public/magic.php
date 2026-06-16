<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\Artisan::call('db:wipe', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    
    $sql = file_get_contents(__DIR__.'/../bd.sql');
    $lines = explode("\n", $sql);
    
    $tables = ['roles', 'permisos', 'role_permiso', 'provincias', 'destinos', 'eventos'];
    $insertsByTable = array_fill_keys($tables, []);
    
    foreach ($lines as $line) {
        if (strpos($line, 'INSERT INTO public.') === 0) {
            foreach ($tables as $table) {
                if (strpos($line, "INSERT INTO public.$table ") === 0) {
                    $insertsByTable[$table][] = $line;
                    break;
                }
            }
        }
    }
    
    $query = "";
    $count = 0;
    foreach ($tables as $table) {
        if (!empty($insertsByTable[$table])) {
            $query .= implode("\n", $insertsByTable[$table]) . "\n";
            $count += count($insertsByTable[$table]);
        }
    }
    
    if (empty($query)) {
        echo "No se encontraron inserts de datos.";
        exit;
    }
    
    \Illuminate\Support\Facades\DB::unprepared($query);
    
    echo "¡Éxito total! Se extrajeron e inyectaron $count joyas de tu archivo (Provincias, Destinos, Eventos y Permisos). Ya podés volver a la página principal.";
    
} catch (\Exception $e) {
    echo "Error REAL: " . $e->getMessage();
}
