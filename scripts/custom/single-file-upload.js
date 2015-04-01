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

    $('#createOrUpdate').on('hidden.bs.modal',function(){
        var $form = $('#createOrUpdate').find('form');
        $form.find('input[name="Title"]').val('');
        $form.find('input[name="OrderNo"]').val('1');
        $form.find('input[name="Status"]').bootstrapSwitch('state',false);
        if( $('#createOrUpdate').find('input[name="ID"]') ){
            $('#createOrUpdate').find('input[name="ID"]').remove();
        }
    });

    $('#createOrUpdate form').submit(function(){
        var checkbox= $(this).find('input[name="Status"]').bootstrapSwitch('state') ? '1':'0';
        $(this).append( '<input name="Status" type="hidden" value="'+checkbox+'" />' );
    });

    $('.btn-refresh').click(function(){
       var row = $(this).closest('tr');
       var title = row.children('td:eq(1)').text().trim();
       var order = row.children('td:eq(2)').text().trim();
        var status = row.children('td:eq(3)').find('input:checkbox').attr('checked');
        var $modal = $('#createOrUpdate');
        var $form = $modal.find('form');
        $form.append( '<input name="ID" type="hidden" value="'+row.data('origin')+'" />' );
        $form.find('input[name="Title"]').val(title);
        $form.find('input[name="OrderNo"]').val(order);
        $form.find('input[name="Status"]').bootstrapSwitch('state',status);
        $modal.modal();
    });

});