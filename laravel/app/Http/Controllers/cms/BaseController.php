<?php namespace App\Http\Controllers\cms;
/**
 * Created by PhpStorm.
 * User: ahtem
 * Date: 01.03.2015
 * Time: 14:54
 */
use App\Models\ProductByProperty;
use App\Models\SubProperty;
use Session;

use App\Models\Product;
use App\Models\Property;
use App\Models\Quantity;
use App\Models\SubCategory;

use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Utils\Utills;

class BaseController extends Controller{

    public function __construct(){
        DB::connection()->enableQueryLog();
        $this->middleware('auth');
    }

    public function getCmsIndex(){
        return view('cms.dashboard');
    }

    public function getListProducts( $sb = null ){

        Session::put('title','Ürünler Listesi');
        try {
            if($sb){
                $u = new Utills();
                $all_products = Product::join('T_SubCategory', 'T_Product.SubCategoryID', '=', 'T_SubCategory.SubCategoryID')
                    ->leftJoin('T_ProductGallery', 'T_Product.ProductID', '=', 'T_ProductGallery.ProductID')
                    ->where('T_SubCategory.Title', $u->removeSlahes( $sb ) )
                    ->ODate()
                    ->groupBy('T_Product.ProductID')
                    ->get( array('T_Product.*', 'T_ProductGallery.imageName as img', 'T_SubCategory.Title as subcategory') );
            }else {
                $all_products = Product::join('T_SubCategory', 'T_Product.SubCategoryID', '=', 'T_SubCategory.SubCategoryID')
                    ->leftJoin('T_ProductGallery', 'T_Product.ProductID', '=', 'T_ProductGallery.ProductID')
                    ->ODate()
                    ->groupBy('T_Product.ProductID')
                    ->get(array('T_Product.*', 'T_ProductGallery.imageName as img', 'T_SubCategory.Title as subcategory'));
            }
        }catch (Exception $e){
            dd($e);
        }
        return view('cms.productList', array(
            'products' => $all_products
        ));
    }

    public function getAddProductStep2(){

        Session::put('stage', 'Ürün için property seçin');
        Session::put('addForm', 'Yeni adet ekleyin');
        Session::put('title','Yeni ürün - step 2');

        $props = SubProperty::leftJoin('T_Property','T_SubProperty.PropertyID','=','T_Property.PropertyID')
                    ->orderBy('T_Property.PropertyID','desc')
            ->get(['T_Property.PropertyID', 'T_Property.Title as prop', 'T_SubProperty.SubPropertyID', 'T_SubProperty.Title as subprop'])
        ->toArray();

        $exist_props = ProductByProperty::where('ProductID','=',Session::get('Product')->ProductID)
                ->get()
            ->toArray();

       /* foreach($props as $key=>$val){
            $vart = var_dump(array_where($exist_props, function($C,$v) use ($val){ return ($v['QuantityID'] == 11) && $val['SubPropertyID'] == $v['SubPropertyID']; }));
            echo $vart;
        }die();*/

        return view('cms.addProduct.step2',['properties'=>$props,'exist_props'=>$exist_props]);
    }

    public function getAddProductStep1(){

        Session::put('stage', 'Ürün için adet seçin');
        Session::put('addForm', 'Yeni adet ekleyin');
        Session::put('title','Yeni ürün - step 1');

        $qunas = Quantity::orderBy('Title')->get();

        return view('cms.addProduct.step1',['q'=>$qunas]);

    }

    public function getAddProduct(){

        Session::put('stage', 'Bir ürün seçin ve ya yeni kleyin');
        Session::put('addForm', 'Yeni ürün ekleyin');
        Session::put('title','Yeni ürün ekleme');

        $product_list = Product::join('T_SubCategory', 'T_Product.SubCategoryID', '=', 'T_SubCategory.SubCategoryID')
                        ->orderBy('subcategory')
                        ->get(array('T_Product.*','T_SubCategory.Title as subcategory') );

        $subcategories = SubCategory::all();

            return view('cms.addProduct.productAdd', [
                'productList' => $product_list,
                'sbcats' => $subcategories
            ]);
    }

}