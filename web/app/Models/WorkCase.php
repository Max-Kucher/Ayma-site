<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Schema(
 *     schema="WorkCase",
 *     type="object",
 *     title="Work Case",
 *     description="Case model representation.",
 *     @OA\Property(
 *         property="file_url",
 *         type="string",
 *         format="uri",
 *         description="The URL to the case's file."
 *     ),
 *     @OA\Property(
 *         property="link",
 *         type="string",
 *         format="uri",
 *         description="The URL to the case's website."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the case."
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Full description of the case."
 *     )
 * )
 */
class WorkCase extends Model
{
    use HasFactory;

    protected $casts = [
        'file_path' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'link',
        'file_path',
    ];

    public function description(): HasOne
    {
        $lang_id = session('current_language_id');
        return $this->hasOne(WorkCaseDescription::class)->where('language_id', $lang_id);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(WorkCaseDescription::class);
    }
}
