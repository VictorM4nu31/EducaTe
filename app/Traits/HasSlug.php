<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait.
     * 
     * Automatically generates slug on model creation and updates.
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            // Only regenerate slug if the source field changed
            if ($model->isDirty($model->getSlugSourceField())) {
                $model->generateSlug();
            }
        });
    }

    /**
     * Generate a unique slug for the model.
     * 
     * @return void
     */
    public function generateSlug(): void
    {
        $sourceField = $this->getSlugSourceField();
        $baseSlug = Str::slug($this->{$sourceField});
        
        $slug = $baseSlug;
        $count = 1;
        
        // Check for uniqueness
        while ($this->slugExists($slug)) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }
        
        $this->slug = $slug;
    }

    /**
     * Check if a slug already exists in the database.
     * 
     * @param string $slug
     * @return bool
     */
    protected function slugExists(string $slug): bool
    {
        $query = static::where('slug', $slug);

        // For models with exam_id relationship (Questions)
        if ($this->hasAttribute('exam_id') && $this->exam_id) {
            $query->where('exam_id', $this->exam_id);
        }

        // Exclude current model if updating
        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    /**
     * Get the field name to use for slug generation.
     * 
     * Override in model if using a different field.
     * 
     * @return string
     */
    public function getSlugSourceField(): string
    {
        return property_exists($this, 'slugSourceField') 
            ? $this->slugSourceField 
            : 'title';
    }

    /**
     * Get the slug route key name.
     * 
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
