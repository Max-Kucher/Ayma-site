<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Response\ResponseStrategy;
use App\Http\Controllers\Controller;
use Google\Exception;
use Google\Service;
use App\Http\Requests\CallbackFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\OpenApi as OA;
use Google\Client;
use Google\Service\Sheets;

/**
 * @OA\Tag(
 *     name="Forms",
 *     description="Everything related to website forms",
 * )
 */
class FormApiController extends Controller
{
    protected ResponseStrategy $responseStrategy;

    public function __construct(ResponseStrategy $strategy)
    {
        $this->responseStrategy = $strategy;
    }

    /**
     * @OA\Post(
     *     path="/api/form",
     *     operationId="submitApplication",
     *     tags={"Forms"},
     *     summary="Submit a new application",
     *     description="Allows users to submit a new application with their contact details and comments.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User application data",
     *         @OA\JsonContent(
     *             required={"type", "name", "phone", "email"},
     *             @OA\Property(property="type", type="string", description="Type of the application"),
     *             @OA\Property(property="name", type="string", description="Full name of the user"),
     *             @OA\Property(property="phone", type="string", description="Contact phone number"),
     *             @OA\Property(property="email", type="string", format="email", description="Email address"),
     *             @OA\Property(property="telegram", type="string", description="Telegram username"),
     *             @OA\Property(property="comment", type="string", description="Additional comments")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Application submitted successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(CallbackFormRequest $request): Response
    {
        $appendToSheet = function (Service $service, string $spreadsheetId, $range, $values)
        {
            $body = new Sheets\ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => 'RAW'
            ];

            return $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        };

        $client = new Client();
        $client->setApplicationName("Google Sheets Example");
        $client->setScopes([Sheets::SPREADSHEETS]);

        try {
            $client->setAuthConfig(config('custom.service_account_config'));
        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }

        $service = new Sheets($client);

        $spreadsheetId = config('custom.form_sheet');
        try {
            $response = $service->spreadsheets->get($spreadsheetId);
        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }

        $sheets = $response->getSheets();

        $range = $sheets[0]->getProperties()->getTitle();
        $values = [
            array_values($request->all()),
        ];

        $appendToSheet($service, $spreadsheetId, $range, $values);

        return $this->responseStrategy->render([
            'success' => true,
        ]);
    }
}
