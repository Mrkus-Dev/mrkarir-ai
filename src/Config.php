<?php

declare(strict_types=1);

final class Config
{
    private static array $values = [];

    public static function load(string $root): void
    {
        $file = $root . '/.env';
        if (is_file($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                    continue;
                }

                [$key, $value] = array_map('trim', explode('=', $line, 2));
                $value = trim($value, "\"'");
                if ($key !== '') {
                    self::$values[$key] = $value;
                }
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, self::$values)) {
            return self::$values[$key];
        }
        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        $environmentValue = getenv($key);
        return $environmentValue === false ? $default : $environmentValue;
    }
}
