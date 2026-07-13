<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Image;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $w;
    private $h;
    private $fileName;
    private $path;

    public function __construct($filePath, $w, $h)
    {
        $this->path = dirname($filePath);
        $this->fileName = basename($filePath);
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $w = $this->w;
        $h = $this->h;

        $srcPath = storage_path()
            . '/app/public/'
            . $this->path
            . '/'
            . $this->fileName;

        $destPath = storage_path()
            . '/app/public/'
            . $this->path
            . "/crop_{$w}x{$h}_"
            . $this->fileName;

        Image::load($srcPath)
            ->crop($w, $h, CropPosition::Center)
            ->save($destPath);
    }
}