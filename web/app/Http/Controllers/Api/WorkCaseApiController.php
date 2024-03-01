<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\WorkCase;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Partners",
 *     description="Everything related to partners",
 * )
 */
class WorkCaseApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/work-cases",
     *     tags={"WorkCase"},
     *     summary="Get the list of work cases",
     *     description="Retrieves a list of work cases.",
     *     operationId="getWorkCases",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/WorkCase")
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
    public function index(): Response
    {
        $workCases = WorkCase::with(['description' => function ($query) {
            $query->select('work_case_id', 'name', 'description');
        }])->get(['id', 'file_path', 'link'])->map(function ($case) {

            $case->file_url = asset(str_replace('public/', 'storage/', $case->file_path));

            return [
                'file_path' => $case->file_url,
                'link' => $case->link,
                'name' => $case->description->name ?? null,
                'description' => $case->description->description ?? null,
            ];
        });

        return $this->responseStrategy->render($workCases);
    }
}
