'use strict';

var fileSelector = function(){

    var currfile = null,
        fileStorage = {}, aImg, tag,
        sessionKey = null,
        element = null,
        passedOverlay = null,
        cropCoordinates = {w:50,h:50,x:0,y:0};

    return {

        init:function( key, over ){
            if ( !key ) {
                throw 'File Initialization is failed. Key is not available!';
            } else {
                sessionKey = key; tag = over.nodeName.toLowerCase()
                if( tag === 'img' ){
                    passedOverlay = over;
                }else{
                    passedOverlay = this.searchParent( over, 'core-overlay' );
                }
            }
        },

        searchParent:function findParentBySelector(elm, selector) {
            var cur = elm.parentNode;
            while(cur && !( cur.nodeName.toLowerCase() === 'core-overlay' )) { //keep going up until you find a match
                cur = cur.parentNode; //go up
            }
            return cur; //will return null if not found
        },

        createParts:function(){

            var body = document.createElement('div'),conf = document.createElement('div'),header = document.createElement('h1');
            var content = document.createElement('div'),file = document.createElement('input'),btnl = document.createElement('button'), btnr = document.createElement('button');

            body.setAttribute( 'class', 'popup-body' );
            conf.setAttribute( 'class', 'confirm' );
            content.setAttribute( 'class', 'content' );
            btnr.setAttribute( 'autofocus', '' );
            file.setAttribute( 'type', 'file' );
            file.setAttribute( 'accept', 'image/*' );

            btnl.innerHTML = 'Cancel';
            btnr.innerHTML = 'Confirm';
            header.innerHTML = 'Select Image';
            content.innerHTML = '<h3>Drag and Drop or just click to select!</h3>';

            btnr.addEventListener('click',function(){
                this.handleConfirm();
            }.bind(this),false);

            btnl.addEventListener('click',function(){
                this.destroyPopUp();
            }.bind( this ), false);

            window.onkeyup = function( e ){
                e = e || window.e; var keyCode = e.which || e.keyCode;
                if( keyCode === 27 && passedOverlay ){
                    this.destroyPopUp();
                }
            }.bind(this);

            file.addEventListener('change', function( e ){
                this.handleFiles( e.target.files[0] );
            }.bind(this), false);

            file.addEventListener('drop', function(e){
                e.stopPropagation();
                e.preventDefault();

                var dt = e.dataTransfer;
                this.handleFiles( dt.files[0] );
            }.bind(this), false);

            file.addEventListener('dragenter', function(e){e.stopPropagation();e.preventDefault();},false);
            file.addEventListener('dragover', function(e){e.stopPropagation();e.preventDefault();},false);

            conf.appendChild( header );
            conf.appendChild( file );
            conf.appendChild( content );
            conf.appendChild( btnr );
            conf.appendChild( btnl );
            body.appendChild( conf );

            element = body;
        },

        handleConfirm:function(){

            if( !currfile ){
                if( confirm('No file is selected,\nleave this window ?') ){
                    this.destroyPopUp();
                }
                return true;
            }

            var isTarget;
            if( tag === 'img' ){
                this.setThumbPreview();
                isTarget = passedOverlay;
            }else{
                isTarget = passedOverlay.querySelectorAll('paper-input-decorator');
            }

            for( var i = 0; i<isTarget.length; i++ ){
                if( isTarget[i].getAttribute('name') === sessionKey ){
                    isTarget = isTarget[i].querySelector('input');
                    break;
                }
            }

            if( tag === 'input' || tag === 'img' ) {
                isTarget.value = currfile.name;
                fileStorage[sessionKey] = {file: currfile, crop: cropCoordinates};
                this.destroyPopUp();
            }
        },

        setThumbPreview:function(){
            passedOverlay.src = aImg.src;
        },

        handleFiles : function( file ) {
            if (file) {

                var imageType = /image.*/;

                if (!file.type.match(imageType)) {
                    alert( 'file type is incorrect!' );
                    return ;
                }

                var reader = new FileReader(), container = document.querySelector('.popup-body').querySelector('.content');
                aImg = new Image();
                container.querySelector('h3').innerHTML = 'Processing!';

                aImg.src = window.URL.createObjectURL( file );
                aImg.setAttribute( 'id', 'cropbox' );

                reader.addEventListener('loadend', function(e){

                    var ratio = 0;
                    aImg.src = e.target.result;

                        cropCoordinates.w = aImg.width / 2;         cropCoordinates.h = aImg.height / 2;
                        cropCoordinates.x = cropCoordinates.w / 2;  cropCoordinates.y = cropCoordinates.h / 2;

                    if( (screen.width*0.75) < aImg.width || (screen.height *0.70) < aImg.height ){
                        ratio = Math.min((screen.width*0.75) / aImg.width, (screen.height *0.70) / aImg.height);
                    }else{
                        ratio = 1;
                    }

                    aImg.width *= ratio; aImg.height *= ratio;

                    container.style.height = (aImg.height+2)+'px';container.style.width = (aImg.width+2)+'px';
                    container.parentNode.style.height = (aImg.height+80)+'px';container.parentNode.style.width = (aImg.width+30)+'px';
                    container.innerHTML = '';
                    container.appendChild( aImg );
                    $(aImg).Jcrop({
                        aspectRatio: 1,
                        onSelect: function( c ){
                            cropCoordinates.h = c.h/ratio;
                            cropCoordinates.w = c.w/ratio;
                            cropCoordinates.x = c.x/ratio;
                            cropCoordinates.y = c.y/ratio;
                        }
                    });

                } ); reader.readAsDataURL(file); currfile = file;
            }else{
                console.log( 'file is null' );
            }
        },

        showPopUp:function( ){
            passedOverlay.opened = !passedOverlay.opened;
            this.createParts();
            document.querySelector('body').appendChild( element );
        },

        destroyPopUp:function(){
          var target = document.querySelector('.popup-body');
            if( tag !== 'img' ) {
                passedOverlay.opened = !passedOverlay.opened;
                passedOverlay.style.top = '35px';
            }
            currfile = passedOverlay = null;
          return target && target.parentNode && target.parentNode.removeChild(target);
        },

        getFile:function(key){
            if (!(key && fileStorage[key])) {
                throw new Error('Data with given key is not found in register!');
            } else {
                return fileStorage[key];
            }
        }

    };

}();