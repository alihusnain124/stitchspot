$('#update_status').submit(function(e){
    var id = $('#id').val();
    e.preventDefault();
    jQuery.ajax({
        url: '/admin/update_status',
        data: jQuery('#update_status').serialize(),
        type: 'post',
        success: function(result){
            if(result.status == 'error'){
                SS.toast('warning', 'Warning', result.msg);
            } else {
                SS.toast('success', 'Updated!', result.msg);
            }
            setTimeout(function(){
                window.location.href = '/admin/order_details/' + id;
            }, 2000);
        },
        error: function(){
            SS.toast('error', 'Error', 'Something went wrong. Please try again.');
        }
    });
});
