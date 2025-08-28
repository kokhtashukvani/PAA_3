<?php

/**
 * Database Connection Handler
 */

/**
 * The PDO connection instance.
 * @var PDO|null
 */
$pdo = null;

/**
 * Get a database connection using PDO.
 * Creates a new connection if one doesn't exist, otherwise returns the existing one.
 *
 * @return PDO The PDO database connection instance.
 */
function get_db_connection()
{
    global $pdo;

    // Return existing connection if it exists
    if ($pdo !== null) {
        return $pdo;
    }

    // Database connection details from config
    $host = DB_HOST;
    $dbname = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // For a real application, you would log this error and show a generic message.
        // For development, it's okay to show the error.
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
