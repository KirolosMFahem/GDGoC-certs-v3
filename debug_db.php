<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Default Database: " . config('database.default') . "\n";
echo "Driver Name: " . \Illuminate\Support\Facades\DB::connection()->getDriverName() . "\n";
