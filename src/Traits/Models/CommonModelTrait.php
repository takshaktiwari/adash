<?php

namespace Takshak\Adash\Traits\Models;

trait CommonModelTrait {

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
		return asset('storage/'.$nextPath);
	}
	public function placeholderImage($value=''): string
	{
		return asset('assets/admin/images/placeholder-image.png');
	}
}