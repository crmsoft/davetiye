/**
 * Created by ahtem on 13.02.2015.
 */

function roundCheck( sity ){
    sity = round(sity,2);

    var tmp = sity.toString().split('.');
    console.log(tmp);
    if(tmp[2] && tmp[2].length > 2){
        tmp = Number( tmp[1] +'.'+ tmp[2].substring(0, 2) );
        console.log(tmp);
        return tmp;
    }

    return sity;
}

function round(value, decimals) {return Number(Math.round(value+'e'+decimals)+'e-'+decimals);}

(function(){
'use strict';

    var box_old_val = 0, groups = {}, httpRequest, addedSubProps = [], userTicks = [];
    // jquery.document.ready === 'DOMContentLoaded'
    function docReady(){
        resolveStartPage();
        getData();
        imageGallery();
    }

    /////////////------------server---request------------////////////////
    function getData(){
        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            console.log('ActiveXObject');
            try {
                httpRequest = new ActiveXObject("MSXML2.XMLHTTP.3.0")
            }catch (e) {
                try { httpRequest = new ActiveXObject("Microsoft.XMLHTTP"); }catch (e) {}
            }
        }

        if(!httpRequest){
           // appStop();
        }

        window.location.origin =  window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');

        httpRequest.open('POST', window.location.origin + '/products/detailed/post', true);
        httpRequest.onreadystatechange = handleResponse;
        httpRequest.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
        httpRequest.send();
    }
    ///////////////////-------end----request--------//////////////////
    ///////////////////-------handle----request-------////////////////
    function handleResponse() {
        if (httpRequest.readyState === 4) {
            if (httpRequest.status === 200) {
                var result = JSON.parse( httpRequest.responseText );

                if(!result){
                    //appStop();
                }
                resolveResponse( result );
            } else {
                console.log( 'status : ', httpRequest.status );
                alert('There was a problem with the request.');
                //appStop();
            }
        }
    }

    function resolveResponse( data ){
        groups = sortByQuantity(data);
        var quantities = Object.keys(groups);

        if( quantities.length > 1 ){

            var quantitySelect = document.getElementById('adet');
            if(!quantitySelect){
                alert("We are sorry, but we encountered some problems and need reload this page!");
                window.location.reload();
            }
            addSelectEvents("change", quantitySelect, handleQuantityChange );
            quantitySelect.disabled = false;
        }
        console.log('done');
    }

    function sortByQuantity(data){

        var divider = {}, prev = 0, tmp = [];
        for(var i= 0,ln=data.length;i<ln;i++){
            if( prev !==  data[i].adet){
                prev = data[i].adet;
                if(!divider[prev]){
                    divider[prev] = [];
                }
            }
            divider[prev].push(data[i]);
        }
        return divider;
    }

    function handleQuantityChange( e ){
        var content = document.getElementById('product_subproperties');
        var rows = content.querySelectorAll('tr'), parent = content.querySelector('tbody');

        if( rows && parent ) {
            var qu = e.target;
            var selected = groups[qu.options[qu.selectedIndex].text];

            if(selected) { userTicks = [];
                for (var i = 1, ln = rows.length; i < (ln - 1); i++) {

                    var user_prev = rows[i].getElementsByTagName('select')[0];

                    userTicks.push( user_prev.options[ user_prev.selectedIndex].getAttribute('data-rel') );

                    parent.removeChild(rows[i]);
                    var new_data = getSubProps( selected );

                    if( new_data.length === 2 ) {
                        var asd = 'alt_oz'+ i, tr = document.createElement('tr'), tdF = document.createElement('td'), tdS = document.createElement('td');

                        new_data[0].setAttribute('id',asd);
                        tdF.appendChild(new_data[0]);
                        tdS.innerHTML = '<label for='+asd+'>'+new_data[1]+'</label>';
                        tr.appendChild(tdS);
                        tr.appendChild(tdF);

                        parent.insertBefore(tr, rows[ln - 1]);
                    }
                }
                resolveStartPage( qu );
            }else{
                alert('Unexpected error');
            }
        }
        addedSubProps = [];
    }

    function getSubProps( obj ){
        var select = document.createElement('select'), name;
        for(var i= 0,ln=obj.length;i<ln;i++){
            if( addedSubProps.indexOf( obj[i].oz ) === -1 ){
                addedSubProps.push(obj[i].oz);
                name = obj[i].oz;
                break;
            }
        }

        if(name) {
            var option, last = addedSubProps[addedSubProps.length-1];

            for (; i < ln; i++) {
                if( last === obj[i].oz ){
                    option = document.createElement('option');
                    option.text = obj[i].ao;
                    option.value = obj[i].il;
                    option.setAttribute('data-rel', obj[i].aoid );
                    select.appendChild( option );
                }
            }
            return [ select, name ];
        }else{
            return [ ];
        }
    }

    ///////////////////-------end----handle-------////////////////
    function appStop(){
      //  window.location =  window.location.origin + '/abort';
    }

    function focusHandler( e ){
        box_old_val = parseFloat(e.target[e.target.selectedIndex].value);
    }

    function changeHandler( e ){
        var price = document.getElementById('product_total_price');
        var curr = parseFloat(price.innerHTML), new_val = parseFloat( e.target[e.target.selectedIndex].value );

            curr -= box_old_val;
            curr += new_val;
            box_old_val = new_val;
            price.innerHTML = roundCheck(curr);
    }

    function addSelectEvents( event, box, handler ){
        if (box.addEventListener) {
            // DOM2 standard
            box.addEventListener(event, handler, false);
        }
        else if (box.attachEvent) {
            // IE fallback
            box.attachEvent("on"+event, handler);
        }
        else {
            // DOM0 fallback
            box["on"+event] = handler;
        }
    }

    function resolveStartPage( oto ){
        var content = document.getElementById('product_subproperties');
        var subprops = content.querySelectorAll('select');

        var total = 0, smallest = 0, smallest_index = 0;
        for(var i=0,ln=subprops.length;i<(ln-1);i++){

        addSelectEvents("focus",subprops[i], focusHandler);
        addSelectEvents("change",subprops[i], changeHandler);

            var opt = subprops[i].options;
            smallest = opt[0].value; smallest_index = 0;
            var j= 0,l=opt.length, tmp_2 = -1;
            for (; j < l; j++) {
                tmp_2 = userTicks.indexOf( opt[j].getAttribute('data-rel') );
                if( tmp_2 !== -1){
                    smallest_index = opt[j].index;
                    smallest = opt[j].value; break;
                }
                if (parseFloat(opt[j].value) < parseFloat(smallest)) {
                    smallest_index = opt[j].index;
                    smallest = opt[j].value;
                }
            }

            subprops[i].options[smallest_index].selected = true;
            total += parseFloat(smallest);
        }
        // empty first start
        if(Object.keys(groups).length === 0){
            opt = subprops[ln-1].options;
            smallest = opt[0].value;
            var j= 0,l=opt.length;

            for (; j < l; j++) {
                if (parseFloat(opt[j].value) < parseFloat(smallest)) {
                    subprops[ln-1].options[ opt[j].index ].selected = true;
                    break;
                }
            }
        }

        total = (total + parseFloat(subprops[ln-1].options[subprops[ln-1].selectedIndex].value));
        setId( 'product_total_price', roundCheck(total) );
    }

    function setId( selector, val ){
        return document.getElementById(selector).innerHTML = val;
    }

    function write( msg, type ){
        if(type){
            console.log( msg );
        }else{
            console.error(msg);
        }
    }


    // start watcher - main
    addSelectEvents('DOMContentLoaded', document, docReady);

    function imageGallery(){

        $("#demo").lightSlider({
            gallery: false,
            item: 1,
            thumbItem: 2,
            maxSlide:2,
            mode: 'slide',
            slideMargin: 5,
            thumbWidth: 25,
            currentPagerPosition: 'center',
            onSliderLoad: function (plugin) {
                plugin.lightGallery();
            }
        });

    }

})();