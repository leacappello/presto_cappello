<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public static function getUrlByFilePath(
        string $filePath,
        ?int $w = null,
        ?int $h = null
    ): string {
        // Se non vengono richieste dimensioni specifiche,
        // restituisce direttamente l'immagine originale.
        if (!$w || !$h) {
            return Storage::disk('public')->url($filePath);
        }

        $path = dirname($filePath);
        $fileName = basename($filePath);

        $croppedFile = "{$path}/crop_{$w}x{$h}_{$fileName}";

        // Usa il crop quando esiste.
        if (Storage::disk('public')->exists($croppedFile)) {
            return Storage::disk('public')->url($croppedFile);
        }

        // Fallback per le immagini caricate prima della User Story 6.
        return Storage::disk('public')->url($filePath);
    }

    public function getUrl(
        ?int $w = null,
        ?int $h = null
    ): string {
        return self::getUrlByFilePath(
            $this->path,
            $w,
            $h
        );
    }
}
