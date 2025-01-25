<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Ssh\Ssh;

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
//        $ssh = Ssh::create(config('ssh.user'), config('ssh.host'))
//            ->usePassword(config('ssh.password'));
//
////        $command = 'echo '.config('ssh.password').' | sudo -S poweroff';
////        $command = 'echo 1';
//        $command = 'mkdir test';
//        $process = $ssh->execute($command);

//        $connection = ssh2_connect('shell.example.com', 22);
//        ssh2_auth_password($connection, 'username', 'password');
//
//        $stream = ssh2_exec($connection, '/usr/local/bin/php -i');

//        return response()->json([
//            'message' => $process->getErrorOutput(),
//            'code' => $process->getExitCode(),
//        ], $process->isSuccessful() ? 200 : 500);
        return response()->json();
    }
}
