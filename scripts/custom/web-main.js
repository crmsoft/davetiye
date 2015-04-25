// emulate localStorage global var if old engine is case...
if (!window.localStorage) {
    Object.defineProperty(window, "localStorage", new (function () {
        var aKeys = [], oStorage = {};
        Object.defineProperty(oStorage, "getItem", {
            value: function (sKey) { return sKey ? this[sKey] : null; },
            writable: false,
            configurable: false,
            enumerable: false
        });
        Object.defineProperty(oStorage, "key", {
            value: function (nKeyId) { return aKeys[nKeyId]; },
            writable: false,
            configurable: false,
            enumerable: false
        });
        Object.defineProperty(oStorage, "setItem", {
            value: function (sKey, sValue) {
                if(!sKey) { return; }
                document.cookie = escape(sKey) + "=" + escape(sValue) + "; expires=Tue, 19 Jan 2038 03:14:07 GMT; path=/";
            },
            writable: false,
            configurable: false,
            enumerable: false
        });
        Object.defineProperty(oStorage, "length", {
            get: function () { return aKeys.length; },
            configurable: false,
            enumerable: false
        });
        Object.defineProperty(oStorage, "removeItem", {
            value: function (sKey) {
                if(!sKey) { return; }
                document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
            },
            writable: false,
            configurable: false,
            enumerable: false
        });
        this.get = function () {
            var iThisIndx;
            for (var sKey in oStorage) {
                iThisIndx = aKeys.indexOf(sKey);
                if (iThisIndx === -1) { oStorage.setItem(sKey, oStorage[sKey]); }
                else { aKeys.splice(iThisIndx, 1); }
                delete oStorage[sKey];
            }
            for (aKeys; aKeys.length > 0; aKeys.splice(0, 1)) { oStorage.removeItem(aKeys[0]); }
            for (var aCouple, iKey, nIdx = 0, aCouples = document.cookie.split(/\s*;\s*/); nIdx < aCouples.length; nIdx++) {
                aCouple = aCouples[nIdx].split(/\s*=\s*/);
                if (aCouple.length > 1) {
                    oStorage[iKey = unescape(aCouple[0])] = unescape(aCouple[1]);
                    aKeys.push(iKey);
                }
            }
            return oStorage;
        };
        this.configurable = false;
        this.enumerable = true;
    })());
}

// global foos
(function( win  /* this */ ) {

    this.round = function(value, decimals) {return Number(Math.round(value+'e'+decimals)+'e-'+decimals);};

    this.roundCheck = function( sity ){
        sity = round(sity,2);

        var tmp = sity.toString().split('.');
        if(tmp[2] && tmp[2].length > 2){
            console.log(tmp[2].substring(0, 2));
            tmp = Number( tmp[1] +'.'+ tmp[2].substring(0, 2) );
            return tmp;
        }

        return sity;
    };

    this.getTimeStamp = function(delimiter) {
        var today = new Date(), del = delimiter || '.';
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        var h = today.getHours(),
            m = today.getMinutes(),
            s = today.getSeconds();

        if (h < 10) {
            h = '0' + h;
        }
        if (m < 10) {
            m = '0' + m;
        }
        if (s < 10) {
            s = '0' + s;
        }
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }

        return yyyy + del + mm + del + dd + ' ' + h + ':' + m + ':' + s;
    };

    this.addEvent = function(event, box, handler) {
        if (box.addEventListener) {
            // DOM2 standard
            box.addEventListener(event, handler, false);
        }
        else if (box.attachEvent) {
            // IE fallback
            box.attachEvent("on" + event, handler);
        }
        else {
            // DOM0 fallback
            box["on" + event] = handler;
        }
    };

    this.getId = function (id, attr) {
        var el = document.getElementById(id);
        if (!el) {
            return null;
        }
        if (attr) {
            return el.getAttribute(attr);
        } else {
            return el;
        }
    };

    this.setId = function(id, attr, val){
        if(!(id instanceof Object)){
            id = getId(id);
        }
        if (!id) {
            return null;
        }
        if (attr) {
            if (attr.toLowerCase() === 'class') {
                if(val instanceof Array){
                    for(var i=val.length-1;i>=0;i--){
                        id.classList.add(val[i]);
                    }
                }else{
                    id.classList.add(val);
                }
            } else {
                id.setAttribute(attr, val);
            }return id;
        } else {
            id.innerHTML = val;
            return id;
        }
    };

    this.toggle = function( me, state ){
        if(state !== undefined){
            me.style.display = state ? 'block':'none';
        }else {
            (me.style.display === 'none' || me.style.display === '') ? me.style.display = 'block' : me.style.display = 'none';
        }
    };

    this.dismiss = function(){
        var dr = getId('dropdown');
        if(dr) { toggle(dr,false); }
    };

    this.placeNear = function( me, he ){
        var rect = he.getBoundingClientRect();
        me.style.position = 'absolute';
        me.style.top = (rect.top+he.offsetHeight)+'px';
        me.style.left = (he.offsetLeft+me.offsetWidth)+'px';
    };

    this._create = function(tag,cnt){
        if(!cnt) {
            return document.createElement(tag);
        }else{
            var res = [];
            for(var i = parseInt(cnt);i>0;i--){
                res.push( document.createElement(tag) );
            }
            return res;
        }
    };

    this._remove = function( parent, child ){
        return parent.removeChild(child);
    };

    this._ajax = function( opt ){
        var _default = {
            method:'POST',
            url: location.href,
            data:{'data':4},
            handler: function(res){console.log(res);},
            csrf: document.getElementsByName('csrf-token')[0].getAttribute('content')
        };  opt = opt || _default;

        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("MSXML2.XMLHTTP.3.0")
            }catch (e) {
                try { httpRequest = new ActiveXObject("Microsoft.XMLHTTP"); }catch (e) {}
            }
        }if(!httpRequest){
            console.error('no http request allowed');
            return false;
         }

        httpRequest.open(opt.method ? _default.method : opt.method, opt.url, true);
        httpRequest.setRequestHeader('X-CSRF-TOKEN', opt.csrf);
        httpRequest.setRequestHeader('Content-Type', 'application/json');
        httpRequest.send( JSON.stringify(opt.data) );
        return httpRequest;
    }

}).call(this);

(function(){
   'use strict';

    function domReady(){
        updateBox();
        addEvent('click',getId('box_wrapper'),shopCart);
        addEvent('click',getId('dropdown'),function(e){ e.stopPropagation(); });
        addEvent('click',document,dismiss);
        addEvent('submit', getId('check_out') || getId('check_out_box'), function(e){
            var json = _create('input');
            setId(json,'value', localStorage.getItem('shopping_box').toString());
            setId(json,'name','box');
            setId(json,'type','hidden');
            this.appendChild(json);
            return false;
        });
    }

    addEvent('DOMContentLoaded', document, domReady);
})();

function shopCart(e){
    var modal = getId('dropdown');
    placeNear( modal, getId('box_wrapper') );
    toggle(modal);
    e.stopPropagation();
}

function updateBox(){

    var box = localStorage.getItem('shopping_box');
    if(box) {
        var added = JSON.parse(box), total = 0, table = setId(_create('table'),'class',['table','dr-box']), th = _create('th',4), tr = _create('tr'), thead= _create('thead'), ln = added.length, dr = getId('dropdown');
        if(!ln) {
            setId(dr, false, '<h4>Sepetinizde henüz hiç bir ürün bulunmuyor</h4>');
        }else{
            tr.appendChild(setId(th[0],false,'Ürün'));
            tr.appendChild(setId(th[1],false,'Fiyat'));
            tr.appendChild(setId(th[3],false,'Adet'));
            tr.appendChild(setId(th[2],false,'Kaldır'));
            table.appendChild(thead.appendChild(tr));
            setId(dr,false,'');
        }
        getId('box_total').innerHTML = ln;
        for( var i=0;i<ln;i++ ){
            var tr = _create('tr'), td = _create('td',5);
            tr.appendChild(setId(td[0],false,added[i].name));
            tr.appendChild(setId(td[1],false,added[i].predicted));
            tr.appendChild(setId(td[4],false,added[i].subpr[added[i].subpr.length-1]));
            tr.appendChild(setId(td[3],false,'⊗'));
            //tr.appendChild(setId(td[2],false,added[i].subpr[0]));
            setId(td[3],'class','close-icon');
            setId(td[3],'class','pointer');
            total += parseFloat(added[i].predicted);
            !function(td,arr,obj) {
                addEvent('click', td, function(){
                    arr.splice( arr.indexOf( obj ), 1 );
                    localStorage.setItem('shopping_box',JSON.stringify(arr));
                    updateBox();
                });
            }(td[3],added,added[i]);
            table.appendChild(tr);
        }
        if(total){
            table.appendChild(getSummary(total));
        }
        dr.appendChild(table);
    }

    function getSummary( total ){
        var l = _create('td',3), tt = _create('tr'),
            frm = setId(setId(setId(_create('form'),'id','check_out_box'),'method','post'),'action','/check/bucket'),
            hd = _create('input',2);
        setId(tt,'class','shooping-box-last');
        setId(hd[0],'value',document.getElementsByName('csrf-token')[0].content);
        setId(hd[1],'value',localStorage.getItem('shopping_box'));
        frm.appendChild(setId(setId(hd[0],'type','hidden'),'name','_token'));
        frm.appendChild(setId(setId(hd[1],'type','hidden'),'name','box'));
        tt.appendChild(setId(l[1],false,'Genel toplam :'));
        tt.appendChild(setId(l[2],false,roundCheck(total)));
        setId(l[0],'colspan','2');
        var sbmt = setId(_create('button'),'class',['btn', 'btn-hemen-al', 'btn-box-add']);
        setId(sbmt,false,'Tamamla'); frm.appendChild(sbmt);
        l[0].appendChild(frm);
        tt.appendChild(l[0]);
        return tt;
    }

}
