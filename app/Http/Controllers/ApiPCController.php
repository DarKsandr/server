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

    public function disable(): JsonResponse
    {
        try {
            $connection = ssh2_connect(config('ssh.host'));
            if(!$connection){
                throw new \Exception('Connection to SSH failed');
            }
            if(!ssh2_auth_password($connection, config('ssh.user'), config('ssh.password'))){
                throw new \Exception('Password authentication failed');
            }

            ssh2_exec($connection, 'echo "'.config('ssh.password').'" | sudo -S poweroff');

            return response()->json([
                'message' => '',
            ]);
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
