@extends('layouts.cms')
<?php

?>
@section('content')
    @if(Session::has('flow_error'))
        <div class="row">
            <div class="alert alert-warning">
                <div class="bg-orange alert-icon">
                    <i class="glyph-icon icon-warning"></i>
                </div>
                <h4 class="alert-title">Warning !!!</h4>
                <p>
                    <?php echo Session::pull('flow_error'); ?>
                </p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-6">
            @if( Session::has('stage') )
                <h3>{!! Session::get('stage') !!}</h3>
            @endif
        </div>
        <div class="col-sm-5">
            @if( Session::has('addForm') )
                <h3>{!! Session::get('addForm') !!}</h3>
            @endif
        </div>
        <div class="col-md-6">
            <form class="form-horizontal bordered-row" id="demo-form" action="{!! route('cms-post-insert-product-stage-1') !!}" method="post" data-parsley-validate>
                <select name="product_id" id="" size="15" class="form-control" required>
                    @foreach($productList as $k=>$v)
                        <option value="{!! $v->ProductID !!}">{!! $v->subcategory !!} - {!! $v->Title !!}</option>
                    @endforeach
                </select>
                <br/>
                <div class="col-sm-12">
                    <a disabled class="btn btn-default pull-left">Önceki Adım</a>
                    <input type="submit" value="Sonraki Adım" class="btn btn-info pull-right"/>
                </div>
                {!! Form::token(); !!}
            </form>
        </div>
        <div class="col-md-5">

            <form class="form-horizontal bordered-row" id="demo-form" action="{!! route('cms-post-insert-form') !!}" method="post" data-parsley-validate>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Kategori</label>
                    <div class="col-sm-6">
                        <select name="SubCategoryID" id="" size="4" class="form-control" required>
                            @foreach($sbcats as $key=>$val)
                                <option value="{!! $val->CategoryID !!}">{!! $val->Title !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label" for="">Başlık</label>
                    <div class="col-sm-6">
                        {!! Form::text('Title',null,['class'=>'form-control', 'required'=>'required', 'placeholder'=>"100 gr küşe",''=>'required']); !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label" for="">Sıra Numarası</label>
                    <div class="col-sm-6">
                        {!! Form::input('number','OrderNo',1,['class'=>'form-control', 'required'=>'required', 'placeholder'=>"1", 'min'=>"1"] ); !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-6">
                        <input type="submit" value="Ekle" class="btn btn-info pull-right" />
                    </div>
                </div>
                <input type="hidden" value="Product" name="table_to_insert" />
                {!! Form::token(); !!}
            </form>

        </div>
    </div>
@stop