<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\ContentPage;
use App\Models\Faq;
use App\Models\MenuItem;
use App\Models\Partner;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Content Pages",
 *     description="Everything related to content pages",
 * )
 */
class ContentPagesApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/content-pages/{contentPage}",
     *     tags={"Content Pages"},
     *     summary="Get a specific content page",
     *     description="Retrieves a specific content page by its route.",
     *     operationId="getContentPage",
     *     @OA\Parameter(
     *         name="contentPage",
     *         in="path",
     *         required=true,
     *         description="The route of the content page to retrieve",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="route",
     *                 type="string",
     *                 description="The route of the content page"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="The title of the content page description"
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     description="The HTML content of the content page description"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Content Page Not Found"
     *     )
     * )
     */
    public function show(ContentPage $contentPage): Response
    {
        $contentPage->load('description');

        // Trash but I have no time to do it correctly
        $contentPageArray = $contentPage->toArray();
        $customResponse = [
            'route' => $contentPageArray['route'],
            'description' => [
                'title' => $contentPageArray['description']['title'],
                'content' => $contentPageArray['description']['content']
            ]
        ];

        return $this->responseStrategy->render($customResponse);
    }
}
