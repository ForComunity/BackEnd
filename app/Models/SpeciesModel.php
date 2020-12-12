<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeciesModel extends Model
{
    protected $table = "species";
    protected $guarded  =   [''];
    protected $fillable = [
        'id',
        'name',
        'slug',
        'spe_cat_id',
        'cat_id',
        'user_id',
        'image1',
        'image2',
        'image3',
        'description',
        'description_seo',
        'title',
        'title_seo',
        'content1',
        'content2',
        'content3',
        'status',
        'created_at',
        'updated_at'
    ];
}
