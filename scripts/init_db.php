<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$pdo = Database::connect(PROJECT_ROOT);
$schema = file_get_contents(PROJECT_ROOT . '/database/schema.sql');
$seed = file_get_contents(PROJECT_ROOT . '/database/seed.sql');

if ($schema === false || $seed === false) {
    fwrite(STDERR, "ERROR: schema atau seed tidak dapat dibaca.\n");
    exit(1);
}

$pdo->exec($schema);
$pdo->exec($seed);

$count = (int) $pdo->query('SELECT COUNT(*) FROM jobs')->fetchColumn();
echo "Database siap. Total lowongan demo: {$count}\n";
