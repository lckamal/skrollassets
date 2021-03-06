<?php

namespace App;

use Image;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'floors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'building_id',
        'image',
    ];

    /**
     * save image to folder and name to db
     * @param  AssetRequest $request
     * @return void
     */
    public function saveImage(Request $request)
    {
        if(! $request->file('image')) return null;

        $baseDir = 'images/floors/';
        $fileName = $this->id . '.' . 
            $request->file('image')->getClientOriginalExtension();
        $filepath = $baseDir.$fileName;

        if($request->file('image')->move($baseDir, $fileName))
        {
            Image::make($filepath)
            ->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($filepath);

            $this->update(
                ['image' => '/'.$filepath]
            );
        }
    }

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

        if($building_id = \Request::get('building_id'))
        {
            $query->where('building_id', '=', "{$building_id}");
        }

        return $query;
    }

    /**
     * Floor belongs to a building
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building()
    {
        return $this->belongsTo('App\Building');
    }

    /**
     * Floor has many assets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function assets()
    {
        return $this->hasMany('App\Asset');
    }
}
