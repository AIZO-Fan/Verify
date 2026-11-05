<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'category',
        'image',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Boot the model and register event listeners.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Module $module): void {
            if (empty($module->slug)) {
                $module->slug = Str::slug($module->title);
            }
        });
    }

    /**
     * Scope a query to only include published modules.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the full image URL or a placeholder URL.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/module-placeholder.png');
    }
}
