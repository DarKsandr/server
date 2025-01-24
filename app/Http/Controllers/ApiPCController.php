<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiPCController extends Controller
{
    private PendingRequest $http;
    public function __construct()
    {
        $this->http = Http::keenetic();
    }

    public function enable(): JsonResponse
    {
        $response = $this->http->post('ip/hotspot/wake', [
            'mac' => config('keenetic.mac.pc'),
        ]);
        return response()->json($response->json(), $response->status());
    }
}
