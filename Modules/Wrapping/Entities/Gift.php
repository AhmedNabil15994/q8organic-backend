<?php

namespace Modules\Wrapping\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;

class Gift extends Model
{
    use HasSlugTranslation ;
    use HasTranslations, SoftDeletes, ScopesTrait;

    protected $with = [];

    protected $fillable 					= ["image","price","sku","qty","status","size","title"];
       
    protected $casts = [
        "size" => "array"
    ];

    public $translatable = [
        'title',"slug"
    ];
}
