$(document).ready(function(){

    $('.container-hideable').bind('click', function( e ){
        e = e || window.event;
        if( e.target.nodeName.toLowerCase() === 'paper-hr' ){
            var childrens = $(this).parent().children();
            for(var i= 0,len=childrens.length;i<len;i++){
                $(childrens[i]).find('div.row').hide();
            }
            var target = $(this).find('div.row');
            if( target ){
                target.fadeIn();
            }
        }
    });

});

var supportedEls = {
    textInput   : "paper-input-decorator",
    fileInput   : "paper-input-file-decorator",
    toggleInput : "paper-toggle-button",
    selectInput : "select"
};

var errorMessages = {
    emptyInput : 'input is required!',
    wrongIndex : 'please select from the list.',
    fileError: 'File is not selected.',
    numsOnly: ' [Only numbers is acceptable]'
};

var NewEl = function () {

    // private functions & variables

    var el = null, request, that = this, overlay = null, _test = [];
    // public_html functions
    return {

        getTest:function(){
            console.log(overlay);
          return _test;
        },

        //main function
        init: function ( tag, over ) {
            request = tag;  that = this, overlay = over;
            _test.push( over );
            switch (tag){
                case supportedEls.textInput : {
                                                    el = document.createElement( tag );
                                                    el.setAttribute( 'error', errorMessages.emptyInput );
                                                    el.setAttribute( 'floatingLabel','' );
                                                    var child = document.createElement('input');
                                                        child.setAttribute('is', 'core-input');
                                                    el.appendChild( child );
                                                    break;
                                                }
                case supportedEls.fileInput : {
                                                    el = document.createElement( 'paper-input-decorator' );
                                                    el.setAttribute( 'error', errorMessages.fileError );
                                                    el.setAttribute( 'floatingLabel','' );
                                                    var child = document.createElement('input');
                                                    child.setAttribute('isFile',true);
                                                    child.addEventListener('focus', function( ){
                                                        fileSelector.init( this.parentNode.getAttribute('name'), this );
                                                        fileSelector.showPopUp();
                                                    }, false);
                                                    child.setAttribute('is', 'core-input');
                                                    el.appendChild( child );
                                                    break;
                }
                case supportedEls.toggleInput : {
                                                    el = document.createElement( 'div' );
                                                    el.setAttribute('left','');
                                                    el.setAttribute('horizontal','');
                                                    el.setAttribute('layout','');
                                                    el.className = 'radio-btn';

                                                var chTitle = document.createElement('div');
                                                    chTitle.innerHTML = 'STATUS';
                                                    chTitle.setAttribute('flex','');

                                                    el.appendChild( chTitle );

                                                var child = document.createElement( tag );
                                                    child.className = 'green';
                                                    child.checked = true;

                                                    el.appendChild( child );

                                                    break;
                }
                case supportedEls.selectInput:{

                        el = document.createElement( tag );
                        el.addEventListener( 'mousedown',function(){ if(this.options.length>6){ this.size=4; } }, false );
                        el.addEventListener( 'blur',function(){ this.size = 0; }, false );
                        el.addEventListener( 'change',function(){ this.size = 0; }, false );

                    break;
                    }
                default : el = document.createElement( 'div' );
            }
        },

        makeError:function( errorText ){
            var outer = document.createElement('div'), inner = document.createElement('div'), icon = document.createElement('core-icon');
                outer.setAttribute('class','error');
                outer.setAttribute('layout','');
                outer.setAttribute('horizontal','');
                outer.setAttribute('center','');
                inner.setAttribute('class','error.blade-text');
                inner.setAttribute('role','alert');
                inner.setAttribute('flex','');
                inner.setAttribute('auto','');
                icon.setAttribute('class','error.blade-icon');
                icon.setAttribute('icon','warning');
                icon.setAttribute('aria-label','warning');
                icon.setAttribute('role','img');

            inner.innerHTML = errorText;

            outer.appendChild(inner);
            outer.appendChild(icon);

            return outer;
        },

        showSelecError:function( target ){
            var index = target.selectedIndex, classes = target.classList, parent = target.parentNode;
            var pos = this.nodeIndex( parent, target );
            if(index){
                if( classes.contains('on_error') ){
                    var after = parent.childNodes[ (pos+1) ];
                    if( after.getAttribute('class') === 'error' ) {
                        parent.removeChild( after );
                        target.style.marginBottom = '8px';
                        classes.remove('on_error');
                    }
                }
            }else{
                if( ! classes.contains('on_error') ){
                    classes.add('on_error');
                    var div = this.makeError( errorMessages.wrongIndex );
                    target.style.marginBottom = '0';
                    div.style.marginBottom = '8px';
                    parent.insertBefore( div, parent.childNodes[ (pos+1) ] );
                }
            }
        },

        nodeIndex:function( parent, node ){
            var list = parent.childNodes;
            for( var i = 0; i < list.length; i++ ){
                if( list[i] === node )
                    return i;
            }
            return -1;
        },

        setFieldName:function( name, table ){
            if( request === supportedEls.toggleInput ){
                el.querySelector( request ).setAttribute( 'name', name );
            }else if( request === supportedEls.selectInput ){
                el.setAttribute( 'name', name );
                el.setAttribute( 'table', table );
            }else{
                el.setAttribute( 'name', name );
            }
        },

        setDefaultVal: function( data ){

            switch( request ){
                case supportedEls.textInput : {
                    var target = el.querySelector('input');
                        target.value = data;
                    break;
                }
                case supportedEls.toggleInput : {
                    var target = el.querySelector( request );
                        target.checked = data;
                    break;
                }
                case supportedEls.selectInput : {

                    if( data instanceof Array){
                        for( var i = 0; i < data.length; i++ ) {
                            var opt = document.createElement('option');

                            opt.value = i;
                            opt.text = data[i];

                            el.appendChild(opt);
                        }
                    }else if( data instanceof Object){
                        this.loadSelectOptions( el, data );
                    }
                    break;
                }
            }

        },

        setPattern:function( pattern ){
            if(supportedEls.textInput === request){
                var g = el.querySelector('input');
                if(g){
                    el.setAttribute( 'error', el.getAttribute('error') + errorMessages.numsOnly );
                    g.setAttribute( 'pattern', pattern );
                }
            }
        },

        loadSelectOptions:function( target, data ){
            if( data.fields ){
                $.ajax({
                    url: window.location.origin+'/rest/post/table',
                    method: 'POST',
                    data:{ "table": target.getAttribute('table'),
                            "fields": data.fields,
                            "where": data.where ? data.where : ''}
                })
                    .success(function( res ){
                        if( res.error ){
                            console.log( res.error );
                        }else{
                            res = JSON.parse( res );
                            this.fillSelect( target, res, data.fields );
                        }
                    }.bind(this))
                    .error(function(r,e){
                        console.dir( r,e );
                    });
            }else{
                console.log( 'Not a valid options for select input.' );
            }
        },

        fillSelect: function( parent, data, fields ){

            var label = parent.firstChild;
            label.setAttribute('selected','selected');
            parent.innerHTML = '';
            parent.appendChild( label );

            for( var i = 0; i < data.length; i++ ) {
                var opt = document.createElement('option');

                opt.setAttribute('class','option-valid');
                opt.value = data[i][ fields[1] ];
                opt.text  = data[i][ fields[0] ];

                parent.appendChild(opt);
            }
        },

        setLabel: function( lbl ){

            if( !lbl ) {
                return;
            }

            if( request === supportedEls.textInput || request === supportedEls.fileInput ) {
                el.label = lbl;
            }

            if( request === supportedEls.toggleInput ) {
                el.querySelector('div').innerHTML = lbl;
            }

            if( request === supportedEls.selectInput ){
                var opt = document.createElement( 'option' );
                opt.text = lbl;
                opt.setAttribute('disabled','disabled');
                opt.setAttribute('selected','selected');
                el.appendChild( opt );
            }
        },

        setRequired: function(){
          var r = el.querySelector('input');
            if( r ){
                r.setAttribute('required','');
            }
        },
        
        getElement: function(){
            return el;
        }

    };

}();