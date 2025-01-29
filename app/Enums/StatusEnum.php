<?php

namespace App\Enums;

use App\Facades\SshService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

enum StatusEnum: string
{
    case ON = '1';
    case OFF = '0';

    public function change(): JsonResponse
    {
        return match ($this){
            self::ON => $this->on(),
            self::OFF => $this->off(),
        };
    }

    private function on(): JsonResponse
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

    private function off(): JsonResponse
    {
        try {
            $connect = SshService::connect();

            $os = OSEnum::checkOS($connect);
            $os->off($connect);

            return response()->json();
        } catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
