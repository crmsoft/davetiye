@extends('layouts.web')

@section('content')
    @include('layouts.side-bar')
    <div class="content1">
        <div class="alt-menu">
            <ul>
                <li class="act">Sepetim</li>
                <li>Adres ve Fatura Bilgileri</li>
                <li>Baskı Bilgileri</li>
                <li>İşlem Sonucu</li>
            </ul>
        </div>
        <div class="sepet-box">
            <table width="702" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th width="329" align="left" valign="middle">ÜRÜN</th>
                    <th width="129" align="left" valign="middle">ADET</th>
                    <th width="116" align="left" valign="middle">BİRİM FİYAT</th>
                    <th width="128" align="left" valign="middle">TOPLAM FİYAT</th>
                </tr>
                @foreach($products as $key=>$pr)
                    <tr>
                        <td align="left" valign="middle">{{$pr}}<br />
                          <span>
                             @foreach($properties['ao'][$key+1] as $c=>$p)
                                  {{ $properties['oz'][$key+1][$c] }} {{': '}}{{ mb_strtolower($p) }},
                             @endforeach
                          </span>
                        </td>
                        <td align="left" valign="middle">
                            <span class="busy-span"></span>
                            <select name="select" id="select">
                                @foreach($quantity['q'][$key] as $q)
                                    <option {{ $quantity['s'][$key] == $q['Title'] ? 'selected="selected"':NULL }} value="{{$key.'_'}}{{ $q['QuantityID'] }}">{{ $q['Title'] }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td align="left" valign="middle"><p>30 TL</p></td>
                        <td align="left" valign="middle"><p>{{ number_format($prices[$key],2) }} TL</p></td>
                    </tr>
                @endforeach
                <tr>
                    <td align="left" valign="middle">Tasarım Satın Al <input type="checkbox" name="checkbox" id="checkbox" />
                        ( + 50 TL)</td>
                    <td align="left" valign="middle">İnidirim Kodu</td>
                    <td colspan="2" align="left" valign="middle">
                        <input type="text" name="textfield" id="textfield" class="input1" />
                        <a href="#" class="btn-uygula"> Uygula</a></td>
                </tr>
                <tr>
                    <td align="left" valign="middle"><a href="urunler.html" class="btn-alisveris"> ALIŞVERİŞE DÖN</a></td>
                    <td colspan="2" align="left" valign="middle"><h4>GENEL TOPLAM</h4></td>
                    <td align="left" valign="middle"><h5>1280 TL</h5></td>
                </tr>
            </table>

        </div>
        <form action="{{ route('user-check-out-step-1') }}" method="POST">
            <div class="form-box fl">
                <h2>Sipariş Bilgileri</h2>
                <div class="form-box-content">
                    <table width="310" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="92" align="left" valign="middle">Ad Soyad</td>
                            <td width="218" align="left" valign="top"><input type="text" required="required" name="order_first_last" id="order_first_last" class="input2" /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">E-Posta</td>
                            <td align="left" valign="top">
                                <input required="required" type="email" name="order_email" id="order_email" class="input2" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">GSM</td>
                            <td align="left" valign="top">
                                <input required="required" type="text" name="order_phone" id="order_phone" class="input2" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-box fr">
                <h2>Ödeme Bilgileri</h2>
                <div class="form-box-content">
                    <table width="310" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="56" colspan="2" align="left" valign="top">
                                <input type="radio" id="paying_is_credit_cart" name="paying_is_credit_cart" value="credit_cart" id="RadioGroup1_0" checked/>
                                <label for="paying_is_credit_cart">Kredi Kartı İle Ödeme</label>
                                <input type="radio" id="paying_is_transfer" name="paying_is_credit_cart" value="money_transfer" id="RadioGroup1_1" />
                                <label for="paying_is_transfer">Havale / EFT</label>
                            </td>
                        </tr>
                        <tr>
                            <td width="143" align="left" valign="top">Taksit</td>
                            <td width="167" align="left" valign="middle">
                                <select name="select2" id="select2" name="paying_taksit">
                                    <option value="0" selected="selected">Tek Çekim</option>
                                    <option value="1">2</option>
                                    <option value="2">3</option>
                                    <option value="3">4</option>
                                    <option value="4">5</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">Kart Sahibi</td>
                            <td align="left" valign="middle"><input required="required" type="text" name="paying_first_last" id="textfield2" class="input3" /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">Kart Numarası</td>
                            <td align="left" valign="middle"><input required="required" type="text" name="paying_cart_16" id="textfield2" class="input3" /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"> Son Kullanma Tarihi</td>
                            <td align="left" valign="middle">
                                <input required="required" type="text" name="paying_cart_last_m" id="textfield2" class="input4" />
                                <input required="required" type="text" name="paying_cart_last_y" id="textfield2" class="input4" />
                                <span>(AA/YYYY)</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">CVC2</td>
                            <td align="left" valign="middle">
                                <input required="required" type="text" name="paying_cart_security" id="textfield2" class="input4" />
                                <span>Kartınızın arkasındaki son 3 rakam</span>
                            </td>
                        </tr>
                        <tr>
                            <td height="46" colspan="2" align="left" valign="middle">
                                <input type="checkbox" name="paying_agree_rules" id="paying_agree_rules" required="required " />
                                <label for="paying_agree_rules">Mesafeli Satış Sözleşmesini Onaylıyorum </label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right" valign="top">
                                <input type="submit" class="btn-odeme" value="ÖDEME YAP" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <input type="hidden" class="hidden" name="_token" value="{{ csrf_token() }}" />
        </form>
        <div class="form-info fl">
            {!! Html::image("/img/decor/ico-canlidestek.png", 'Canli Destek', ['width'=>"57", 'height'=>"72", 'class'=>"fl mr_20"]) !!}
            Ödeme ile ilgili sorunlarınızı<br />
            hafta içi mesai saatlerinde <br />
            Canlı Destek hattımıza veya <a href="mailto:destek@taksitlereklam.com">destek@taksitlereklam.com</a>'a <br />
            bildirebilirsiniz operatörlerimiz size en kısa sürede yanıt verecektir.
        </div>
    </div>

@stop