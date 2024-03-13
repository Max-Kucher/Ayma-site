<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use App\Models\MenuItem;
use App\Models\Partner;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="FAQs",
 *     description="Everything related to FAQs",
 * )
 */
class FaqsApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/faqs",
     *     tags={"FAQs"},
     *     summary="Get the list of FAQs",
     *     description="Retrieves a list of FAQs.",
     *     operationId="getFaqs",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Faq")
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


        $faqs = Faq::with(['description' => function ($query) {
            $query->select('faq_id', 'question', 'answer');
        }])->get(['id']);

        return $this->responseStrategy->render(
            FaqResource::collection($faqs)
        );
    }
}
