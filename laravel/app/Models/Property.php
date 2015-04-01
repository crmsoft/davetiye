<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model {

    public $timestamps = false;

    protected $table = 'T_Property';
    protected $primaryKey = 'PropertyID';
    protected $fillable = [
        'Title',
        'OrderNo',
        'Status'
    ];


    public function subproperty(){
        return $this->hasMany('SubProperty','ID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_Property.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_Property.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_Property.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_Property.Status','=', false );
    }

}
