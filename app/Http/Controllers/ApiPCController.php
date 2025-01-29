<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Services\SshService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiPCController extends Controller
{
    public function __construct(private SshService $sshService)
    {
    }

    public function change(StatusEnum $status): JsonResponse
    {
        return $status->change();
    }

    public function check(): JsonResponse
    {
        try {
            $this->sshService->connect();

            return response()->json([
                'value' => true,
            ]);
        } catch (\Exception $exception){
            return response()->json([
                'value' => false,
            ]);
        }
    }
}
