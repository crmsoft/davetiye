<?php

use App\Models\Utils\Utills;

$u = new Utills();

?>
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
            <?php Session::forget('subcategory'); ?>
        </ul>
    </div>
</div>