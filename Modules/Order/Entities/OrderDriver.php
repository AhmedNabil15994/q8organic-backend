<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderDriver extends Model
{
    protected $fillable = ['order_id','user_id','accepted','delivered'];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class);
    }
}
