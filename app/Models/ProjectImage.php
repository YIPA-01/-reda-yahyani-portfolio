<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'project_id',
        'image_path',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['url'];

    /**
     * Get the project that owns the image.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the full URL for the image.
     */
    public function getUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }
        
        return Storage::disk('public')->url($this->image_path);
    }
} 