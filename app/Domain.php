<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 *
 * @mixin Builder
 * @package App
 */
class Domain extends Model
{
    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    public function getTotalLinksAttribute()
    {
        return $this->hasMany('App\Link')->where('domain_id', $this->id)->count();
    }

    public function links()
    {
        return $this->hasMany('App\Link')->where('domain_id', $this->id);
    }

    public function user()
    {
        return $this->belongsTo('App\User')->where('id', $this->user_id)->withTrashed();
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeUserId(Builder $query, $value)
    {
        return $query->where('user_id', '=', $value);
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchGlobal(Builder $query, $value)
    {
        return $query->where('user_id', '=', 0);
    }
}
