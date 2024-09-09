<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebSettings extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'web_settings';

    protected $guarded = [''];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brosur')->singleFile();
        $this->addMediaCollection('rincian_biaya')->singleFile();
    }
}
