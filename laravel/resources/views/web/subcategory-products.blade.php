@extends('layouts.web')
<?php use App\Models\Utils\Utills; $u = new Utills();  ?>
@section('content')

    <div class="side-bar">
        <div class="musteri-hizmetleri"></div>
        <div class="kampanya fl">{!! Html::image('img/decor/img-garanti.jpg','',array('width'=>"118", 'height'=>"126")) !!}</div>
        <div class="kampanya fr">{!! Html::image('img/decor/img-max.jpg','',array('width'=>"118", 'height'=>"126")) !!}</div>
        <div class="sub-menu">
            <ul>
                @foreach( $categories as $key=>$val )
                    <?php $url = $u->seoUrl($val->Title); ?>
                    <a href="{!! URL::to( 'urunler', [ $url ] ) !!}">
                        <li class="{!! ($url == Session::get('subcategory')) ? 'act':'' !!}">
                            {!! $val->Title !!}
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
    @if(Session::has('warning'))
        <div class="item3">
            {!! Session::get('warning') !!}
        </div>
    @else
        @foreach( $products as $key => $value )
            <?php $price = $u->getMinProductPriceByID($value->ProductID); if(!$price){ continue; } ?>
            <a href="{!! URL::to( 'urunler', [ Route::input('subcategory'), $u->seoUrl($value->ProductID) ] ) !!}">
                <div class="pro">
                    <div class="btn-pro"></div>
                    {!! Html::image('img/thumbs/'.$value->ImageName,'',array('width'=>"239", 'height'=>"239")) !!}
                    <div class="pro-info">
                        <span class="fl" style="font-size: 12px;padding-top: 2px;">{!! $value->Title !!}</span>
                        <span class="fr">{!! $price !!} TL</span>
                    </div>
                </div>
            </a>
        @endforeach
    @endif
    <div class="cleaner"></div>
    <div class="banner1">{!! Html::image('img/decor/img-banner1.jpg','Banner 1',array('width'=>'310','height'=>'197')) !!}</div>
    <div class="banner2">{!! Html::image('img/decor/img-banner2.jpg','Banner 2',array('width'=>'310','height'=>'197')) !!}</div>
    <div class="banner3">{!! Html::image('img/decor/img-banner3.jpg','Banner 3',array('width'=>'318','height'=>'197')) !!}</div>

@stop