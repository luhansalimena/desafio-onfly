<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Desafio OnFly API",
 *     version="1.0.0",
 *     description="API Documentation for Desafio OnFly application",
 *     @OA\Contact(
 *         email="lsalimena6@gmail.com",
 *         name="Luhan Salimena"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local API Server"
 * )
 *  @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
