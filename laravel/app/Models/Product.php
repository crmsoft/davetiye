<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models;

class Product extends Model {

    protected $table = 'T_Product';
    protected $primaryKey = 'ProductID';
    public $timestamps = false;
    protected $fillable = [
        'Title',
        'OrderNo',
        'SubCategoryID'
    ];
    public function productbyproperty(){
        return $this->belongsTo( 'ProductByProperty', 'ProductID' );
    }

    public function prices(){
        return $this->belongsToMany('App\Models\Prices','T_Product','ProductID','ProductID','T_Prices.ProductID');
    }

    public function subcategory(){
        return $this->belongsTo( 'SubCategory', 'SubCategoryID' );
    }

    public function productgallery(){
        return $this->belongsTo( 'ProductGallery', 'ProductGalleryID' );
    }

    public function scopeGetAll( $query ){
        return $query
            ->join('T_Prices','T_Product.ProductID','=','T_Prices.ProductID')
            ->join('T_ProductByProperty','T_Product.ProductID','=','T_ProductByProperty.ProductID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_Product.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_Product.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_Product.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_Product.Status','=', false );
    }

}
