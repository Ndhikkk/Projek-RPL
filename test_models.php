<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['GEMINI_API_KEY'] ?? '';

$ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'x-goog-api-key: ' . $apiKey
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
