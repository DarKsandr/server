<?php

namespace App\Enums;

use App\Facades\SshService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

enum StatusEnum: int
{
    case ENABLE = 1;
    case DISABLE = 0;

    public function change(): JsonResponse
    {
        return match ($this){
            self::ENABLE => $this->enable(),
            self::DISABLE => $this->disable(),
        };
    }

    private function enable(): JsonResponse
    {
        /**
         * @var PendingRequest $http
         */
        $http = Http::keenetic();
        $response = $http->post('ip/hotspot/wake', [
            'mac' => config('keenetic.mac.pc'),
        ]);
        return response()->json($response->json(), $response->status());
    }

    private function disable(): JsonResponse
    {
        try {
            $connect = SshService::connect();

            $stream = ssh2_exec($connect, 'echo "'.config('ssh.password').'" | sudo -S poweroff');

            $sio_stream  = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            stream_set_blocking($sio_stream , true);
            $result_dio = stream_get_contents($sio_stream);

            return response()->json([
                'message' => $result_dio,
            ]);
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
