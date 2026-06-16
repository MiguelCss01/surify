<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$models = glob(__DIR__.'/app/Models/*.php');
foreach($models as $model) {
    $class = 'App\\Models\\' . basename($model, '.php');
    if (class_exists($class)) {
        $obj = new $class;
        echo "\n--- " . basename($model, '.php') . " ---\n";
        if (method_exists($obj, 'getFillable')) {
            echo "Attributes: " . implode(', ', $obj->getFillable()) . "\n";
        }
        $methods = get_class_methods($class);
        $relations = [];
        foreach($methods as $method) {
            $ref = new ReflectionMethod($class, $method);
            if ($ref->class == $class && $ref->getNumberOfParameters() == 0) {
                try {
                    $returnType = $ref->getReturnType();
                    if ($returnType && str_contains($returnType->getName(), 'Relations')) {
                        $relations[] = $method . ' -> ' . class_basename($returnType->getName());
                    }
                } catch(Exception $e) {}
            }
        }
        echo "Relations: " . implode(', ', $relations) . "\n";
    }
}
