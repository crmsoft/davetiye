@extends('layouts.web')
<?php

use App\Models\Utils\Utills;

        $u = new Utills();

?>
@section('content')

    <div class="side-bar">
        <div class="musteri-hizmetleri"></div>
        <div class="kampanya fl">{!! Html::image('img/decor/img-garanti.jpg','',array('width'=>"118", 'height'=>"126")) !!}</div>
        <div class="kampanya fr">{!! Html::image('img/decor/img-max.jpg','',array('width'=>"118", 'height'=>"126")) !!}</div>
        <div class="sub-menu">
            <ul>
                @foreach( $categories as $key=>$val )
                    <a href="{!! URL::to( 'urunler', array( $u->seoUrl($val->Title) ) ) !!}"><li>{!! $val->Title !!}</li></a>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="item3">
        @foreach( $categories as $key=>$value )
            @if( $key % 2 == 0 )
    </div>
    <div class="item3">
        @endif
        <a href="{!! URL::to( 'urunler', array(  $u->seoUrl($value->Title) ) ) !!}">
            <div class="md-box">
                {!! Html::image('img/big/'.$value->Image,$value->Image,array('width'=>"239", 'height'=>"239")) !!}
                <h6 class="color{{rand(1,20)}}">{{$value->Title}}</h6>
            </div>
        </a>
        @endforeach
    </div>
    <div class="cleaner"></div>
    <div class="banner1">{!! Html::image('img/decor/img-banner1.jpg','Banner 1',array('width'=>'310','height'=>'197')) !!}</div>
    <div class="banner2">{!! Html::image('img/decor/img-banner2.jpg','Banner 2',array('width'=>'310','height'=>'197')) !!}</div>
    <div class="banner3">{!! Html::image('img/decor/img-banner3.jpg','Banner 3',array('width'=>'318','height'=>'197')) !!}</div>

@stop