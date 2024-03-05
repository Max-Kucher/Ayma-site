<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\WorkCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Partners",
 *     description="Everything related to partners",
 * )
 */
class SettingApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/settings",
     *     tags={"Setting"},
     *     summary="Get the list of settings",
     *     description="Retrieves a list of settings.",
     *     operationId="getSettings",
     *     @OA\Parameter(
     *         name="as-hash",
     *         in="query",
     *         description="When set, the settings are returned as a hash map of key-value pairs.",
     *         required=false,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Setting")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function index(Request $request): Response
    {
        $settings = Setting::get(['key', 'value']);

        if ($request->has('as-hash')) {
            $settings = $settings->pluck('value', 'key');
        }

        return $this->responseStrategy->render($settings);
    }
}
