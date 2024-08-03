$('#update_status').submit(function(e){

    id=$('#id').val();
    e.preventDefault();
    jQuery.ajax({
        url:'/admin/update_status',
        data:jQuery('#update_status').serialize(),
        type: 'post',
        success:function(result){
    
   console.log(result);
          if(result.status=='error'){
            Swal.fire({
                title: "Warning",
                text: result.msg,
                icon: "warning"
              });
              setTimeout(function() {
                window.location.href='/admin/order_details/'+id;
            }, 3000);
            
          }else{
            Swal.fire({
              title: "Success",
              text: result.msg,
              icon: "success"
            });
            setTimeout(function() {
              window.location.href='/admin/order_details/'+id;
          }, 3000);
           
          }
         

         
         
        }
      })
})