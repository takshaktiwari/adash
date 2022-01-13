<?php

namespace Takshak\Adash\Traits\Models;

trait CommonModelTrait {

	public function image_sm()
	{
		return $this->image_sm 
		? $this->storageUrl($this->image_sm) 
		: $this->placeholderImage();
	}
	public function image_md()
	{
		return $this->image_md 
		? $this->storageUrl($this->image_md) 
		: $this->placeholderImage();
	}
	public function image_lg()
	{
		return $this->image_lg 
		? $this->storageUrl($this->image_lg) 
		: $this->placeholderImage();
	}

	public function storageUrl($nextPath)
	{
		return url('storage/app/'.$nextPath);
	}
	public function placeholderImage($value=''): string
	{
		return asset('images/placeholder-image.png');
	}
}