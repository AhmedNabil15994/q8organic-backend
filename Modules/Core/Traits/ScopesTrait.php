<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\ResponseCache\Facades\ResponseCache;

trait ScopesTrait
{
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeAnyTranslation($query,$column,$slug)
    {
        return $query->where(function ($query) use ($slug,$column) {
            foreach (config('translatable.locales') as $code) {
                $query->orWhere("{$column}->$code", $slug);
            }
        });
    }

    public function scopeUnActive($query)
    {
        return $query->where('status', false);
    }

    public function scopeIsTrused($query)
    {
        return $query->where('is_trusted', true);
    }

    public function scopeOnlyDeleted($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeWithDeleted($query)
    {
        return $query->withTrashed();
    }

    public function scopeMainCategories($query)
    {
        return $query->whereNull('category_id');
    }

    public function scopeUnexpired($query)
    {
        return $query->whereDate('end_at', '>', date('Y-m-d'));
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('end_at', '<', date('Y-m-d'));
    }

    public function scopeStarted($query)
    {
        return $query->whereDate('start_at', '<=', date('Y-m-d'));
    }

    public function scopeSuccessOrderStatus($query)
    {
        return $query->where('is_success', 1);
//        return $query->where('success_status', 1);
    }

    public function scopeFailedOrderStatus($query)
    {
        return $query->where('is_success', 0);
//        return $query->where('failed_status', 1);
    }

    public function scopeApproved($query)
    {
        return $query->where('pending_for_approval', true);
    }

    public function scopeNotApproved($query)
    {
        return $query->where('pending_for_approval', false);
    }

    public function scopeOrderByTranslationOrModel(Builder $query, string $column, string $sortMethod = 'asc')
    {
        if ((new static)->isTranslationAttribute($column)) {
            $query->orderByTranslation($column, $sortMethod);
        } else {
            $query->orderBy($column, $sortMethod);
        }
    }

    public function scopeWhereTranslation($query, $translationField, $value, $locale = null, $operator = 'like')
    {
        
        $translationField =is_null($locale) ? $translationField  : "{$translationField}->{$locale}";
        $value = $operator === "like" ? "%$value%" : $value;
        
        $query->where($translationField, $operator, $value);
    }
}
