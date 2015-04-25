<?php namespace App\Http\Controllers\web;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Prices;
use App\Models\ProductByProperty;
use App\Models\Quantity;
use App\Models\Utils\Utills;
use Illuminate\Support\Facades\Input;
use Session;

class FormController extends Controller {

    public function postProductDetails(){

        $id = Session::get('id');

        $u = new Utills();
        $results = $u->getProductById($id);

        return response()->json($results);
    }

    public function postCheckBucket(){

        $u = new Utills(); $res = [];
        if(Input::has('box')){
            $bucket = json_decode(Input::get('box'));
            foreach($bucket as $key=>$val){
                $q = Quantity::where('Title','=',$val->subpr[(count($val->subpr)-1)])->get()->toArray();
                if(!empty($q)) {
                    array_pop($val->subpr);
                    $res[] = $u->getProductDetails($val->product, $q[0]['QuantityID'],join(',',$val->subpr));
                }
            }
            Session::put('_box',$bucket);
        }
        Session::put('res',$res);
        return redirect('/sepetim');
    }

    public function postProductByPropsAndQuantity(){
        if(Input::has('data')){
            $u = new Utills();$d = explode('_',Input::get('data'));
            $bucket = Session::get('_box');
            $t = $u->getProductDetails($bucket[$d[0]]->product,$d[1],join(',',$bucket[$d[0]]->subpr));
            $total = 0;$def = 0;
            foreach($t as $r){
                $def = $r->bf;
                $total += $r->il;
            }
            return response()->json([ 'res'=>[ number_format($total+$def,2), $bucket[$d[0]]->id ] ]);
        }
        return response()->json(['res'=>'empty']);
    }

    public function postUserCheckOutStep1(){

        dd(Input::all());

    }
}
