$(document).ready(function(){
    var current = null, thumbSrc = null, zone = null, is_gallery = ($('.gallery').length > 0) ? true : false;
    Dropzone.options.myDZ = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize:2,
        method: 'post',
        acceptedFiles: 'image/*',
        autoProcessQueue: true,
        headers : { 'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content') },
        maxFiles: is_gallery ? 10 : 1,
        init:function(){
          zone = this;
        },
        sending:function( a,b,frm ){
            frm.append( 'relation', current.getAttribute('data-rel') );
        },
        success: function( file, response, eProgress ){
            if( response.indexOf('.') !== -1 ){
                if(current) {
                    current.src = thumbSrc;
                    dzPushFile( {name: response, size: 2048, status: 'success', accepted: true } );
                    this.removeFile(file);
                }
            }else{
                alert('Failed');
            }
        },
        thumbnail: function(file, dataUrl) {
            var thumbnailElement, _i, _len, _ref;
            if (file.previewElement) {
                file.previewElement.classList.remove("dz-file-preview");
                _ref = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    thumbnailElement = _ref[_i];
                    thumbnailElement.alt = file.name;
                    thumbnailElement.src = dataUrl;
                    thumbSrc = dataUrl;
                }

                if(is_gallery) {
                    var removeButton = Dropzone.createElement("<span class='remove-added-file-dz'>&#8855;</span>");
                    var _this = this;
                    removeButton.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (confirm('Sil ?')) {
                            handleRemoveButton(_this, file);
                        }
                    });
                    file.previewElement.appendChild(removeButton);
                }

                return setTimeout(((function(_this) {
                    return function() {
                        return file.previewElement.classList.add("dz-image-preview");
                    };
                })(this)), 1);
            }
        },
        maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        }
    };

    $('img.sub-category-thumb').on('click', function( event ){
        if(event.target.classList.contains('gallery')) {
            httpReq.setCB(galleryData);
            httpReq.setUrl('/cms/post/request/table');
            httpReq.setData({column:'ProductID',request_table:'T_ProductGallery',value:event.target.getAttribute('data-rel').split('-')[1]});
            httpReq.send();
        }
        current = event.target;
        $('#fileChooser').modal();
    });

    function handleRemoveButton( dz, file ){
        httpReq.setCB(function(rs) {
            if (rs.status === '200'){
                dz.removeFile(file);
            }
        });
        httpReq.setUrl('/cms/update/form');
        httpReq.setData({
            table_to_insert: 'ProductGallery',
            row_id: 'ImageName-'+file.name,
            Status: 0
        });
        httpReq.send();
    }

    function galleryData( res ){
        zone.removeAllFiles( true );
        for( var i= 0,ln=res.length;i<ln;i++ ) {
            dzPushFile({
                name: res[i].ImageName,
                size: 2048,
                status: 'success',
                accepted: true
            });
        }
    }

    function dzPushFile( mockFile ){
        zone.emit("addedfile", mockFile);
        zone.emit("thumbnail", mockFile, '/img/thumbs/' + mockFile.name);
        zone.files.push(mockFile);
    }

});