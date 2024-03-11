<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\Service;
use App\Models\WorkCase;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Services",
 *     description="Everything related to services",
 * )
 */
class ServiceApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/services",
     *     tags={"Services"},
     *     summary="Get the list of services",
     *     description="Retrieves a list of services including related service items and descriptions.",
     *     operationId="getServices",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Service")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Services not found"
     *     )
     * )
     */
    public function index(): Response
    {
        // ToDo: Rework with API resources
        $services = Service::with(['description' => function ($query) {
            $query->select('service_id', 'name', 'description');
        },
            'serviceItems' => function ($query) {
                $query->with(['description' => function ($subQuery) {
                    $subQuery->select('service_item_id', 'name');
                }]);
            }])
            ->get(['id']);

        return $this->responseStrategy->render($services);
    }
}
