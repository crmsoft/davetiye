@extends('layouts.cms')
<?php

use App\Models\Utils\Utills;

$obj = new Utills();
?>
@section('content')
    <div class="row">
        <div class="col-sm-5">
            <select class="form-control" onchange="window.location = window.location.origin + '/cms/product/list/' + this.options[this.selectedIndex].value">
                <option value="">Tümü</option>
                @foreach($subcategories as $key=>$val)
                    <?php $s_url = $obj->seoUrl( $val['Title'] ); ?>
                    <option value="{!! $s_url !!}" {{ $s_url == Route::input('subcategory') ? 'selected':''  }} >{!! $val['Title'] !!}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6"></div>
    </div>
    <table class="table">
        <thead></thead>
        <tfoot></tfoot>
        <tbody>
            @foreach($products as $key => $value)
                <tr>
                    <td>
                        @if($value->img)
                            {!! Html::image('img/thumbs/'.$value->img,'Ürün', array('data-rel'=>'gallery-'.$value->ProductID,'title'=>'Bu Ürünun '.'5 görseli bulundu','class'=>'sub-category-thumb gallery','height'=>'75','width'=>'75')) !!}
                        @else
                            {!! Html::image('http://www.placehold.it/75x75/EFEFEF/AAAAAA&text=EMPTY','Ürün ', array('data-rel'=>'gallery-'.$value->ProductID,'class'=>'sub-category-thumb gallery','height'=>'75','width'=>'75')) !!}
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
                    <td class="c-mr-on-span" data-rel="Product-{!! $value->ProductID !!}">
                        <input type="checkbox"
                               style="margin-right: 0 !important;"
                               class="make-switch" id="active_pop_up_form"
                               data-size="mini"
                               data-on-color="success"
                               data-off-color="danger"
                               data-on-text="Aktiv"
                               data-off-text="Pasif"
                               {!! $value->Status ? 'checked':'' !!}>
                    </td>
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
    <!-- MODAL DROPZONE -->
    <div id="fileChooser" class="modal fade bs-modal-sm" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Yeni görsel seçin</h4>
                </div>
                <div class="modal-body">
                    <form action="{!! route('cms-post-update-form-picture') !!}" class="dropzone" id="myDZ" enctype="multipart/form-data">
                        <div class="fallback">
                            <input name="file" type="file" />
                            <input type="hidden" value="{!! csrf_token() !!}"/>
                        </div>
                        <div class="dz-message" data-dz-message>
                            <span><p>Yuklemek istediğiniz görseli buraya sürekleyin<br /> ve ya <br />tıklayarak seçin</span></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn default">Kapat</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL END DROZONE -->
@stop