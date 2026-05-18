<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API ProVentas",
    description: "Documentación API Laravel 12"
)]

#[OA\Server(
    url: "http://127.0.0.1:8000/api",
    description: "Servidor Local"
)]

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]


class OpenApi
{
}