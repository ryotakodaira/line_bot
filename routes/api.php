<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** @var Illuminate\Routing\Router $router */
$router = app('Illuminate\Routing\Router');

$router->get('/health-check', 'HealthCheckController@get')->name('health.check');

$router->post('/line/webhook', 'LineWebHookController@webHook')->name('line.webhook');
