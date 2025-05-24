<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

use Spatie\Translatable\HasTranslations;
class OrderStatus extends Model 
{
    use HasTranslations, ScopesTrait;

	 protected $fillable 					= ["flag","color_label","is_success","code","color","title"];
    public $translatable = ['title'];

    public function orderStatusesHistory()
    {
        return $this->belongsToMany(Order::class, 'order_statuses_history')->withPivot(['user_id'])->withTimestamps();
    }
}
