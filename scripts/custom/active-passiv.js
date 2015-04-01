$(document).ready(function(){
    $('#active_pop_up_form').bootstrapSwitch();
    $('.make-switch').on('switchChange.bootstrapSwitch', function(e,s){
        var target = e.target.parentNode.parentNode.parentNode.getAttribute('data-rel');
        console.log(  );
        if(httpReq && target ){
            httpReq.setUrl('/cms/update/form');
            httpReq.setCB(function( response ){ console.log(response); });
            httpReq.setData({ table_to_insert:target.split('-')[0],row_id:target.split('-')[1],Status: (e.target.checked ? '1':'0') });
            httpReq.send();
        }else{
            console.log('AJAX set up failed');
        }
    });
});