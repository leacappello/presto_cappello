<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;
use Spatie\Image\Enums\AlignPosition;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $w;
    private int $h;
    private string $fileName;
    private string $path;

    public function __construct(
        string $filePath,
        int $w,
        int $h
    ) {
        $this->path = dirname($filePath);
        $this->fileName = basename($filePath);
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $srcPath = storage_path(
            'app/public/'
            . $this->path
            . '/'
            . $this->fileName
        );

        $destPath = storage_path(
            'app/public/'
            . $this->path
            . "/crop_{$this->w}x{$this->h}_"
            . $this->fileName
        );

        $watermarkPath = resource_path(
            'img/watermark.png'
        );

        if (!file_exists($srcPath)) {
            throw new RuntimeException(
                "Immagine sorgente non trovata: {$srcPath}"
            );
        }

        if (!file_exists($watermarkPath)) {
            throw new RuntimeException(
                "Watermark non trovato: {$watermarkPath}"
            );
        }

        Image::load($srcPath)
            ->crop(
                $this->w,
                $this->h,
                CropPosition::Center
            )
         ->watermark(
             base_path('resources/img/watermark.png'),
             width: 70,
             height: 70,
             paddingX: 10,
             paddingY: 10,
             paddingUnit: Unit::Pixel
            )
            ->save($destPath);
    }
}