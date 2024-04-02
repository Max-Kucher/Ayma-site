<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Schema(
 *     schema="ServiceItem",
 *     type="object",
 *     title="Service Item",
 *     required={"id", "name"},
 *     properties={
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             format="int64",
 *             description="Unique identifier for the Service Item"
 *         ),
 *         @OA\Property(
 *             property="name",
 *             type="string",
 *             description="Name of the Service Item"
 *         ),
 *         @OA\Property(
 *             property="details_page_name",
 *             type="string",
 *             description="Name of the Service Item for details page"
 *         ),
 *         @OA\Property(
 *             property="description",
 *             type="object",
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="Name of the Service Item Description"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 description="Detailed description of the Service Item"
 *             )
 *         )
 *     }
 * )
 */
class ServiceItem extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public $fillable = [
        'service_id',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function description(): HasOne
    {
        $lang_id = session('current_language_id');
        return $this->hasOne(ServiceItemDescription::class)->where('language_id', $lang_id);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(ServiceItemDescription::class);
    }
}
