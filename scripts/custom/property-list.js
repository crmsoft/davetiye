$(document).ready(function(){

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
        var title = row.children('td:eq(0)').text().trim();
        var order = row.children('td:eq(1)').text().trim();
        var status = row.children('td:eq(2)').find('input:checkbox').attr('checked');
        var $modal = $('#createOrUpdate');
        var $form = $modal.find('form');
        $form.append( '<input name="ID" type="hidden" value="'+row.data('origin')+'" />' );
        $form.find('input[name="Title"]').val(title);
        $form.find('input[name="OrderNo"]').val(order);
        $form.find('input[name="Status"]').bootstrapSwitch('state',status);
        $modal.modal();
    });

});