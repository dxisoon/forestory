<?php

declare(strict_types=1);

require_once __DIR__ . '/env.php';

/**
 * Open a MySQL connection using DB_* from the environment (or safe local defaults).
 */
function forestory_db_connect(): mysqli
{
    forestory_load_env();

    $host = getenv('DB_HOST') !== false ? getenv('DB_HOST') : 'localhost';
    $user = getenv('DB_USER') !== false ? getenv('DB_USER') : 'root';
    $pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
    $name = getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'tree';

    $conn = @mysqli_connect($host, $user, $pass, $name);
    if (!$conn) {
        die('Could not connect to MySQL: ' . mysqli_connect_error());
    }
    mysqli_set_charset($conn, 'utf8');
    return $conn;
}
