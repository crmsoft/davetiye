<?php namespace App\Http\Controllers\web;
/**
 * Created by PhpStorm.
 * User: ahtem
 * Date: 01.03.2015
 * Time: 14:54
 */
use App\Http\Controllers\Controller;
use App\Models\Quantity;
use Illuminate\Support\Facades\DB;
use App\Models\ProductGallery;
use App\Models\Utils\Utills;
use App\Models\SubCategory;
use App\Models\Product;
use \Session;
use App\User;


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
            $prod = Product::leftJoin( 'T_ProductGallery', function($j){
                $j->on('T_ProductGallery.ProductID', '=', 'T_Product.ProductID');
                $j->on('T_ProductGallery.Status', '=', DB::raw('1'));
            })
                ->where('SubCategoryID', '=', $sbc[0]->SubCategoryID)
                ->ODate()->Active()->groupBy('T_Product.ProductID')->get(['T_Product.*','T_ProductGallery.ImageName']);

            if(!$prod->count()){
                Session::flash('warning','<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
            }
        }$cats = SubCategory::Ordered()->Active()->get();

        return view('web.subcategory-products')->with( [ 'categories'=>$cats, 'products'=>$prod ] );
    }

    public function getProductById( $sb, $id ){

        Session::put('subcategory', $sb);

        $u = new Utills();
        $sb = $u->removeSlahes($sb);

        Session::put('id', $id);
        $sb = SubCategory::where('Title','=',$sb)->get();

        if( $sb->count() ) {
            $dt = Product::where('ProductID', '=', $id)->where('SubCategoryID', '=', $sb[0]->SubCategoryID)->get();
            if ($dt->count()) {
                $dt = $dt[0]->ProductID;
                $results = $u->getProductById($dt);

                if (!$results) {
                    Session::flash('warning', '<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
                    $results = [];
                }
                $min_q = $u->getMinQuantity();
                $start_index = $u->getStartIndex();
            } else {
                Session::flash('warning', '<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
                $results = [];
                $min_q = 0;
                $start_index = -1;
            }
        }else{
            Session::flash('warning', '<h3 class="mt_35 mr_35">Ürün Bulunamadı!!!</h3>');
            $results = [];
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

    public function getShoppingBox(){

        $properties = SubCategory::all();

        if( !Session::has('res') ){
            return redirect('/urunler');
        }
        $bucket = Session::get('res');

         $prs = $props = $prices = $quantity = $tmp['ao'] = $tmp['oz'] = [];$curr = '';
        foreach($bucket as $key=>$stages){
            foreach($stages as $k=>$stage) {
                if ($stage->ua != $curr) {
                    $prs[] = $curr = $stage->ua;
                    $prices[$key] = $stage->bf;
                    $props['ao'][] = $tmp['ao'];
                    $props['oz'][] = $tmp['oz'];
                    $quantity['q'][] = Quantity::join('T_Prices','T_Prices.QuantityID','=','T_Quantity.QuantityID')
                                    ->where('T_Prices.ProductID','=',$stage->id)
                                    ->get(['T_Quantity.QuantityID','T_Quantity.Title'])->toArray();
                    $quantity['s'][] = $stage->adet;
                    $tmp = [];
                }
                $tmp['ao'][] = $stage->ao;
                $tmp['oz'][] = $stage->oz;
                $prices[$key] += $stage->il;
            }
            $curr = '';
            if(!empty($tmp['ao'])){
                $props['ao'][] = $tmp['ao'];
                $props['oz'][] = $tmp['oz'];
            }
        }

        return view('web.checkOut.step1')->with([
            'categories'=>$properties,
            'products' => $prs,
            'properties'=>$props,
            'prices'=>$prices,
            'quantity'=>$quantity
        ]);
    }

    public function getClientRegister(){
        return view('auth.client');
    }

    public function getActivate(){
        return view('auth.clientActivate');
    }

    public function getClientActivate( $code ){
        $to = User::where('code',$code)->first();

        if($to){
            $to->code = '';
            $to->active = 1;
            if($to->save()){
                return 'Activasyon işlemi başarıyla tamalandı';
            }
        }

        return 'Bir hata oluştu daha sonra tekrar deneyin';
    }

    public function getLogout()
    {
        $this->auth->logout();
        return redirect('/');
    }
}