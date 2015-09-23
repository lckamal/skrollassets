<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','latitude','longitude'];

    /**
     * scope query with filter options
     * @param  query $query
     * @return Query
     */
    public static function scopeFilter($query)
    {
        if($name = \Request::get('q'))
        {
            $query->where('name', 'like', "%{$name}%");
        }

        return $query;
    }

    /**
     * Department has many floors
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function floors()
    {
        return $this->hasMany('App\Floor');
    }

    /**
     * Department has many assets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets()
    {
        return $this->hasMany('App\Asset');
    }
}
