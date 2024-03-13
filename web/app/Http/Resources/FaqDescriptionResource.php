<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\OpenApi as OA;

class FaqDescriptionResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="FaqDescription",
     *     required={"question", "answer"},
     *     @OA\Property(
     *         property="question",
     *         type="string",
     *         description="The question of the FAQ"
     *     ),
     *     @OA\Property(
     *         property="answer",
     *         type="string",
     *         description="The answer to the FAQ question"
     *     )
     * )
     *
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}
