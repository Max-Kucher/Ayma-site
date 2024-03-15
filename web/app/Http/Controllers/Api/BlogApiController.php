<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Jobs\ParseMediumRssFeed;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Blog",
 *     description="Everything related to blog",
 * )
 */
class BlogApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/blog",
     *     summary="Retrieve a list of posts",
     *     tags={"Blog"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved list of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Title of the post"
     *                 ),
     *                 @OA\Property(
     *                     property="link",
     *                     type="string",
     *                     description="URL link to the post"
     *                 ),
     *                 @OA\Property(
     *                     property="pubDate",
     *                     type="object",
     *                     @OA\Property(
     *                         property="date",
     *                         type="string",
     *                         description="Publication date of the post"
     *                     ),
     *                     @OA\Property(
     *                         property="timezone_type",
     *                         type="integer",
     *                         description="Type of the timezone"
     *                     ),
     *                     @OA\Property(
     *                         property="timezone",
     *                         type="string",
     *                         description="Timezone of the publication date"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content, no posts found"
     *     )
     * )
     */
    public function index(): Response
    {
        $posts = Cache::get('medium_posts') ?? [];
        return $this->responseStrategy->render($posts);
    }

    //        $parser = app()->make(ParseMediumRssFeed::class);
//        $parser->handle();

//        Cache::delete('medium_posts');
}
