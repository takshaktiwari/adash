<?php

namespace Takshak\Adash\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait CommonModelTrait
{
    public function image_sm()
    {
        return $this->image_sm
            ? $this->assetUrl($this->image_sm)
            : $this->placeholderImage();
    }
    public function image_md()
    {
        return $this->image_md
            ? $this->assetUrl($this->image_md)
            : $this->placeholderImage();
    }
    public function image_lg()
    {
        return $this->image_lg
            ? $this->assetUrl($this->image_lg)
            : $this->placeholderImage();
    }

    public function assetUrl($nextPath)
    {
        return storage($nextPath);
    }

    public function placeholderImage($value = ''): string
    {
        return asset('assets/admin/images/placeholder-image.png');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('featured', true);
    }
}
