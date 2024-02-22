<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoSettingDescription extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function seoSetting(): BelongsTo
    {
        return $this->belongsTo(SeoSetting::class);
    }

    /**
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
