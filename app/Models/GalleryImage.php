<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $table = 'gallery_images';
    protected $guarded = ['id'];
    protected $appends = ['image_url'];
    // public $timestamps = false;

    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';

    public function getImageUrlAttribute(){
        return asset('storage/'.$this->source);
    }
}
