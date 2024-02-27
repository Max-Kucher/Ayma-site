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
 *     schema="MenuItem",
 *     type="object",
 *     title="Menu item",
 *     description="A single menu item with optional nested children.",
 *     @OA\Property(
 *         property="link",
 *         type="string",
 *         description="The URL link for the menu item."
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the menu item."
 *     ),
 *     @OA\Property(
 *         property="children",
 *         type="array",
 *         description="Nested children of the menu item.",
 *         @OA\Items(ref="#/components/schemas/MenuItem")
 *     )
 * )
 */
class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'link',
        'parent_id',
        'priority',
    ];

    public function description(): HasOne
    {
        $lang_id = session('current_language_id');
        return $this->hasOne(MenuItemDescription::class)->where('language_id', $lang_id);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(MenuItemDescription::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }
}
