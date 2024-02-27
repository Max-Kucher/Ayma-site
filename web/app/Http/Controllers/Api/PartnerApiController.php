<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Partner;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Partners",
 *     description="Everything related to partners",
 * )
 */
class PartnerApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/partners",
     *     tags={"Partners"},
     *     summary="Get the list of partners",
     *     description="Retrieves a list of partners.",
     *     operationId="getPartners",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Partner")
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
        $partners = Partner::with(['description' => function ($query) {
            $query->select('partner_id', 'name');
        }])->get(['id', 'file_path', 'link', 'location'])->map(function ($partner) {

            $partner->file_url = asset('storage/' . $partner->file_path);

            return [
                'file_path' => $partner->file_url,
                'link' => $partner->link,
                'location' => $partner->location,
                'name' => $partner->description ? $partner->description->name : 'No name', // Предоставление имени из описания
            ];
        });

        return $this->responseStrategy->render($partners);
    }
}
