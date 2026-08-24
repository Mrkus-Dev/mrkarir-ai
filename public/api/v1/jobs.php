<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    header('Allow: GET');
    echo json_encode(['error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

require dirname(__DIR__, 3) . '/src/bootstrap.php';

$expectedKey = (string) Config::get('API_KEY', '');
if ($expectedKey !== '' && $expectedKey !== 'change-this-before-production') {
    $providedKey = (string) ($_SERVER['HTTP_X_API_KEY'] ?? '');
    if (!hash_equals($expectedKey, $providedKey)) {
        http_response_code(401);
        echo json_encode(['error' => 'API key tidak valid'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$limit = min(50, max(1, filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT) ?: 20));
$page = max(1, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1);
$query = trim((string) ($_GET['q'] ?? ''));
$location = trim((string) ($_GET['location'] ?? ''));
$remote = ($_GET['remote'] ?? '') === '1';

try {
    $repository = new JobRepository(Database::connect(PROJECT_ROOT));
    $total = $repository->count($query, $location, $remote);
    $data = $repository->search($query, $location, $remote, $limit, ($page - 1) * $limit);
    echo json_encode([
        'data' => $data,
        'meta' => ['page' => $page, 'limit' => $limit, 'total' => $total],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['error' => 'Layanan belum siap'], JSON_UNESCAPED_UNICODE);
}
