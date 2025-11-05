<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;

// Variables para la conexion a la base de datos
return [
    'settings' => [
        'db' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'name' => 'api_prueba_tecnica',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8mb4',
        ],
        // 'displayErrorDetails' => true, // Solo en Desarrollo
        'displayErrorDetails' => true,    // Solo en Produccion
    ],

    // creo la conexion a la base de datos objeto PDO
    PDO::class => function (ContainerInterface $c): PDO {
        $cfg = $c->get('settings')['db'];
        $dsn = "mysql:host={$cfg['host']};port={$cfg['port']};dbname={$cfg['name']};charset={$cfg['charset']}";
        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    },
];