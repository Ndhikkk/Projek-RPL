<?php
$env = parse_ini_file('.env');
$key = $env['GEMINI_API_KEY'] ?? '';

$url = 'https://generativelanguage.googleapis.com/v1beta/models?key=' . $key;

$opts = [
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
];
$context = stream_context_create($opts);

$response = file_get_contents($url, false, $context);
echo $response;
