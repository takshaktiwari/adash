<?php

namespace Takshak\Adash\Traits;

use Image;
use Exception;

trait ImageTrait {

    public $img;
    public $width;
    public $height;
    public $storedImg;
    public $ext = 'jpg';

    public function initImg($imgPath='')
    {
        $this->img = Image::make($imgPath);
        return $this;
    }

    public function resizeW($width)
    {
        $this->img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        return $this;
    }

    public function resizeH($height)
    {
        $this->img->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $this;
    }

    public function resizeBoth($width, $height)
    {
        $this->img->resize($width, $height);
        return $this;
    }

    public function resizeFit($width, $height)
    {
        $this->width = $width;
        $this->height = $height;

        $this->resizeW($width);
        if ($this->img->height() > $height) {
            $this->resizeH($height);
        }
        return $this;
    }

    public function inCanvas($bg=null)
    {
        $this->img = Image::canvas($this->width, $this->height, $bg)
                            ->insert($this->img, 'center');

        return $this;
    }

    public function extension($ext='')
    {
        $this->ext = $ext;
        return $this;
    }

    public function storeImg($path)
    {
        $this->checkDirectory($path);
        $this->img->save(storage_path('app/'.$path), 80, $this->ext);
        return $this;
    }

    public function makeCopy($path, $width=null, $height=null)
    {
        if ($width && $height) {
            $this->resizeBoth($width, $height);

        }elseif ($width) {
            $this->resizeW($width);

        }elseif ($height) {
            $this->resizeH($height);
        }

        $this->checkDirectory($path);
        $this->img->save(storage_path('app/'.$path), 80, $this->ext);
        return $this;
    }

    public function checkDirectory($path)
    {
        if (!is_dir($path)) {
            $directory = \Str::of($path)->beforeLast('/');
            \Storage::makeDirectory($directory);
        }
    }

    public function response()
    {
        return $this->img->response();
    }


}