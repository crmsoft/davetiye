<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quantity extends Model {

    public $timestamps = false;

    protected $table = 'T_Quantity';
    protected $primaryKey = 'QuantityID';

    protected $fillable = [
        'Title',
        'OrderNo'
    ];

    public function prices(){
        return $this->belongsTo('Prices','QuantityID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_Quantity.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_Quantity.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_Quantity.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_Quantity.Status','=', false );
    }

}
