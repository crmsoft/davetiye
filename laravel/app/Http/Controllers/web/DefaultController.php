<?php namespace App\Http\Controllers\web;
/**
 * Created by PhpStorm.
 * User: ahtem
 * Date: 01.03.2015
 * Time: 14:54
 */
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use App\Models\SubCategory;
use App\Models\Utils\Utills;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use Session;


class DefaultController extends Controller{

    public function getIndex(){
        return view('web.index');
    }


    public function getListProperty(){

        $props = SubCategory::all();

        return view('web.subcategory')->with([
            'categories'=>$props
        ]);

    }

    public function getProductsOfSubcategory( $subcategory )
    {
        $u = new Utills();

        Session::put('subcategory', $subcategory);

        $sb = $u->removeSlahes( $subcategory );
        $sbc = SubCategory::where('Title','=', $sb)->get();

        if(!$sbc->count()){
            Session::flash('warning','<h3 class="mt_35 mr_35">Subcategory bulunamadı!!!</h3>');
            $prod=[];
        }else {
            $prod = Product::join( 'T_ProductGallery','T_ProductGallery.ProductID', '=', 'T_Product.ProductID' )
                ->where('SubCategoryID', '=', $sbc[0]->SubCategoryID)
                ->ODate()->Active()->groupBy('T_ProductGallery.ProductID')->get();

            if(!$prod->count()){
                Session::flash('warning','<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
            }
        }

        $cats = SubCategory::Ordered()->Active()->get();

        return view('web.subcategory-products')->with( [ 'categories'=>$cats, 'products'=>$prod ] );
    }

    public function getProductById( $sb, $id ){

        Session::put('subcategory', $sb);

        $u = new Utills();
        $sb = $u->removeSlahes($sb);

        Session::put('id', $id);

        $sb = SubCategory::where('Title','=',$sb)->get();

            $dt = Product::where('ProductID','=',$id)->get();

            if( $dt->count() ) {
                $dt = $dt[0]->ProductID;
                $results = $u->getProductById($dt);

                if( !$results ){
                    Session::flash('warning','<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
                    $results = [];
                }
                $min_q = $u->getMinQuantity();
                $start_index = $u->getStartIndex();
            }else{
                Session::flash('warning','<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
                $results = []; $min_q = 0; $start_index = -1;
            }

        $cats = SubCategory::Ordered()->Active()->get();

        $gallery = ProductGallery::where('ProductID','=',$id)->Ordered()->Active()->get()->toArray();

        return view('web.product-detailed')->with( [
            'categories'=>$cats,
            'minQ'=>$min_q,
            'st_index'=>$start_index,
            'products'=>$results,
            'subcat' => $sb,
            'gallery' => $gallery
        ]);
    }

    public function postProductDetails(){

        $id = Session::get('id');

        $u = new Utills();
        $results = $u->getProductById($id);

        return response()->json($results);
    }
}