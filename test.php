<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$key = env('GEMINI_API_KEY');
$url = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . $key;
$response = file_get_contents($url);
echo $response;
