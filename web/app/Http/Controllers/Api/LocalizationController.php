<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations\OpenApi as OA;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocalizationController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Get(
     *     path="/api/translations/{locale}",
     *     operationId="getTranslations",
     *     tags={"Localisation"},
     *     summary="Retrieves translations for the specified locale",
     *     description="Returns translations in JSON format. If no locale is specified, the default locale is used.",
     *     @OA\Parameter(
     *         name="locale",
     *         in="path",
     *         description="Locale code (for example 'en' or 'ru')",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\AdditionalProperties(
     *                 type="string"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Locale not found"
     *     )
     * )
     */
    public function translations(?string $locale = null): Response
    {
        if (is_null($locale)) {
            $locale = app()->getLocale();
        } elseif (!is_dir(resource_path("lang/$locale")) && !file_exists(resource_path("lang/$locale.json"))) {
            throw new NotFoundHttpException(__('errors.locale_is_not_supported'));
        }

        $phpTranslationsPath = resource_path("lang/$locale");
        $phpTranslations = is_dir($phpTranslationsPath) ? collect(File::allFiles($phpTranslationsPath))->flatMap(function ($file) {
            return [
                ($translation = $file->getBasename('.php')) => trans($translation),
            ];
        })->toArray() : [];

        $jsonTranslationsPath = resource_path("lang/$locale.json");
        $jsonTranslations = file_exists($jsonTranslationsPath) ? json_decode(file_get_contents($jsonTranslationsPath), true) : [];

        return $this->responseStrategy->render(array_merge($phpTranslations, $jsonTranslations));
    }
}
