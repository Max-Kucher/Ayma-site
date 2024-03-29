<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @OA\Schema(
 *     schema="Partner",
 *     type="object",
 *     title="Partner",
 *     description="The partner model representation.",
 *     @OA\Property(
 *         property="file_url",
 *         type="string",
 *         format="uri",
 *         description="The URL to the partner's file."
 *     ),
 *     @OA\Property(
 *         property="link",
 *         type="string",
 *         format="uri",
 *         description="The URL to the partner's website."
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="string",
 *         enum={"top", "bottom"},
 *         description="The location where the partner's information is displayed, either 'top' or 'bottom'."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the partner."
 *     )
 * )
 */
class Partner extends Model
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
        'location',
    ];

    public function description(): HasOne
    {
        $lang_id = session('current_language_id');
        return $this->hasOne(PartnerDescription::class)->where('language_id', $lang_id);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(PartnerDescription::class);
    }
}
