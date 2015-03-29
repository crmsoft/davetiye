<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'T_Category';
    protected $primaryKey = 'CategoryID';

    public function subcategory(){
        return $this->hasMany('SubCategory','CategoryID');
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_Category.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_Category.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_Category.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_Category.Status','=', false );
    }

}
