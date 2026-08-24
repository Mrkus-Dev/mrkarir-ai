<?php

declare(strict_types=1);

$_ENV['DB_PATH'] = 'storage/database/test.sqlite';
require dirname(__DIR__) . '/src/bootstrap.php';

$testDatabase = PROJECT_ROOT . '/storage/database/test.sqlite';
if (is_file($testDatabase)) {
    unlink($testDatabase);
}

$pdo = Database::connect(PROJECT_ROOT);
$pdo->exec((string) file_get_contents(PROJECT_ROOT . '/database/schema.sql'));
$pdo->exec((string) file_get_contents(PROJECT_ROOT . '/database/seed.sql'));
$repository = new JobRepository($pdo);

$checks = [
    'seed menghasilkan lowongan' => $repository->count('', '', false) >= 3,
    'filter remote bekerja' => $repository->count('', '', true) >= 2,
    'pencarian bekerja' => $repository->count('Developer', '', false) >= 1,
    'detail ditemukan' => $repository->find(1) !== null,
    'ID tidak ada menghasilkan null' => $repository->find(999999) === null,
];

$failed = 0;
foreach ($checks as $name => $passed) {
    echo ($passed ? 'PASS' : 'FAIL') . " - {$name}\n";
    $failed += $passed ? 0 : 1;
}

exit($failed === 0 ? 0 : 1);
