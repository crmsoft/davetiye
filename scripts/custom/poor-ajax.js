(function( ){
    'use strict';

    var httpRequest, clb = function(){}, data = '', url = '';//  string : '/products/detailed/post'

    var httpReq = {

        setCB: function (callback) {
            clb = callback;
        },

        setUrl: function (url) {
            this.url = url;
        },

        setData:function( data ){
            this.data = JSON.stringify(data);
        },

        send: function () {
            if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                httpRequest = new XMLHttpRequest();
            } else if (window.ActiveXObject) { // IE
                try {
                    httpRequest = new ActiveXObject("MSXML2.XMLHTTP.3.0")
                } catch (e) {
                    try {
                        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {
                    }
                }
            }

            window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');

            httpRequest.open('POST', window.location.origin + this.url, true);
            httpRequest.onreadystatechange = serverResponse;
            httpRequest.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
            httpRequest.setRequestHeader('Content-Type', 'application/json');
            httpRequest.send( this.data );
        }
    };

    function serverResponse(){
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                clb(JSON.parse(httpRequest.responseText));
            }else{
                clb( httpRequest.status );
            }
        }
    }

    return window.httpReq = httpReq;

}).call(this);