<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Disable foreign key checks, delete rooms, re-enable
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
DB::table('inpatients')->truncate();
DB::table('rooms')->truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

echo "All rooms and inpatients deleted successfully!\n";
echo "Rooms remaining: " . DB::table('rooms')->count() . "\n";
echo "Wards available: " . DB::table('wards')->count() . "\n";
