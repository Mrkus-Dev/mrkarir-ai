<?php

declare(strict_types=1);

final class Database
{
    public static function connect(string $root): PDO
    {
        $configured = (string) Config::get('DB_PATH', 'storage/database/mrkarir.sqlite');
        $path = str_starts_with($configured, '/') ? $configured : $root . '/' . $configured;
        $directory = dirname($path);

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new RuntimeException('Tidak dapat membuat direktori database.');
        }

        $pdo = new PDO('sqlite:' . $path, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        $pdo->exec('PRAGMA foreign_keys = ON');
        $pdo->exec('PRAGMA busy_timeout = 5000');

        return $pdo;
    }
}
