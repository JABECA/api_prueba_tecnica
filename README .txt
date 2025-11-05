## Notas al proyecto


2. API PRUEBA TÉCNICA (Slim 4)
  ***************************
  Requisitos: PHP 8.x (XAMPP recomendado), Composer, MySQL / MariaDB
  Instalación:
  ***********
  1) Copiar la carpeta api_prueba_tecnica a C:\xampp\htdocs\api_prueba_tecnica
  2) Dentro de la carpeta del proyecto ejecutar composer install para instalar librerias y dependencias necearias
  3) Creae la base de datos e importa api_prueba_tecnica.sql
  4) En el servidor XAMPP, iniciar Apache y MySQL.
  5) Probar los endpoints:

2.1 GET viajes por placa: http://localhost/api_prueba_tecnica/vehiculos/ABC123/viajes

2.2 POST crear viaje: URL: http://localhost/api_prueba_tecnica/viajes
    Body raw (JSON): {  "vehiculo_id": 1,
                        "ciudad_origen_id": 1,
                        "ciudad_destino_id": 2,
                        "tiempo_min": 80,
                        "fecha": "2025-11-05"
                      }

2.3 PATCH actualizar color por placa URL: http://localhost/api_prueba_tecnica/vehiculos/ABC123/color
    Body raw (JSON): { "color": "Azul Rey" }

Notas: Configure la BD en src/db.php (root sin contraseña, DB: api_prueba_tecnica), por efectos de pruebas y de la prueba aunque en produccion se debe colocar una contraseña fuerte.
       


Coleccion POSTMAN para consumo de la api:
{
  "info": {
    "_postman_id": "25010d8b-4cf6-425f-bcdb-d1046aaee8c8",
    "name": "Api prueba tecnica",
    "schema": "https://schema.getpostman.com/json/collection/v2.0.0/collection.json",
    "_exporter_id": "4803759"
  },
  "item": [
    {
      "name": "2.1 Consultar los viajes de un vehículo por placa",
      "request": {
        "method": "GET",
        "header": [],
        "url": "http://localhost/api_prueba_tecnica/public/vehiculos/BBB456/viajes"
      },
      "response": []
    },
    {
      "name": "2.2 Crear viajes",
      "request": {
        "method": "POST",
        "header": [],
        "body": {
          "mode": "raw",
          "raw": "{\r\n  \"vehiculo_id\": 1,\r\n  \"ciudad_origen_id\": 1,\r\n  \"ciudad_destino_id\": 2,\r\n  \"tiempo_min\": 95,\r\n  \"fecha\": \"2025-10-08\"\r\n}",
          "options": {
            "raw": {
              "language": "json"
            }
          }
        },
        "url": "http://localhost/api_prueba_tecnica/public/viajes"
      },
      "response": []
    },
    {
      "name": "2.3 Actualizar el color de un vehículo por placa",
      "request": {
        "method": "PATCH",
        "header": [],
        "body": {
          "mode": "raw",
          "raw": "{ \"color\": \"Verde\" }",
          "options": {
            "raw": {
              "language": "json"
            }
          }
        },
        "url": "http://localhost/api_prueba_tecnica/public/vehiculos/BBB456/color"
      },
      "response": []
    }
  ]
}
