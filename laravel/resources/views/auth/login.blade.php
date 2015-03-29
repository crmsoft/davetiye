<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Taksitle Admin Panel</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"
          rel="stylesheet" type="text/css" />
    {!! Html::style( 'plugins/font-awesome/css/font-awesome.min.css' ) !!}
    {!! Html::style( 'plugins/bootstrap/css/bootstrap.min.css' ) !!}
    {!! Html::style( 'plugins/uniform/css/uniform.default.css' ) !!}
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! Html::style('plugins/select2/select2.css') !!}
    {!! Html::style('plugins/select2/select2-metronic.css') !!}
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    {!! Html::style('css/style-metronic.css') !!}
    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/style-responsive.css') !!}
    {!! Html::style('css/plugins.css') !!}
    {!! Html::style('css/themes/default.css', array( 'id'=>'style_color' ) ) !!}
    {!! Html::style('css/pages/login.css') !!}
    {!! Html::style('css/custom.css') !!}
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="#some-page">
        {!! Html::image('img/decor/logo.png','Taksitle Reklam') !!}
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="post-sign-in" method="post">
        <h3 class="form-title">
            Lütfen Sisteme Giriş Yapın
        </h3>
        <div class="has-error">
            @if(count($errors) > 0)
                <div class="alert alert-danger display-show">
                    <button class="close" data-close="alert"></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert">
            </button>
            <span>Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">
                Kullanıcı Adı</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="E-mail"
                       name="email" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">
                Şifre</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                       placeholder="Şifre" name="password" />
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green pull-right">
                Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
        {!! Form::token() !!}
    </form>
    <!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    2015 &copy; Taksitle Reklam - Admin Giriş.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
{!! Html::script('plugins/respond.min.js') !!}
{!! Html::script('plugins/excanvas.min.js') !!}
<![endif]-->
{!! Html::script('plugins/jquery-1.10.2.min.js') !!}
{!! Html::script('plugins/jquery-migrate-1.2.1.min.js') !!}
{!! Html::script('plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}
{!! Html::script('plugins/jquery-slimscroll/jquery.slimscroll.min.js') !!}
{!! Html::script('plugins/jquery.blockui.min.js') !!}
{!! Html::script('plugins/jquery.cokie.min.js') !!}
{!! Html::script('plugins/uniform/jquery.uniform.min.js') !!}
{!! Html::script('plugins/backstretch/jquery.backstretch.min.js') !!}
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
{!! Html::script('plugins/jquery-validation/dist/jquery.validate.min.js') !!}
{!! Html::script('plugins/select2/select2.min.js') !!}
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
{!! Html::script('scripts/core/app.js') !!}
{!! Html::script('scripts/custom/login.js') !!}
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        App.init();
        Login.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>