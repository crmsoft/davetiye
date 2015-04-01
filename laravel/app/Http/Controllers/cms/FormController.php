<?php
/**
 * Created by PhpStorm.
 * User: ahtem
 * Date: 03.03.2015
 * Time: 21:16
 */

namespace App\Http\Controllers\cms;


use App\Models\Prices;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Utils\Map;
use Illuminate\Database\QueryException;
use App\Models\ProductByProperty;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\SubCategory;
use Intervention\Image\ImageManagerStatic as Image;

class FormController extends Controller{
/*
 *
        $_errors = '';



        if(env('APP_DEBUG')){
            Session::put('flow_error', $_errors );
        }
 *
 */
    public function postInsertInTable(){

        $_errors = [];

        if( Input::has('table_to_insert') ){

            $map = new Map();

            $model = $map->getModel( Input::get('table_to_insert') );

            if(Input::has('ID')){
                $model::find( Input::get('ID') )->update(Input::except(['table_to_insert','_token','ID']));
            }else{
                $model::create( Input::all() );
            }

        }else{
            $_errors[] = 'Table To insert is not specified.';
        }

        if(env('APP_DEBUG') && $_errors){
            Session::put('flow_error', join('<br />', $_errors ) );
        }

        return Redirect::back();
    }

    public function postUpdateColumns(){

        if( Input::has('table_to_insert') && Input::has('row_id') ){
            $map = new Map();

            $model = $map->getModel( Input::get('table_to_insert') );

            $obj = $model->find( Input::get('row_id') );

            if($obj){
                $fields = Input::except([ 'table_to_insert','row_id' ]);
                foreach( $fields as $key=>$val ){
                    if(isset($obj[$key])){
                        $obj[$key] = $val;
                    }
                }
                if($obj->save()){
                    return json_encode("{status:'key-200'}");
                }
            }else{
                return json_encode("{status:'key-404'}");
            }
        }else{
            return json_encode("{status:'fail'}");
        }
    }

    public function postCheckInStage1(){

        if(!Input::has('product_id')){
            Session::put('flow_error', "Product data not posted !");
            return Redirect::back();
        }

        if($product = Product::find(Input::get('product_id'))){

            $props = Prices::where('ProductID','=',$product->ProductID)->get()->toArray();

            $q_ids = array_fetch($props,'QuantityID');

            Session::put('ProductQuantityID',$q_ids);

            Session::put('ProductQuantity',$props);

            Session::put('Product',$product);

        }else{
            Session::put('flow_error', "Product data not found !");
            return Redirect::back();
        }

        return redirect('cms/product/add/step/1');
    }

    public function postCheckInStage2(){

        if(!Input::has('qunatitiesIds') && Input::has('quantitiesPrices')){
            Session::put('flow_error', "Lütfen en az bir adet seçin !");
            return Redirect::back();
        }

        if(!Input::has('qunatitiesIds') && !Input::has('quantitiesPrices')){
            Session::put('flow_error', "Data not posted !");
            return Redirect::back();
        }

        Session::put('PricesByQuantities',Input::get('quantitiesPrices'));

        Session::put('UserInsertQuantity',Quantity::whereIn('QuantityID',Input::get('qunatitiesIds'))->get()->toArray());

        Session::put('Quantity',Input::get('quantity_id'));

        return redirect('cms/product/add/step/2');
    }

    public function postCheckInStage3(){

        $pr_id = intval(Session::get('Product')->ProductID);
        $props = Input::get('properties');
        $quantities_price = Session::get('PricesByQuantities');
        $sb_prop = Input::get('subproperties');
        $noop = false;

        $prices = []; $pr_by_prop = [];
        foreach ($props as $key=>$value) {
            $q_def_price = doubleval($quantities_price[$key][0]);

            $tmp = [];
            $tmp['ProductID'] = $pr_id;
            $tmp['QuantityID'] = $key;
            $tmp['DefaultPrice'] = $q_def_price;
            $tmp['Status'] = 1;
            $prices[$key] =  $tmp;

            if(!isset($props[$key])){$noop = true; break;}

            foreach($props[$key] as $prop){
                if(!isset($sb_prop[$key])){$noop = true; break;}
                    $tmp = $sb_prop[$key];
                        if(!isset($tmp[$prop])){ $noop = true; break; }
                            foreach( $tmp[$prop] as $id=>$sb ){
                                if( $sb != '' ){

                                    $tmp = [];
                                    $tmp['ProductID'] = $pr_id;
                                    $tmp['SubPropertyID'] = $id;
                                    $tmp['QuantityID'] = $key;
                                    $tmp['OrderNo'] = 1;
                                    $tmp['Status'] = 1;
                                    $tmp['ExPrice'] = doubleval($sb);
                                    $pr_by_prop[$key][] = $tmp;
                                }
                            }
            }
        }


        if(!$noop) {

            DB::beginTransaction();

            $kluchi = array_keys($prices);

            if( !empty($kluchi) ){
                $this->clearInsetTables( $prices[$kluchi[0]]['ProductID'] );
            }

            foreach( $prices as $key=>$price ){
                try{
                    DB::table('T_Prices')->insert($prices[$key]);
                    if( ! ($b = $this->insertSubProperty( $pr_by_prop[$key] )) ){
                        $noop = $b; break;
                    }
                }catch( QueryException $exception ){
                    $noop = $exception->getCode(); break;
                }
            }

            if($noop) {
                DB::rollback();
                Session::put('flow_error',"Can not save data to db $noop"); return Redirect::back();
            }else {
                DB::commit();
            }

        }else{
            Session::put('flow_error','Can not save data to db __ array mismatch __'); return Redirect::back();
        }

        return redirect('/cms/product/list');
    }

    private function clearInsetTables( $pr ){
        Prices::destroy( Prices::where('ProductID','=',$pr)->get(['PriceID'])->toArray() );
        ProductByProperty::destroy( ProductByProperty::where('ProductID','=',$pr)->get(['ID'])->toArray() );
    }

    private function insertSubProperty( $arr ){
        try{
            DB::table('T_ProductByProperty')->insert($arr);
        }catch (QueryException $e){
            return $e->getCode();
        }
        return true;
    }

    public function postUpdatePicture(){

        $response = 'fail';
        if( Input::hasFile('file') && Input::has('relation') ){
            $file = Input::file('file');
            $arr = explode('-',Input::get('relation'));
            if(isset($arr[0]) && isset($arr[1])){
                if( $arr[0] == 'subcategory' ){
                    $data = SubCategory::find($arr[1]);

                    $image = Image::make($file->getRealPath())->fit(239, 239);
                    $fileName = time().'.'.$file->getClientOriginalExtension();
                    $data->Image = $fileName;
                    $image->save('/var/www/html/taksitle.com/img/thumbs/'.$fileName);

                    $image = Image::make($file->getRealPath())->fit(555, 555);
                    $image->save('/var/www/html/taksitle.com/img/big/'.$fileName);

                    if( $data->save() ){
                        $response = 'ok';
                    }
                }
            }
        }

        return $response;
    }
}