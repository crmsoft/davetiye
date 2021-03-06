<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', array(
	'as' => 'web-get-index',
	'uses' => 'web\DefaultController@getIndex'
));

Route::get('/urunler', [
   'as' => 'web-get-subcategory',
    'uses' => 'web\DefaultController@getListProperty'
]);

Route::get('/urunler/{subcategory}', [
    'as' => 'web-get-subcategory-products',
    'uses' => 'web\DefaultController@getProductsOfSubcategory'
])->where('subcategory', '[A-Za-z-]+');;

Route::get('/urunler/{subcategory}/{id}', [
    'as' => 'web-get-subcategory-product-by-id',
    'uses' => 'web\DefaultController@getProductById'
])->where(['subcategory' => '[A-Za-z-]+', 'id' => '[0-9]+']);

Route::get('/yeni-uye',[
   'as' => 'web-get-register-user',
    'uses' => 'web\DefaultController@getClientRegister'
]);

Route::get('/web/logout',[
    'as' => 'web-log-out-user',
    'uses' => 'web\DefaultController@getLogout'
]);

Route::get('/client/activate',[
    'as' => 'web-client-activate-info',
    'uses' => 'web\DefaultController@getActivate'
]);

Route::get('/activate/{code}',[
    'as' => 'web-client-activate',
    'uses' => 'web\DefaultController@getClientActivate'
]);

/////--------------POST--------------------///////


Route::post('/products/detailed/post',[
    'as' => 'web-get-product-details-from-server',
    'uses' => 'web\FormController@postProductDetails'
]);

Route::post('/products/by/quantity/props',[
    'as' => 'web-get-product-by-q-and-p',
    'uses' => 'web\FormController@postProductByPropsAndQuantity'
]);

Route::post('/check/bucket',[
   'as' => 'web-check-bucket',
    'uses' => 'web\FormController@postCheckBucket'
]);

Route::post('web/auth/post-sign-in', array(
    'as' => 'web-look-up-user',
    'uses' => 'web\FormController@postLogin'
));

Route::post('web/auth/post-register', array(
    'as' => 'web-register-client',
    'uses' => 'web\FormController@postRegisterClient'
));

/* group check out box --> only logged in users do */

Route::group(['middleware' => 'client'], function() {

    Route::get('/sepetim',[
        'as'=>'web-get-shopping-box',
        'uses'=>'web\DefaultController@getShoppingBox'
    ]);

    Route::post('/user/check-out/step1', [
        'as' => 'user-check-out-step-1',
        'uses' => 'web\FormController@postUserCheckOutStep1'
    ]);

});
////--------------End----------------------//////

/////---------------CMS--------------------///////
/////--------------AUTH--------------------///////


Route::get('/cms/auth/login', array(

    'as' => 'authorize',
	'uses' => 'Auth\AuthController@getLogin'
));

Route::post('cms/auth/post-sign-in', array(
	'as' => 'look-up-user',
	'uses' => 'Auth\AuthController@postLogin'
));

Route::get('cms/auth/logout', array(
	'as' => 'log-out-user',
	'uses' => 'Auth\AuthController@getLogout'
));

//////////------------end--------AUTH-------------////////////

Route::get('cms/dashboard', array(
    'as' => 'cms-index',
    'uses' => 'cms\BaseController@getCmsIndex'
));

Route::get('cms/product/list/{subcategory?}', array(
	'as'=>'cms-list-product',
	'uses'=>'cms\BaseController@getListProducts'
))->where(['subcategory' => '[A-Za-z-]+']);

Route::get('cms/product/add', array(
	'as'=>'cms-add-product',
	'uses'=>'cms\BaseController@getAddProduct'
));

Route::get('cms/product/add/step/1', array(
	'as'=>'cms-add-product-step1',
	'uses'=>'cms\BaseController@getAddProductStep1'
));

Route::get('cms/product/add/step/2', array(
	'as'=>'cms-add-product-step2',
	'uses'=>'cms\BaseController@getAddProductStep2'
));

Route::get('cms/sub-category/list',[
   'as' => 'cms-list-sub-category',
    'uses' => 'cms\SubController@getSubCategoryList'
]);

Route::get('cms/property/list',[
    'as' => 'cms-list-property',
    'uses' => 'cms\SubController@getPropertyList'
]);

Route::get('cms/sub-property/list/{property?}',[
    'as' => 'cms-list-sub-property',
    'uses' => 'cms\SubController@getSubPropertyList'
]);

///////////--------CMS-------POST----REQUESTS--GOES--HERE--------////////

Route::post('cms/insert/form', [
	'as' => 'cms-post-insert-form',
	'uses'=>'cms\FormController@postInsertInTable'
]);

Route::post('cms/update/form', [
    'as' => 'cms-post-update-form',
    'uses'=>'cms\FormController@postUpdateColumns'
]);

Route::post('cms/insert/form/stage/1', [
	'as' => 'cms-post-insert-form-stage-1',
	'uses'=>'cms\FormController@postInsertInTableStage1'
]);

Route::post('cms/insert/product/stage/1', [
	'as'=>'cms-post-insert-product-stage-1',
	'uses'=>'cms\FormController@postCheckInStage1'
]);

Route::post('cms/insert/product/stage/2', [
	'as'=>'cms-post-insert-product-stage-2',
	'uses'=>'cms\FormController@postCheckInStage2'
]);

Route::post('cms/insert/product/stage/3',[
	'as'=>'cms-post-insert-product-stage-3',
	'uses'=>'cms\FormController@postCheckInStage3'
]);

Route::post('cms/update/form/picture',[
   'as' => 'cms-post-update-form-picture',
    'uses' => 'cms\FormController@postUpdatePicture'
]);

Route::post('cms/post/request/table', [
    'as' => 'cms-request-table-data',
    'uses'=>'cms\FormController@postGetTableData'
]);
