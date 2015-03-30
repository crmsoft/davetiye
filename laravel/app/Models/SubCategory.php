<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {

    protected $table = 'T_SubCategory';
    protected $primaryKey = 'SubCategoryID';

    public function category(){
        return $this->belongsTo('Category', 'CategoryID');
    }

    public function productbyproperty(){
        return $this->belongsTo('ProductByProperty','SubPropertyID');
    }

    public function product(){
        return $this->hasMany('Product','ProductID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_SubCategory.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy( 'T_SubCategory.CreateDate' );
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_SubCategory.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_SubCategory.Status','=', false );
    }

}
