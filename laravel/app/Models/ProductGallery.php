<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model {

    protected $table = 'T_ProductGallery';
    protected $primaryKey = 'ProductGalleryID';

    public function product()
    {
        return $this->hasOne( 'Product', 'ProductID' );
    }

    public function subproperty()
    {
        return $this->hasMany( 'SubProperty', 'ID' );
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_ProductGallery.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_ProductGallery.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_ProductGallery.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_ProductGallery.Status','=', false );
    }


}
