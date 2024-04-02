<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OpenApi\Attributes\OpenApi as OA;

/**
 * @OA\Schema(
 *     schema="Service",
 *     type="object",
 *     title="Service",
 *     required={"id", "name"},
 *     properties={
 *         @OA\Property(
 *             property="id",
 *             type="integer",
 *             format="int64",
 *             description="Unique identifier for the Service"
 *         ),
 *         @OA\Property(
 *             property="description",
 *             type="object",
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 description="Name of the Service Description"
 *             ),
 *             @OA\Property(
 *                 property="details_page_name",
 *                 type="string",
 *                 description="Name of the Service for details page"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 description="Detailed description of the Service"
 *             )
 *         ),
 *         @OA\Property(
 *             property="service_items",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/ServiceItem"),
 *             description="List of related service items"
 *         )
 *     }
 * )
 */
class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'priority',
    ];

    public function description(): HasOne
    {
        $lang_id = session('current_language_id');
        return $this->hasOne(ServiceDescription::class)->where('language_id', $lang_id);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(ServiceDescription::class);
    }

    public function serviceItems(): HasMany
    {
        return $this->hasMany(ServiceItem::class);
    }
}
