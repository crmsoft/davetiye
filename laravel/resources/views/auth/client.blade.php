@extends('layouts.web')

@section('content')

    <div class="row" style="background: #F7F5F6;">
        <section class="col-md-6 col-md-offset-3 client-login">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <header class="login-header">
                <h1 id="login_title">Üye Girişi</h1>
                <strong>100% Güvenli Alışveriş</strong>
            </header>
            <section>
                <ul class="checkout-options">
                    <li class="active" rel="tab1">
                        <input type="radio" id="option1" data-tab="1" checked name="client-option"/>
                        <label for="option1">Giriş yap</label>
                    </li>
                    <li rel="tab2">
                        <input type="radio" id="option2" data-tab="2" name="client-option"/>
                        <label for="option2">Üye ol</label>
                    </li>
                    <li rel="tab3">
                        <input type="radio" id="option3" data-tab="3" name="client-option"/>
                        <label for="option3">Üye olmadan devam et</label>
                    </li>
                </ul>
                <div class="tab_container">

                    <div id="tab1" class="tab-con">
                        <form action="{{ route('web-look-up-user') }}" method="post" class="col-md-12">
                            <div class="control-group">
                                <label for="" class="control-label">E-posta</label>
                                <div class="controls">
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control required"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="" class="control-label">Şifre</label>
                                <div class="controls">
                                    <input type="password" name="password" class="form-control required"/>
                                </div>
                            </div>
                            {!! Form::token() !!}
                            <br/>
                            <div class="pull-right">
                                <input type="submit" class="btn btn-hemen-al" value="Giriş" style="margin: 0" /><br/><br/>
                                <a href="" class="pull-right" ><small>Şifremi unuttum</small></a>
                            </div>
                        </form>
                    </div>

                    <div id="tab2" class="tab-con hidden">
                        <form method="post" action="{{ route('web-register-client') }}">
                            <div class="control-group col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="">Adınız</label>
                                        <div class="controls">
                                            <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" required="required"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label" for="">Soyadınız</label>
                                        <div class="controls">
                                            <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" required="required"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group col-md-12">
                                <label for="">E-posta</label>
                                <div class="controls">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required="required"/>
                                </div>
                            </div>
                            <div class="control-group col-md-12">
                                <label for="">Şifre</label>
                                <div class="controls">
                                    <input type="password" name="password" class="form-control" required="required"/>
                                </div>
                            </div>
                            <div class="control-group col-md-12">
                                <label for="">Şifre Tekrar</label>
                                <div class="controls">
                                    <input type="password" name="password_confirmation" class="form-control" required="required"/>
                                </div>
                            </div>
                            {!! Form::token() !!}
                            <div class="pull-right">
                                <br/>
                                <input type="submit" class="btn btn-hemen-al" style="margin: 0" value="Üye ol" />
                            </div>
                        </form>
                    </div>
                    <div id="tab3" class="tab-con hidden">
                        Tab 3
                    </div>
                </div>
            </section>
        </section>
    </div>
    <script>

        !function() {
            'use strict';

            addEvent('DOMContentLoaded', document, start_options);

            function start_options() {
                var opt = document.querySelectorAll('input[name=client-option]');
                for (var i = 0, ln = opt.length; i < ln; i++) {
                    addEvent('change', opt[i], switch_tab);
                }
                if(localStorage.hasOwnProperty('client_login_last_action')){
                    var tab = localStorage.getItem('client_login_last_action');
                    setId(opt[tab-1],'checked','checked');
                    updateHeader( tab );
                }
            }

            function hideAll() {
                var opt = document.querySelectorAll('.tab-con');
                for (var i = 0, ln = opt.length; i < ln; i++) {
                    setId(opt[i], 'class', 'hidden');
                }
            }

            function switch_tab(e) {
                var tab = getId(e.target, 'data-tab');
                if (tab) {
                    localStorage.setItem('client_login_last_action',tab);
                    updateHeader( tab );
                } else {
                    console.error('Can not switch tab');
                }
            }

            function updateHeader( index ){
                hideAll();
                switch(parseInt(index)){
                    case 1: setId('login_title',false,'Üye Girişi'); removeClass('tab' + index, 'hidden'); break;
                    case 2: setId('login_title',false,'Üye ol'); removeClass('tab' + index, 'hidden'); break;
                    case 3: break;
                    default : return false;
                }return true;
            }

        }();

    </script>
@stop