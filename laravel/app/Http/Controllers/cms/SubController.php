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

        $props = Property::all();

        return view('cms.propertyList',[
            'properties'=>$props
        ]);

    }

}