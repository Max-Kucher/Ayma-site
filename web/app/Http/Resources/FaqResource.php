<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\OpenApi as OA;

class FaqResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Faq",
     *     required={"id", "description"},
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         format="int64",
     *         description="The FAQ identifier"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="object",
     *         ref="#/components/schemas/FaqDescription"
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
            'id' => $this->id,
            'description' => new FaqDescriptionResource($this->description),
        ];
    }
}
