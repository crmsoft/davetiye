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
    <script src="/scripts/custom/productAdd.js"></script>
    <?php $tmp_q = Session::get('UserInsertQuantity'); $tmp_q = $tmp_q ? $tmp_q : []; ?>
    <div class="row">
        <div class="col-sm-6">
            <h4>
                <a href="{!! route('cms-add-product') !!}">{!! Session::get('Product')->Title !!}</a> /
                <a href="{!! route('cms-add-product-step1') !!}">
                    @foreach($tmp_q as $obj)
                    [{!! $obj['Title'] !!}]
                    @endforeach
                </a>
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
        <div class="col-sm-8">
            <form action="{!! route('cms-post-insert-product-stage-3') !!}" class="form-horizontal bordered-row" method="post">
                @foreach($tmp_q as $obj)
                    <span class="btn btn-success pull-right">[ {!! $obj['Title'] !!} ]</span>
                <div class="checks-container">

                        @for($i = 0, $cnt = count($properties);$i<$cnt; $i++)
                            <div class="property">
                                <dev>
                                    <input name="properties[{!! $obj['QuantityID'] !!}][]" class="form-control" type="checkbox" id="{!! $properties[$i]['PropertyID'] !!}" value="{!! $properties[$i]['PropertyID'] !!}"/>
                                    <label for="{!! $properties[$i]['PropertyID'] !!}">{!! $properties[$i]['prop'] !!}</label>
                                </dev>

                                <dev class="sub-property row hidden">
                                    <?php $tmp_prop = $properties[$i]['PropertyID']; ?>
                                    @for(;$i<$cnt;$i++)
                                        @if( $tmp_prop != $properties[$i]['PropertyID'] )
                                            <?php --$i; break; ?>
                                        @endif
                                        <div class="input-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                     <label>{!! $properties[$i]['subprop'] !!}</label>
                                                  </span>
                                                <?php
                                                    $have = array_where($exist_props,
                                                            function($key,$val) use ($obj,$properties,$i){
                                                                return (($val['QuantityID'] == $obj['QuantityID']) &&
                                                                        ($val['SubPropertyID'] == $properties[$i]['SubPropertyID']));
                                                            }
                                                    );
                                                    if(!empty($have)){
                                                        $class = 'subproperty-was-set';
                                                        $old_val = number_format(($have[array_keys($have)[0]]['ExPrice']),2,'.','');
                                                    }else{
                                                        $old_val = $class = '';
                                                    }
                                                ?>
                                                <input type="number" name="subproperties[{!! $obj['QuantityID'] !!}][{!! $properties[$i]['PropertyID'] !!}][{!! $properties[$i]['SubPropertyID'] !!}]" value="{!! $old_val !!}" step="0.01" min="0.00" class="form-control {!! $class !!}">
                                            </div>
                                        </div>
                                    @endfor
                                </dev>
                            </div>
                        @endfor

                </div><br/>
                @endforeach
                <br/>
                <div class="col-sm-12">
                    <a href="{!! route('cms-add-product-step1') !!}" class="btn btn-default pull-left">Önceki Adım</a>
                    <input type="submit" value="Sonraki Adım" class="btn btn-info pull-right"/>
                </div>
                {!! Form::token(); !!}
            </form>
        </div>
    </div>
@stop