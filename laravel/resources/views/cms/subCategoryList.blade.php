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
                    {!! Html::image('http://www.placehold.it/75x75/EFEFEF/AAAAAA&text=EMPTY','Ürün ', array('height'=>'75','width'=>'75')) !!}
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
@stop