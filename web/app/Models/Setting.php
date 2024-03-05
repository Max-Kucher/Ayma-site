<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Schema(
 *     schema="Setting",
 *     type="object",
 *     title="Setting",
 *     description="Setting model representation.",
 *     @OA\Property(
 *         property="key",
 *         type="string",
 *         description="The setting key."
 *     ),
 *     @OA\Property(
 *         property="value",
 *         type="string",
 *         description="The setting value."
 *     )
 * )
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
