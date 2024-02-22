<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Schema(
 *     schema="Language",
 *     type="object",
 *     title="Language",
 *     description="Language entity",
 *     @OA\Property(
 *         property="lang_code",
 *         type="string",
 *         description="Language code"
 *     ),
 *     @OA\Property(
 *         property="locale",
 *         type="string",
 *         description="Language locale"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the language"
 *     ),
 *     @OA\Property(
 *         property="is_default",
 *         type="boolean",
 *         description="Indicates if this language is the default language"
 *     )
 * )
 */
class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lang_code',
        'locale',
        'is_default',
    ];
}
