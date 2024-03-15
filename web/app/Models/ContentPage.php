<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ContentPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'route',
    ];

    public function description(): HasOne
    {
        $lang_id = session('current_language_id');
        return $this->hasOne(ContentPageDescription::class)->where('language_id', $lang_id);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(ContentPageDescription::class);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return ContentPage|null
     */
    public function resolveRouteBinding($value, $field = null): ContentPage|null
    {
        return $this->where('route', $value)->firstOrFail();
    }
}
