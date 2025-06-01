<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'technologies',
        'is_visible',
        'main_image_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'technologies' => 'array',
        'is_visible' => 'boolean',
    ];

    /**
     * Get all images for the project.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    /**
     * Get the main image for the project.
     */
    public function mainImage(): BelongsTo
    {
        return $this->belongsTo(ProjectImage::class, 'main_image_id');
    }

    /**
     * Get the first image as fallback if no main image is set.
     */
    public function getFirstImageAttribute()
    {
        return $this->mainImage ?: $this->images->first();
    }
} 