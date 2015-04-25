(function(){
    'use strict';

    addEvent('DOMContentLoaded', document, domStart);

    function domStart(){

        addEvent('click',getId('add_to_box'),collectProductData);
        addEvent('click',getId('box_wrapper'),showUserBox);

    }

    function showUserBox(){
        var box = localStorage.getItem('shopping_box');
        if(!box){
            return false;
        }
        box = JSON.parse(box);
    }

    function collectProductData( e ){

        var txt = e.target.innerHTML;
        e.target.innerHTML = '';
        e.target.classList.add('busy-btn');

        var container = getId('product_subproperties'), res = { id: 'unique', date:'0000-00-00 00:00:00', name:'', product:0, subpr:[], predicted:0 };
        var cells = container.querySelectorAll('td');
        for( var i = 0,ln=cells.length;i<ln;i++ ){
            var select = cells[i].querySelector('select');
            if(select){
                var index = select.selectedIndex;
                var sbpr = select.options[index].getAttribute('data-rel');
                sbpr = sbpr ? sbpr : select.options[index].innerHTML;
                res.subpr.push(sbpr);
            }
        }
        res.id = Date.now();
        res.name = getId('product').innerHTML;
        res.date = getTimeStamp();
        res.predicted = getId('product_total_price').innerHTML;
        res.product = container.getAttribute('data-rel');
        if(localStorage.getItem( 'shopping_box' )){
            var arr = JSON.parse(localStorage.getItem( 'shopping_box' ));
            arr.push(res);
            localStorage.setItem( 'shopping_box', JSON.stringify( arr ) );
        }else{
            var arr = [];
            arr.push(res);
            localStorage.setItem( 'shopping_box', JSON.stringify(arr) );
        }

        setTimeout(function(){
            e.target.classList.remove('busy-btn');
            e.target.innerHTML = txt;
            updateBox();
        }.bind(e,txt), 450);

        return false;
    }

}).call(this);
