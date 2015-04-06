<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>Taksitle Reklam - {!! Session::get('title') !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"
          rel="stylesheet" type="text/css" />
    <script>
        window.paceOptions = {
            ajax: {
                trackMethods: ['GET', 'POST']
            }
        };
    </script>
    {!! Html::style('plugins/pace/themes/pace-theme-minimal.css') !!}
    {!! Html::script('plugins/pace/pace.min.js') !!}

    {!! Html::style('plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('plugins/bootstrap-switch/css/bootstrap-switch.min.css') !!}
    {!! Html::style('plugins/uniform/css/uniform.default.css') !!}
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    {!! Html::style('plugins/gritter/css/jquery.gritter.css') !!}
    {!! Html::style('plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
    {!! Html::style('plugins/fullcalendar/fullcalendar/fullcalendar.css') !!}
    {!! Html::style('plugins/jqvmap/jqvmap/jqvmap.css') !!}
    {!! Html::style('plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css') !!}
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN THEME STYLES -->
    {!! Html::style('css/style-metronic.css') !!}
    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/style-responsive.css') !!}
    {!! Html::style('css/plugins.css') !!}
    {!! Html::style('css/pages/tasks.css', array( 'id'=>'style_color' )) !!}
    {!! Html::style('css/themes/default.css') !!}
    {!! Html::style('css/print.css', array('media'=>'print')) !!}
    {!! Html::style('css/custom/custom.css') !!}
    {!! Html::style('bower_components/datatables/media/css/jquery.dataTables.min.css') !!}
    <!-- END THEME STYLES -->
    <!-- POLYMER COMPONENTS -->
    <script type="text/javascript">
        var public_path = "{!! URL::to('/') !!}";
        window.location.origin =  window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
    </script>
    <!-- END POLYMER -->
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="index.html">
            {!! Html::image('img/decor/logo.png','logo',array('height'=>'26px')) !!}
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            {!! Html::image('img/menu-toggler.png') !!}
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                   data-hover="dropdown" data-close-others="true">
                    {!! Html::image('img/avatar1_small.jpg') !!}
                    <span class="username">Hesabım </span><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('web-get-index') }}"><i class="fa fa-home"></i> Anasayfaya Git</a></li>
                    <li>
                        <a href="javascript:;" id="trigger_fullscreen">
                            <i class="fa fa-arrows"></i> Tam Ekran
                        </a>
                    </li>
                    <li><a href="{!!  route('log-out-user') !!}"><i class="fa fa-key"></i> Çıkış </a></li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler hidden-phone">
                    </div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <form class="sidebar-search" action="" method="POST">
                        <div class="form-container">
                            <div class="input-box">
                                <a href="javascript:;" class="remove"></a>
                                <input type="text" placeholder="Search..." />
                                <input type="button" class="submit" value=" " />
                            </div>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li class="start {!! Route::currentRouteName() == 'cms-index' ? 'active':'' !!}">
                    <a href="{!! route('cms-index') !!}">
                        <i class="fa fa-shopping-cart"></i><span class="title">Dashboard
                        </span><span class="selected "></span>
                    </a>
                </li>
                <li class="{!! (Route::currentRouteName() == 'cms-list-product' || Route::currentRouteName() == 'cms-add-product-step1' || Route::currentRouteName() == 'cms-add-product-step2' || Route::currentRouteName() == 'cms-add-product') ? 'active open':'' !!}">
                    <a href="javascript:;">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="title">Ürünler</span>
                        </span><span class="selected "></span>
                        <span class="arrow {!! (Route::currentRouteName() == 'cms-list-product' || Route::currentRouteName() == 'cms-add-product') ? 'open':'' !!}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{!! Route::currentRouteName() == 'cms-list-product' ? 'active':'' !!}">
                            <a href="{!! route('cms-list-product') !!}">
                                <i class="fa fa-barcode"></i>Listele
                            </a>
                        </li>
                        <li class="{!! (Route::currentRouteName() == 'cms-add-product' || Route::currentRouteName() == 'cms-add-product-step1' || Route::currentRouteName() == 'cms-add-product-step2') ? 'active' : '' !!}">
                            <a href="{!! route('cms-add-product') !!}">
                                <i class="fa fa-try"></i>Yeni Ekle
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="start {!! Route::currentRouteName() == 'cms-list-sub-category' ? 'active':'' !!}">
                    <a href="{!! route('cms-list-sub-category') !!}">
                        <i class="fa fa-shopping-cart"></i><span class="title"> Alt Kategoriler
                        </span><span class="selected "></span>
                    </a>
                </li>
                <li class="start {!! Route::currentRouteName() == 'cms-list-property' ? 'active':'' !!}">
                    <a href="{!! route('cms-list-property') !!}">
                        <i class="fa fa-shopping-cart"></i><span class="title"> Özellikler
                        </span><span class="selected "></span>
                    </a>
                </li>
                <li class="start {!! Route::currentRouteName() == 'cms-list-sub-property' ? 'active':'' !!}">
                    <a href="{!! route('cms-list-sub-property') !!}">
                        <i class="fa fa-shopping-cart"></i><span class="title">Alt Özellikler
                        </span><span class="selected "></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">
            @yield('content')
        </div>
    </div>
</div>
<div class="footer">
    <div class="footer-inner">
        2015 &copy; Taksitle Reklam.
    </div>
    <div class="footer-tools">
        <span class="go-top"><i class="fa fa-angle-up"></i></span>
    </div>
</div>

{!! Html::script('plugins/jcrop/js/jquery.min.js') !!}
{!! Html::script('plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') !!}
{!! Html::script('plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}
{!! Html::script('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}
{!! Html::script('plugins/jquery.blockui.min.js') !!}
{!! Html::script('plugins/jquery.cokie.min.js') !!}
{!! Html::script('plugins/uniform/jquery.uniform.min.js') !!}
{!! Html::script('plugins/fullcalendar/fullcalendar/fullcalendar.min.js') !!}
{!! Html::script('plugins/jquery.sparkline.min.js') !!}
{!! Html::script('plugins/fuelux/js/spinner.min.js') !!}

{!! HTML::script('scripts/core/app.js') !!}
{!! Html::script('scripts/custom/index.js') !!}
{!! Html::script('scripts/custom/tasks.js') !!}

<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        App.init(); // initlayout and core plugins
        Index.init();
    });
</script>

    {!! Html::script('scripts/custom/poor-ajax.js') !!}

    @if(Route::currentRouteName() == 'cms-list-sub-category' || Route::currentRouteName() == 'cms-list-product')
        {!! Html::style('bower_components/dropzone/dist/min/basic.min.css') !!}
        {!! Html::style('bower_components/dropzone/dist/min/dropzone.min.css') !!}
        {!! Html::script('bower_components/dropzone/dist/min/dropzone.min.js') !!}
        {!! Html::script('scripts/custom/single-file-upload.js') !!}
    @endif
    @if(Route::currentRouteName() == 'cms-list-sub-category')
        {!! Html::script('scripts/custom/sub-category-list.js') !!}
    @endif
    @if(Route::currentRouteName() == 'cms-list-property')
        {!! Html::script('scripts/custom/property-list.js') !!}
    @endif
    @if(Route::currentRouteName() == 'cms-list-sub-property')
        {!! Html::script('scripts/custom/sub-property-list.js') !!}
    @endif

    {!! Html::script('scripts/custom/active-passiv.js') !!}

</body>
</html>