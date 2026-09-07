<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataCentre extends Model
{
    protected $fillable = [
        'name', 'location', 'country', 'address', 'latitude', 'longitude',
        'short_description', 'full_description', 'hero_image', 'hero_video_url',
        'meta_title', 'meta_description', 'og_image',
        'cta_heading', 'cta_description', 'cta_button_text', 'cta_button_url',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(DataCentreSpecification::class)->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(DataCentreFeature::class)->orderBy('sort_order');
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(DataCentreGallery::class)->orderBy('sort_order');
    }

    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
