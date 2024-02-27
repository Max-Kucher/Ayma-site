<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
