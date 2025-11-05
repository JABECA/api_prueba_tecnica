<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

function isValidDate(string $date): bool {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function jsonBody(ServerRequestInterface $req): array {
    $raw = (string)$req->getBody();
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

// formateo la salida o response con el error del endpoint
function errorJson(ResponseInterface $res, int $status, string $message, array $extra = []) {
    $payload = ['ok' => 'El API respondio con estado '. $status, 'message' => $message] + $extra;
    $res->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
    return $res->withHeader('Content-Type', 'application/json')->withStatus($status);
}

// formateo la salida o response con el exito del endpoint
function okJson(ResponseInterface $res, array $data = [], int $status = 200) {
    $res->getBody()->write(json_encode(['ok' => 'El API respondio con estado '. $status , 'data' => $data], JSON_UNESCAPED_UNICODE));
    return $res->withHeader('Content-Type', 'application/json')->withStatus($status);
}