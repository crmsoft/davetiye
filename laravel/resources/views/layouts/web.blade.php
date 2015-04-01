<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{!! 'Taksitle Reklam' !!}</title>

    {!! Html::style('/plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('css/app.css') !!}
    <script>
        window.location.origin =  window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
    </script>
</head>
<body>
<div class="header">
    <div class="wrap">
        <a href="{!! route('web-get-index') !!}"><div class="logo"></div></a>
        <div class="top-user">
            <div class="top-sepet"><p>Sepetinizde 0 ürün bulunmaktadır.</p></div>
        </div>
        <div class="src-box">
            <input name="ara" type="text" value="Ürün Arama" />
            <a href="#" class="btn-src"> Ara</a>
        </div>
        <div class="siparis-box">
            <input name="siparis-no" type="text" value="Sipariş No" />
            <a href="#" class="btn-siparis"> Sipariş Takip</a>
        </div>
        <div class="cleaner"></div>
        <div class="menu">
            <ul>
                <a href="{!! route('web-get-index') !!}"><li class=" {!! (Route::currentRouteName() == 'web-get-index') ? 'act':'' !!}" >ANA SAYFA</li></a>
                <a href="hakkimizda.html"><li>HAKKIMIZDA</li></a>
                <a href="{!! route('web-get-subcategory') !!}"><li class=" {!! (Route::currentRouteName() == 'web-get-subcategory') ? 'act':'' !!}">ÜRÜNLER</li></a>
                <a href="#"><li>REFERANSLAR</li></a>
                <a href="#"><li>TASARIM SATIN AL</li></a>
                <a href="iletisim.html"><li>İLETİŞİM</li></a>
            </ul>
        </div>
    </div>
</div>
<div class="cleaner"></div>
<div class="wrap">
    @yield('content')
</div>
<div class="info">
    <div class="wrap"><img src="/img/decor/img-info.jpg" width="962" height="33" /></div>
</div>
<div class="cleaner"></div>
<div class="wrap">
    <div class="bankalar"></div>
    <div class="footer">
        <ul class="f1">
            <h6>%100 Güvenli Alışveriş</h6>
            <li>Sitemizden güvenle alışveriş yapabilirisiniz<br />
                </li>
        </ul>
        <ul class="f2">
            <h6>Site Hakında</h6>
            <li>Hakkımızda</li>
            <li>Kullanıcı Sözleşmesi</li>
            <li>Gizlilik Bildirimi</li>
        </ul>
        <ul class="f3">
            <h6>Müşteri Hizmetleri</h6>
            <li>İletişim</li>
            <li>Teslimat</li>
            <li>İade</li>
            <li>Ödeme Seçenekleri</li>
            <li>Sıkça Sorulan Sorular</li>
        </ul>
        <ul class="f4">
            <h6>Ürünler</h6>
            <li>Kurumsal
            <li>Çantalı Katalog</li>
            <li>Kartvizit</li>
            <li>Dosya</li>
            <li>Antetli</li>
            <li>Broşür</li>
            <li>Matbuu Evrak</li>
            <li>Takvim</li>
            <li>Zarf</li>
            <li>Fatura-İrsaliye</li>
            <li>Çıkartma Etiket</li>
            <li>Bloknot</li>
            <li>Ajanda</li>
            <li>Magnet</li>
            <li>Oto Kokusu</li>
            <li>Yıllık</li>
            <li>İnsört</li>
            <li>Kuşe Sticker</li>
            <li>Karton Kartela</li>
            <li>Karton Çanta</li>
            <li>Davetiye</li>
            <li>El İlanı</li>
            <li>Katalog</li>
        </ul>
    </div>
</div>
</body>
</html>
