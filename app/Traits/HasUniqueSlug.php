<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUniqueSlug
{
    /**
     * Boot the HasUniqueSlug trait for a model.
     *
     * @return void
     */
    public static function bootHasUniqueSlug()
    {
        static::creating(function (Model $model) {
            $model->slug = static::generateUniqueSlug($model, $model->slugSource ?? 'name');
        });

        static::updating(function (Model $model) {
            $model->slug = static::generateUniqueSlug($model, $model->slugSource ?? 'name', $model->getKey());
        });
    }

    /**
     * Get the column name to use for slug generation.
     *
     * @return string
     */
    public function getSlugSourceColumn(): string
    {
        return $this->slugSource ?? 'name';
    }

    /**
     * Generate a unique slug for the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $sourceColumn
     * @param  mixed  $excludeId
     * @return string
     */
    protected static function generateUniqueSlug(Model $model, string $sourceColumn, $excludeId = null): string
    {
        $slug = Str::slug($model->{$sourceColumn});
        $originalSlug = $slug;
        $count = 2;

        while ($model::where('slug', $slug)
            ->when($excludeId, function ($query) use ($excludeId, $model) {
                return $query->where($model->getKeyName(), '!=', $excludeId);
            })
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
