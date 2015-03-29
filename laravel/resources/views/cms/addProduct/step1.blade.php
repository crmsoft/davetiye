@extends('layouts.cms')

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
        <h4>
            <a href="{!! route('cms-add-product') !!}">{!! Session::get('Product')['Title']; !!}</a>
        </h4>
    </div>
</div>
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
</div>
<div class="row">
    <div class="col-md-6">
        <form action="{!! route('cms-post-insert-product-stage-2') !!}" class="form-horizontal bordered-row" method="post">
            <div class="form-group">
                <div class="col-sm-12">
                    <?php $tmp = Session::get('ProductQuantityID'); ?>
                    <div class="checks-container">
                        @foreach($q as $key=>$val)
                            <div class="row">
                                <div class="col-sm-4">
                                    @if(in_array($val->QuantityID,Session::get('ProductQuantityID')))
                                        {!! Form::input('number','quantity_price',Session::get('ProductQuantity')[array_search($val->QuantityID,Session::get('ProductQuantityID'))]['DefaultPrice'],['step'=>'0.01','placeholder'=>'125.25','class'=>'form-control','name'=>'quantitiesPrices['.$val->QuantityID.'][]','placeholder'=>'125.25']) !!}
                                    @else
                                        {!! Form::input('number','quantity_price',null,['step'=>'0.01','placeholder'=>'125.25','class'=>'form-control','name'=>'quantitiesPrices['.$val->QuantityID.'][]','placeholder'=>'125.25']) !!}
                                    @endif
                                </div>
                                <div class="col-sm-4 padding-top-5">
                                    @if(in_array($val->QuantityID,Session::get('ProductQuantityID')))
                                        <input checked name="qunatitiesIds[][id]" class="from-control" type="checkbox" id="{!! $val->QuantityID !!}" value="{!! $val->QuantityID !!}"/>
                                    @else
                                        <input name="qunatitiesIds[][id]" class="from-control" type="checkbox" id="{!! $val->QuantityID !!}" value="{!! $val->QuantityID !!}"/>
                                    @endif
                                        <label for="{!! $val->QuantityID !!}">{!! $val->Title !!}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <br/>
            <div class="col-sm-12">
                <a href="{!! route('cms-add-product') !!}" class="btn btn-default pull-left">Önceki Adım</a>
                <input type="submit" value="Sonraki Adım" class="btn btn-info pull-right"/>
            </div>
            {!! Form::token(); !!}
        </form>
    </div>
    <div class="col-md-5">
        <form class="form-horizontal bordered-row" method="post" action="{!! route('cms-post-insert-form') !!}">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="">Başlık</label>
                <div class="col-sm-7">
                    {!! Form::text('Title',null,['class'=>'form-control','placeholder'=>"50000",''=>'required']); !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="">Sıra Numarası</label>
                <div class="col-sm-7">
                    {!! Form::input('number','OrderNo',1,['class'=>'form-control','placeholder'=>"1", 'min'=>"1"] ); !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-5"></div>
                <div class="col-sm-6">
                    <input type="submit" value="Ekle" class="btn btn-info pull-right" />
                </div>
            </div>
            <input type="hidden" value="Quantity" name="table_to_insert" />
            {!! Form::token(); !!}
        </form>
    </div>
</div>

@stop