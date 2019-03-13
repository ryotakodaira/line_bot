<?php
/**
 * Created by PhpStorm.
 * User: RyotaKodaira
 * Date: 2019-03-05
 * Time: 16:34
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class HealthCheckController extends Controller
{
    public function get()
    {
        return ['message' => 'ok'];
    }
}
