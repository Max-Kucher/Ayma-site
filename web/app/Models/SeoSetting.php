<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoSetting extends Model
{
    use HasFactory;

    public function descriptions(): HasMany
    {
        return $this->hasMany(SeoSettingDescription::class);
    }

    public function getDescriptionAttribute(): Model
    {
        $locale = app()->getLocale();

        $relation = $this->descriptions();
        return $relation->where('locale', $locale)->first();
    }
}
