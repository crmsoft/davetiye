@extends('layouts.cms')

<?php
use App\Models\Utils\Utills;
$obj = new Utills();
?>
@section('content')

    @if(Session::has('flow_error'))
        <div class="row">
            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!!Session::flash('flow_error') !!}
            </div>
        </div>
    @endif
    <div class="col-sm-6" style="margin-left: -15px;">
        <select class="form-control" onchange="window.location = window.location.origin + '/cms/sub-property/list/' + this.options[this.selectedIndex].value">
            <option value="">Tümü</option>
            @foreach($properties as $key=>$val)
                <?php $s_url = $obj->seoUrl( $val['Title'] ); ?>
                <option value="{!! $s_url !!}" {{ $s_url == Route::input('property') ? 'selected':''  }} >{!! $val->Title !!}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-6">
        <a class="btn green pull-right" data-toggle="modal" href="#createOrUpdate">
            Yeni Ekle |
            <i class="fa fa-plus"></i>
        </a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Başlık</th>
            <th>Özellik</th>
            <th>Sıra numarası</th>
            <th>Durum</th>
            <th>Oluşturma tarihi</th>
            <th>Güncelle</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subproperties as $key=>$subproperty)
            <tr data-origin="{{ $subproperty->SubPropertyID }}">
                <td>{{ $subproperty->Title  }}</td>
                <td>{{ $subproperty->property  }}</td>
                <td>{{ $subproperty->OrderNo  }}</td>
                <td class="c-mr-on-span" data-rel="SubProperty-{!! $subproperty->SubPropertyID !!}">
                    <input type="checkbox"
                           style="margin-right: 0 !important;"
                           class="make-switch" id="active_pop_up_form"
                           data-size="mini"
                           data-on-color="success"
                           data-off-color="danger"
                           data-on-text="Aktiv"
                           data-off-text="Pasif"
                           {!! $subproperty->Status ? 'checked':'' !!}>
                </td>
                <td>{{ $subproperty->created_at  }}</td>
                <td>
                    <button type="button" class="btn blue btn-round tooltips btn-refresh" data-placement="bottom" data-original-title="Güncelle">
                        <i class="fa fa-refresh"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- MODAL NEW -->
    <div class="modal fade" id="createOrUpdate" tabindex="-1" role="basic" aria-hidden="true">
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
                                <input class="form-control" name="Title" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="">Özellik</label>
                            <div class="col-md-8">
                                <select name="PropertyID" id="" class="form-control">
                                    @foreach($properties as $propery)
                                        <option value="{{ $propery->PropertyID }}">{{ $propery->Title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sıra numarası</label>
                            <div class="col-md-8">
                                <div id="spinner1">
                                    <div class="input-group">
                                        <input type="text" name="OrderNo" class="spinner-input form-control" maxlength="3">
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
                                       name="Status"
                                       class="make-switch" id="active_pop_up_form"
                                       data-size="mini"
                                       data-on-color="success"
                                       data-off-color="danger"
                                       data-on-text="Aktiv"
                                       data-off-text="Pasif">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn default" data-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn blue">Ekle</button>
                        </div>
                        <input type="hidden" name="table_to_insert" value="SubProperty"/>
                        {!! Form::token() !!}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL END NEW -->
@stop