<?php namespace App\Http\Controllers\web;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Quantity;
use App\Models\Utils\Utills;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Services\Registrar;
use Mail;

class FormController extends Controller {

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

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

    public function postRegisterClient( Registrar $reg, Request $request ){

        $data = Input::except(['_token']);
        $validator = $reg->validator($data);

        if (!$validator->fails())
        {
            $data['role'] = 'client';$data['code'] = str_random(70);
            if($res = $reg->create($data)){
                if($this->sendClientEmail( $data )) {
                    return redirect(route('web-client-activate-info'));
                }
            }
        }

        return redirect(route('web-get-register-user'))
            ->withInput($request->only('email', 'firstname', 'lastname'))
            ->withErrors(
                $validator->getMessageBag()->getMessages()
            );
    }

    private function sendClientEmail( $data ){
        Mail::send('emails.confirm', $data, function($message) use ($data)
        {
            $message->to($data['email'], 'John Smith')->subject('Taksitle Reklam!');
        });
        return true;
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt(
            [
                "email" => $credentials['email'],
                "password" => $credentials['password'],
                'active' => '1'
            ],
            $request->has('remember')))
        {
            return redirect()->intended(route('web-get-shopping-box'));
        }

        return redirect(route('web-get-register-user'))
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    private function getFailedLoginMessage(){
        return 'E-posta adresiniz ya da şifreniz yanlış.';
    }

    public function postUserCheckOutStep1(){

        dd(Input::all());

    }
}
