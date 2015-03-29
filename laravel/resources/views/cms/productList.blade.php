@extends('layouts.cms')
<?php

use App\Models\Utils\Utills;

$obj = new Utills();
?>
@section('content')

    <table class="table">
        <thead></thead>
        <tfoot></tfoot>
        <tbody>
            @foreach($products as $key => $value)
                <tr>
                    <td>
                        @if($value->img)
                            {!! Html::image('img/big/'.$value->img,'Ürün', array('title'=>'Bu Ürünun '.'5 görseli bulundu','height'=>'75','width'=>'75')) !!}
                        @else
                            {!! Html::image('http://www.placehold.it/75x75/EFEFEF/AAAAAA&text=EMPTY','Ürün ', array('height'=>'75','width'=>'75')) !!}
                        @endif
                    </td>
                    <td><u>{!! $value->subcategory !!}</u></td>
                    <td><b>{!! $value->Title !!}</b></td>
                    <td> <?php $tmp = $obj->getMinProductPriceByID($value->ProductID); ?>
                        <i>@if( $tmp )
                        {!! $tmp !!}
                        @else
                        {!! '0.00' !!}
                        @endif
                            TL</i>
                    </td>
                    <td>{!! $value->OrderNo !!}</td>
                    <td>{!! $value->Status !!}</td>
                    <td>{!! $value->CreateDate !!}</td>
                    <td>
                        <form action="{!! route('cms-post-insert-product-stage-1') !!}" method="post">
                            <input type="hidden" value="{!! $value->ProductID !!}" name="product_id" />
                            <button type="submit" class="btn blue btn-round tooltips" data-placement="bottom" data-original-title="Güncelle">
                                <i class="fa fa-refresh"></i>
                            </button>
                            {!! Form::token() !!}
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop