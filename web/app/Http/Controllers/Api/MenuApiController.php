<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Tag(
 *     name="Menu",
 *     description="Everything related to menus",
 * )
 */
class MenuApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/menus",
     *     tags={"Menu"},
     *     summary="Get the list of menu items",
     *     description="Retrieves a list of menu items with optional nested children.",
     *     operationId="getMenuItems",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/MenuItem")
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
        $menuItems = MenuItem::with('description')->whereNull('parent_id')->get();

        $formattedMenu = $menuItems->map(function ($item) {
            return $this->formatMenuItem($item);
        });

        return $this->responseStrategy->render($formattedMenu);
    }

    protected function formatMenuItem(MenuItem $item): array
    {
        $formatted = [
            'link' => $item->link,
            'name' => $item->description->name ?? 'No name',
        ];

        if ($item->children()->exists()) {
            $formatted['children'] = $item->children()->with('description')->get()->map(function ($child) {
                return $this->formatMenuItem($child);
            });
        }

        return $formatted;
    }
}
