(function(){
    'use strict';

    var target = null, previousValue = null;
    function domReady(){
        var qu = document.getElementsByName('select');
        for(var i= 0,ln=qu.length;i<ln;i++){
            addEvent('change',qu[i],handleChange);
            addEvent('focus',qu[i],getOldValue);
        }
    }

    function getOldValue(e){
        previousValue = e.target.value;
    }

    function handleChange( e ){
        target = e.target;
        toggle(target,false);
        toggle(target.parentNode.querySelector('.busy-span'),true);
        var _data = target.value;
        var http = _ajax({
                        url: window.location.origin + '/products/by/quantity/props',
                        method:'POST',
                        csrf: document.getElementsByName('csrf-token')[0].getAttribute('content'),
                        data: { 'data':_data }
                    });
        http.onreadystatechange = handleResponse;
        e.preventDefault();
        e.stopPropagation();
    }

    function handleResponse() {
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                var result = JSON.parse( httpRequest.responseText );
                if(result.res instanceof Array){
                    if(result.res.length == 2){
                        var tds = target.parentNode.parentNode.querySelectorAll('td');
                        setId(tds[tds.length-1],false,'');
                        tds[tds.length-1].appendChild(setId(_create('p'),false,result.res[0] + ' TL'));
                        updateStorage(result.res);
                    }
                }
            } else {
                toggle(target,false);
                toggle(target.parentNode.querySelector('.busy-span'),true);
                console.log( 'status : ', httpRequest.status );
                alert('There was a problem with the request.');
            }
        }
    }

    function updateStorage( arr ){
        var tmp = JSON.parse(localStorage.getItem('shopping_box'));
        var ln = tmp.length,i=0;
        for(;i<ln;i++){
            if(tmp[i].id === arr[1]){
                tmp[i].predicted = arr[0];
                tmp[i].subpr[ tmp[i].subpr.length - 1 ] = target.options[target.options.selectedIndex].innerHTML;
                localStorage.setItem('shopping_box',JSON.stringify(tmp));
                break;
            }
        }
        updateBox();
        setTimeout(function(){
            toggle(target.parentNode.querySelector('.busy-span'),false);
            toggle(target,true);
        },100);
    }

    addEvent('DOMContentLoaded', document, domReady);
}).call(this);