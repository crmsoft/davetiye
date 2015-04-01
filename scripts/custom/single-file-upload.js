$(document).ready(function(){
    var current = null;
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize:2,
        method: 'post',
        autoProcessQueue: true,
        thumbnailWidth:"200",
        headers : { 'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content') },
        maxFiles: 1,
        sending:function( a,b,frm ){
            frm.append( 'relation', current.getAttribute('data-rel') );
        },
        success: function( file, response, eProgress ){
            if( response === 'ok' ){
                alert('Uploaded ok');
                $('#fileChooser').modal('toggle');
                this.removeAllFiles();
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
                    thumbnailElement.src = dataUrl; var that = this;
                    thumbnailElement.addEventListener('click',function(){ that.removeFile( file ); });
                    current.src = dataUrl;
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
        current = event.target;
        $('#fileChooser').modal();
    });

    $('#spinner1').spinner();

});