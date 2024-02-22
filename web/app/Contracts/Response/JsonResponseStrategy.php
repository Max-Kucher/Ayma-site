<?php

namespace App\Contracts\Response;

use Illuminate\Http\JsonResponse;

class JsonResponseStrategy implements ResponseStrategy
{

    public function render($data): JsonResponse
    {
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
