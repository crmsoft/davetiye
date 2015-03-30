@extends('layouts.cms')
<?php
    $u = new App\Models\Utils\Utills();
?>
@section('content')
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
        </tr>
        </thead>
        <tbody>
        @foreach($subcategories as $key=>$value)
            <tr>
                <td>
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
                <td>
                    {!! $value->Status !!}
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
@stop