<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductByProperty extends Model {

    protected $table = 'T_ProductByProperty';
    protected $primaryKey = 'ID';

    public function product(){
        return $this->hasOne('Product','ProductID');
    }

    public function subproperty(){
        return $this->hasOne('SubProperty','SubPropertyID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_ProductByProperty.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_ProductByProperty.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_ProductByProperty.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_ProductByProperty.Status','=', false );
    }

}
