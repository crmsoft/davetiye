@extends('layouts.web')
<?php
use App\Models\Utils\Utills;
$u = new Utills(); ?>
@section('content')
    {!! Html::style('/css/tab.css') !!}
    {!! Html::style('/bower_components/lightslider/src/css/lightslider.css') !!}
    {!! Html::style('bower_components/lightgallery/light-gallery/css/lightGallery.css') !!}

    <style>
        ul{
            list-style: none outside none;
            padding-left: 0;
        }
        .content-slider li{
            text-align: center;
            color: #FFF;
        }
        .content-slider h3 {
            margin: 0;
            padding: 70px 0;
        }
        .demo{
            width: inherit;
        }
    </style>
    {!! Html::script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') !!}
    {!! Html::script('/bower_components/lightslider/dist/js/lightslider.min.js') !!}
    {!! Html::script('/bower_components/lightgallery/light-gallery/js/lightGallery.min.js') !!}

    {!! Html::script('/scripts/custom/tab.js') !!}
    {!! Html::script('/scripts/custom/product-change.js') !!}
    {!! Html::script('/scripts/custom/box-add.js') !!}

    @include('layouts.side-bar')

    @if(Session::has('warning'))
        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!!Session::pull('warning') !!}
        </div>
    @else
        @if(isset($products[$st_index]->img) || true)
            <?php
            $onceki_ozellik = $products[$st_index]->oz;
            $total_props = count($products);
            $quantity = [];$oncel_adet = '';
            ?>
            <div class="content1">
                <div class="nav">
                    <ul>
                        <li><a href="{!! route('web-get-subcategory') !!}">Ürünler</a></li>
                        <li>/</li>
                        <li><a href="{!! route('web-get-subcategory-products', Session::get('subcategory') ) !!}">{!! ucwords($u->removeSlahes(Route::input('subcategory')))  !!}</a></li>
                        <li>/</li>
                        <li id="product" class="act">{!!$products[$st_index]->ua !!}</li>
                    </ul>
                </div>
                <div class="urun-thumb">
                    @if(!isset($products[$st_index]->img))
                        {!! Html::image('http://www.placehold.it/239x239/EFEFEF/AAAAAA&text=Ürün Görselleri Bulunamadı','',array('width'=>"239", 'height'=>"239")) !!}
                    @else
                        <div class="demo">
                            <ul id="demo" class="content-slider">
                                @foreach($gallery as $key=>$value)
                                    <li data-thumb="{!! '/img/big/'.$value['ImageName'] !!}" data-src="{!! '/img/big/'.$value['ImageName'] !!}">
                                        <a href="javascript:;">
                                            {!! Html::image('img/big/'.$value['ImageName'],'urun',['width'=>'310','height'=>'310']) !!}
                                            <div class="incele"></div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="urun-info">
                    <table border="0" cellspacing="0" cellpadding="0" data-rel="{{ Session::get('id') }}" id="product_subproperties">
                        <tr>
                            <th width="108" align="left" valign="middle"><span>FİYAT</span></th>
                            <th width="172" align="left" valign="middle"><em id="product_total_price">0</em> TL</th>
                        </tr>
                        <tr>
                            <td align="left" valign="middle"><label for="alt_oz1">{!! $products[$st_index]->oz !!}</label></td>
                            <td>
                                <select name="alt_oz1" id="alt_oz1">
                                    {{--<option data-rel='{!! mb_strtolower($products[$st_index]->aoid) !!}' value="{!!$products[$st_index]->il !!}">{!! $products[$st_index]->ao  !!}</option>
                                 --}}@for($i=0;$i<$total_props; $i++)
                                        @if( $minQ->adet != $products[$i]->adet )
                                            <?php
                                            $quantity[$products[$i]->adet] = "<option value='".$products[$i]->bf."'>".$products[$i]->adet."</option>";
                                            continue;
                                            ?>
                                        @else
                                            <?php $quantity[$minQ->adet] = "<option selected='selected' value='".$minQ->bf."'>".$minQ->adet."</option>"; ?>
                                        @endif
                                        @if( $onceki_ozellik == $products[$i]->oz )
                                            <option data-rel="{!! mb_strtolower($products[$i]->aoid) !!}" value="{!!$products[$i]->il !!}">{!! $products[$i]->ao  !!}</option>
                                        @else
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <?php $onceki_ozellik = $products[$i]->oz; ?>
                            <td align="left" valign="middle"><label for="alt_oz{!!($i+1) !!}">{!! $products[$i]->oz !!}</label></td>
                            <td>
                                <select name="alt_oz{!!($i+1) !!}" id="alt_oz{!!($i+1) !!}">
                                    <option data-rel="{!! mb_strtolower($products[$i]->aoid) !!}" value="{!!$products[$i]->il !!}">{!! $products[$i]->ao  !!}</option>
                                    @endif
                                    @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="adte">ADET</label>
                            </td>
                            <td>
                                <select name="adet" id="adet" disabled>
                                    @foreach($quantity as $a=>$b)
                                        {!! $b  !!}
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="cleaner"></div>
                    <a href="javascript:void(0)" id="add_to_box" class="btn btn-sepete-ekle">SEPETE EKLE</a>

                    <form action="{{route('web-check-bucket')}}" id="check_out" method="post">
                        <input type="submit" class="btn btn-hemen-al" value="HEMEN AL" />
                        {!! Form::token() !!}
                    </form>
                </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3>Ürün Bilgileri Bulunamadı</h3>
                    </div>
                @endif
                <div class="cleaner"></div>
                <div class="tab-wrap">
                    <div class="tabs">
                        <li class="active" rel="tab1">Açıklama</li>
                        <li rel="tab2">Taksit Seçenekleri</li>
                        <li rel="tab3">Telefonla Sipariş</li>
                    </div>

                    <div class="tab_container">
                        <div id="tab1" class="tab-con">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has ley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>

                        <div id="tab2" class="tab-con">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>

                        <div id="tab3" class="tab-con">
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has ley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="cleaner"></div>
        <div class="banner1">{!! Html::image('img/decor/img-banner1.jpg','Banner 1',array('width'=>'310','height'=>'197')) !!}</div>
        <div class="banner2">{!! Html::image('img/decor/img-banner2.jpg','Banner 2',array('width'=>'310','height'=>'197')) !!}</div>
        <div class="banner3">{!! Html::image('img/decor/img-banner3.jpg','Banner 3',array('width'=>'318','height'=>'197')) !!}</div>
@stop