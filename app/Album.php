<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = "albums";
    protected $primaryKey = "AlbumId";
    public $timestamps = false;

    //extender modelo: Album tiene muchas canciones
    public function canciones(){
        return $this->hasMany('App\Canción', 'AlbumtId');
    }
}
