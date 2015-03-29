<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prices extends Model {

    protected $table = 'T_Prices';
    protected $primaryKey = 'PriceID';

    public function product(){
        return $this->hasMany('App\Models\Product','ProductID','PriceID');
    }

    public function quantity(){
        return $this->hasMany('App\Models\Quantity','QuantityID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_Prices.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_Prices.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_Prices.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_Prices.Status','=', false );
    }

}
