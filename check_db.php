<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
try {
    $hasColumn = Schema::hasColumn('categories', 'employee_id');
    file_put_contents('db_check.txt', $hasColumn ? 'YES' : 'NO');
} catch (\Exception $e) {
    file_put_contents('db_check.txt', 'ERROR: ' . $e->getMessage());
}
