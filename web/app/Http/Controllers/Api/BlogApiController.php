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
class BlogApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    public function index(): Response
    {
        return $this->responseStrategy->render([]);
    }
}
