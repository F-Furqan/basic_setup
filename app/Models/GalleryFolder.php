<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryFolder extends Model
{
    protected $guarded = ['id'];
    protected $table = 'gallery_folders';
    protected $fillable =['name'];
}
