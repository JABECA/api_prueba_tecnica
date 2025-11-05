<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    
    //****** 2.1 GET /vehiculos/{placa}/viajes ******
    
    $app->get('/vehiculos/{placa}/viajes', function (Request $req, Response $res, array $args) {
        /** @var PDO $pdo */
        $pdo = $this->get(PDO::class);
        $placa = strtoupper(trim($args['placa'] ?? ''));

        $stmt = $pdo->prepare("SELECT id, placa, color FROM vehiculos WHERE placa = ?");
        $stmt->execute([$placa]);
        $vehiculo = $stmt->fetch();

        if (!$vehiculo) {
            return errorJson($res, 404, "Vehículo no encontrado para placa {$placa}");
        }

        $sql = "SELECT v.id,
                       v.fecha,
                       v.tiempo_min,
                       co.nombre AS ciudad_origen,
                       cd.nombre AS ciudad_destino
                FROM viajes v
                JOIN ciudades co ON co.id = v.ciudad_origen_id
                JOIN ciudades cd ON cd.id = v.ciudad_destino_id
                WHERE v.vehiculo_id = ?
                ORDER BY v.fecha DESC, v.id DESC";
        $st = $pdo->prepare($sql);
        $st->execute([$vehiculo['id']]);
        $viajes = $st->fetchAll();

        return okJson($res, ['vehiculo' => $vehiculo, 'viajes' => $viajes]);
    });

    //***** 2.2 POST /viajes ******

    $app->post('/viajes', function (Request $req, Response $res) {
        /** @var PDO $pdo */
        $pdo = $this->get(PDO::class);
        $b = jsonBody($req);

        $vehiculo_id       = $b['vehiculo_id']       ?? null;
        $ciudad_origen_id  = $b['ciudad_origen_id']  ?? null;
        $ciudad_destino_id = $b['ciudad_destino_id'] ?? null;
        $tiempo_min        = $b['tiempo_min']        ?? null;
        $fecha             = $b['fecha']             ?? null;

        if (!is_numeric($vehiculo_id) || !is_numeric($ciudad_origen_id) || !is_numeric($ciudad_destino_id)
            || !is_numeric($tiempo_min) || !isValidDate((string)$fecha)) {
            return errorJson($res, 422, "Parámetros inválidos u omitidos. Requiere: vehiculo_id, ciudad_origen_id, ciudad_destino_id, tiempo_min (int), fecha (YYYY-MM-DD).");
        }
        if ((int)$tiempo_min <= 0) {
            return errorJson($res, 422, "tiempo_min debe ser > 0.");
        }

        $exists = function (PDO $pdo, string $table, int $id): bool {
            $st = $pdo->prepare("SELECT 1 FROM {$table} WHERE id = ?");
            $st->execute([$id]);
            return (bool)$st->fetchColumn();
        };

        if (!$exists($pdo, 'vehiculos', (int)$vehiculo_id)) {
            return errorJson($res, 404, "vehiculo_id no existe.");
        }
        if (!$exists($pdo, 'ciudades', (int)$ciudad_origen_id)) {
            return errorJson($res, 404, "ciudad_origen_id no existe.");
        }
        if (!$exists($pdo, 'ciudades', (int)$ciudad_destino_id)) {
            return errorJson($res, 404, "ciudad_destino_id no existe.");
        }

        $sql = "INSERT INTO viajes (vehiculo_id, ciudad_origen_id, ciudad_destino_id, tiempo_min, fecha)
                VALUES (?, ?, ?, ?, ?)";
        $ins = $pdo->prepare($sql);
        $ins->execute([(int)$vehiculo_id, (int)$ciudad_origen_id, (int)$ciudad_destino_id, (int)$tiempo_min, $fecha]);

        $id = (int)$pdo->lastInsertId();

        $sel = $pdo->prepare("SELECT v.id, v.fecha, v.tiempo_min,
                                     co.nombre AS ciudad_origen, cd.nombre AS ciudad_destino,
                                     ve.placa
                              FROM viajes v
                              JOIN ciudades co ON co.id = v.ciudad_origen_id
                              JOIN ciudades cd ON cd.id = v.ciudad_destino_id
                              JOIN vehiculos ve ON ve.id = v.vehiculo_id
                              WHERE v.id = ?");
        $sel->execute([$id]);
        $row = $sel->fetch();

        return okJson($res, $row, 201);
    });

    //**** 2.3 PATCH /vehiculos/{placa}/color ******

    $app->patch('/vehiculos/{placa}/color', function (Request $req, Response $res, array $args) {
        /** @var PDO $pdo */
        $pdo = $this->get(PDO::class);
        $placa = strtoupper(trim($args['placa'] ?? ''));
        $b = jsonBody($req);
        $color = trim((string)($b['color'] ?? ''));

        if ($placa === '' || $color === '') {
            return errorJson($res, 422, "Debe enviar placa (en ruta) y color (en body).");
        }

        $sel = $pdo->prepare("SELECT id, placa, color FROM vehiculos WHERE placa = ?");
        $sel->execute([$placa]);
        $vehiculo = $sel->fetch();
        if (!$vehiculo) {
            return errorJson($res, 404, "Vehículo no encontrado para placa {$placa}");
        }

        $upd = $pdo->prepare("UPDATE vehiculos SET color = ? WHERE placa = ?");
        $upd->execute([$color, $placa]);

        $sel->execute([$placa]);
        $vehiculo = $sel->fetch();
        return okJson($res, $vehiculo);
    });
};