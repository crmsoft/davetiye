<?php namespace App\Http\Controllers\cms;
/**
 * Created by PhpStorm.
 * User: ahtem
 * Date: 30.03.2015
 * Time: 16:21
 */

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use App\Models\SubProperty;
use App\Models\Utils\Utills;
use Illuminate\Support\Facades\DB;
use App\Models\SubCategory;
use Session;
class SubController extends Controller{

    public function getSubCategoryList(){

        Session::put('title','Alt Kategori Datayları');

         $cats = Category::Active()->get();

        $subs = SubCategory::leftJoin('T_Product', 'T_SubCategory.SubCategoryID','=','T_Product.SubCategoryID')
                            ->groupBy('T_SubCategory.SubCategoryID')
                            ->orderBy('T_SubCategory.OrderNo')
                            ->get(['T_SubCategory.*',DB::raw('count(T_Product.ProductID) as total_products')]);

        return view('cms.subCategoryList',[
            'subcategories' => $subs,
            'categories' => $cats
        ]);

    }

    public function getPropertyList(){

        Session::put('title','Özellikler');

        $props = Property::Ordered()->get();

        return view('cms.propertyList',[
            'properties'=>$props
        ]);

    }

    public function getSubPropertyList( $pr = null ){

        Session::put('title', 'Alt Özellikler');

        if(!$pr) {

            $sb = SubProperty::leftJoin('T_Property', 'T_Property.PropertyID', '=', 'T_SubProperty.PropertyID')
                ->Ordered()
                ->get(['T_SubProperty.*', 'T_Property.Title as property']);
        }else{
            $u = new Utills();

            $pr = Property::where('Title','=',$u->removeSlahes($pr))->get(['PropertyID']);

            if($pr->count() == 0){
                $pr = 0;
            }else{
                $pr = $pr[0]->PropertyID;
            }
            $sb = SubProperty::leftJoin('T_Property', 'T_Property.PropertyID','=','T_SubProperty.PropertyID')
                ->where('T_Property.PropertyID','=',$pr)
                ->Ordered()
                ->get(['T_SubProperty.*','T_Property.Title as property']);
        }
            $props = Property::Ordered()->get();

        return view('cms.subPropertyList',[
            'subproperties' => $sb,
            'properties' => $props
        ]);
    }
}