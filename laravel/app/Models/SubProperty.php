<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProperty extends Model {

    protected $table = 'T_SubProperty';
    protected $primaryKey = 'SubPropertyID';
    protected $fillable = [
        'Status',
        'OrderNo',
        'PropertyID',
        'Title',
        'updated_at',
        'created_at',
        'EkPoperty'
    ];

    public function property(){
        return $this->belongsTo( 'Property','PropertyID' );
    }

    public function productbyproperty(){
        return $this->belongsTo( 'ProductByProperty', 'SubPropertyID' );
    }

    public static function scopeOrdered( $query )
    {
        return $query->orderBy('T_SubProperty.OrderNo');
    }

    public static function scopeODate( $query )
    {
        return $query->orderBy('T_SubProperty.CreateDate');
    }

    public static function scopeActive( $query )
    {
        return $query->where('T_SubProperty.Status','=', true );
    }

    public static function scopePassive( $query )
    {
        return $query->where('T_SubProperty.Status','=', false );
    }

}
