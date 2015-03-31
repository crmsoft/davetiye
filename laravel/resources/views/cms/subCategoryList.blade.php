@extends('layouts.cms')
<?php
    $u = new App\Models\Utils\Utills();
?>
@section('content')
        <div class="row">
            <div class="col-sm-12">
                <a class="btn green pull-right" data-toggle="modal" href="#basic">
                    Yeni Ekle |
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
    <table class="table">
        <thead>
        <tr>
            <th>
                Görsel
            </th>
            <th>
                Başlık
            </th>
            <th>
                Sırası
            </th>
            <th>
                Status
            </th>
            <th>
                Oluşturma Tarihi
            </th>
            <th>
                Ürün Sayısı
            </th>
            <th>
                Güncelle
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($subcategories as $key=>$value)
            <tr>
                <td data-rel="subcategory-{!! $value->SubCategoryID !!}">
                    @if($value->Image)
                        {!! Html::image('img/thumbs/'.$value->Image,'Ürün', array('class'=>'sub-category-thumb','data-rel'=>'subcategory-'.$value->SubCategoryID,'height'=>'75','width'=>'75')) !!}
                    @else
                        {!! Html::image('http://www.placehold.it/75x75/EFEFEF/AAAAAA&text=EMPTY','Ürün ', array('class'=>'sub-category-thumb','data-rel'=>'subcategory-'.$value->SubCategoryID,'height'=>'75','width'=>'75')) !!}
                    @endif
                </td>
                <td>
                    {!! $value->Title !!}
                </td>
                <td>
                    {!! $value->OrderNo !!}
                </td>
                <td class="c-mr-on-span" data-rel="SubCategory-{!! $value->SubCategoryID !!}">
                    <input type="checkbox"
                           style="margin-right: 0 !important;"
                           class="make-switch" id="active_pop_up_form"
                           data-size="mini"
                           data-on-color="success"
                           data-off-color="danger"
                           data-on-text="Aktiv"
                           {!! $value->Status ? 'checked':'' !!}
                           data-off-text="Pasif">
                </td>
                <td>
                    {!! $value->CreateDate !!}
                </td>
                <td>
                    <a href="{!! route('cms-list-product', $u->seoUrl($value->Title) ) !!}" style="text-decoration: none;">
                        <!-- <i class="fa fa-plus"></i> -->
                        <span class="badge badge-info" style="color: #000000;">
                            {!! $value->total_products !!}
                        </span>
                    </a>
                </td>
                <td>
                    <button type="submit" class="btn blue btn-round tooltips" data-placement="bottom" data-original-title="Güncelle">
                        <i class="fa fa-refresh"></i>
                    </button>
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
                    <form style="width: 270px; margin: 0 auto" action="{!! route('cms-post-update-form-picture') !!}" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
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
    <!-- MODAL NEW -->
    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Yeni alt kategori ekleme</h4>
                </div>
                <div class="modal-body">
                    <form action="{!! route('cms-post-insert-form') !!}" method="post" class="form-horizontal form-row-stripped">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="">Başlık</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="">Kategori</label>
                            <div class="col-md-8">
                                <select class="form-control" name="" id="">
                                    @foreach($categories as $category)
                                        <option value="{!! $category->CategoryID !!}">{!! $category->Title !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sıra numarası</label>
                            <div class="col-md-8">
                                <div id="spinner1">
                                    <div class="input-group">
                                        <input type="text" class="spinner-input form-control" maxlength="3">
                                        <div class="spinner-buttons input-group-btn btn-group-vertical">
                                            <button type="button" class="btn spinner-up btn-xs blue">
                                                <i class="fa fa-angle-up"></i>
                                            </button>
                                            <button type="button" class="btn spinner-down btn-xs blue">
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="">Status</label>
                            <div class="col-md-8 c-mr-on-span">
                                <input type="checkbox"
                                       style="margin-right: 0 !important;"
                                       class="make-switch" id="active_pop_up_form"
                                       data-size="mini"
                                       data-on-color="success"
                                       data-off-color="danger"
                                       data-on-text="Aktiv"
                                       data-off-text="Pasif">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn blue">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL END NEW -->
@stop