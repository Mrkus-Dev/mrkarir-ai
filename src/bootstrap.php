<?php

declare(strict_types=1);

define('PROJECT_ROOT', dirname(__DIR__));

require_once PROJECT_ROOT . '/src/Config.php';
require_once PROJECT_ROOT . '/src/Database.php';
require_once PROJECT_ROOT . '/src/JobRepository.php';

Config::load(PROJECT_ROOT);

function h(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function excerpt(mixed $value, int $limit = 170): string
{
    $text = (string) $value;
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $limit, '…', 'UTF-8');
    }

    return strlen($text) > $limit ? substr($text, 0, $limit - 3) . '...' : $text;
}
