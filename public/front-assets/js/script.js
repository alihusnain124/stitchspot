function toggleElement() {
    var element = document.getElementById("nav-items-js");
    if (element.classList.contains("nav-items")) {
       
            element.classList.remove("nav-items");
            element.classList.add("visible");
       
    } else {
       
            element.classList.add("nav-items");
            element.classList.remove("visible");
       
    }
}


jQuery.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
  }
});


jQuery('#reg_form').submit(function(e){


  
        e.preventDefault();

        var from=$('#reg_form')[0];
        var data=new FormData(from);
        jQuery('.field_error').html('');
        jQuery.ajax({
          url:'/registration_process',
          data:data,
          type: 'post',
          processData:false,
          contentType:false,
  
          success:function(result){
      
  
            if(result.error){
             
              jQuery.each(result.error,function(key,val){
                jQuery('#'+key+'_error').html(val);
                
              })
      
            }else{
              Swal.fire({
                title: "Success",
                text: result.msg,
                icon: "success"
              });
              jQuery('#reg_form').trigger('reset');

              if(result.status=='update'){
                setTimeout(function() {
                  window.location.href='/profile/'+result.id;
              }, 3000);
              }
            }
           
           
          }
        })
       
      });
      
      
      jQuery('#login_form').submit(function(e){
        e.preventDefault();
        jQuery('.login_error').html('');
        jQuery.ajax({
          url:'/login_process',
          data:jQuery('#login_form').serialize(),
          type: 'post',
          success:function(result){
      
         
            if(result.error){
              // jQuery('.login_error').html(result.error);

              Swal.fire({
                title: "Oops...",
                text: result.error,
                icon: "warning"
              });
              
            }else{

           
              Swal.fire({
                title: "Success",
                text: result.msg,
                icon: "success"
              });
              setTimeout(function() {
                window.location.href='/';
            }, 3000);
             
            }
           

           
           
          }
        })
       
      });


      function updateCart(id,val,token,attr_id){
        var product_id=id;
        var product_qty=val;
        var csrf_token=token;
        var product_attr_id=attr_id;
       
        $.ajax({
          url:'/update_cart',
          data:{id:product_id,qty:product_qty,_token:csrf_token,product_attr_id:product_attr_id},
          type:'post',
          success:function(result){
            console.log(result);
            if(result.status==true){
              Swal.fire({
                title: "Success",
                text: result.message,
                icon: "success"
              });
              setTimeout(function() {
                location.reload();
            }, 2000);
             
            }else{
              Swal.fire({
                title: "Error",
                text: result.message,
                icon: "error"
              });
              setTimeout(function() {
                location.reload();
            }, 2000);
            }
          }
        })
      }


  function deleteCart(id,attr_id,token){
    var product_id=id;
    var product_attr_id=attr_id;
    var csrf_token=token;

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#bb2124",
      cancelButtonColor: "##808080",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url:'/delete_cart',
          data:{id:product_id,attr_id,_token:csrf_token},
          type:'post',
          success:function(result){
           
            if(result.status==true){
              Swal.fire({
                title: "Deleted!",
                text: result.message,
                icon: "success"
              });
             
              setTimeout(function() {
                location.reload();
            }, 2000);
            }
          }
        })

       
      }
    });

   
  }

  function add_to_cart(id,size,color,qty,token){

   
    var product_id=id;
    var product_size=size;
    var product_color=color;
    var product_qty=qty;
    var csrf_token=token;

  

    $.ajax({
      url:'/add_to_cart_product',
      data:{id:product_id,size:product_size,color:product_color,qty:product_qty,_token:csrf_token},
      type:'post',
      success:function(result){
       
        if(result.status=='true'){

       
        Swal.fire({
          title: "Success",
          text: result.message,
          icon: "success"
        });
        setTimeout(function() {
          location.reload();
      }, 2000);

       }else{

        Swal.fire({
          title: "Oops..",
          text: result.message,
          icon: "warning"
        });

       }
        
      

      }
    })

  }


  $('#order_form').submit(function(e){
    e.preventDefault();
    var selectedMethod = $("input[name='payment_method']:checked").val();
   

    if(selectedMethod=='Gateway'){

      $.ajax({
        url:'/stripe',
        data:jQuery('#order_form').serialize(),
        type: 'get',
        success:function(result){
               document.open();
                document.write(result);
                document.close();
                
                // Update browser history
                history.replaceState(null, '', '/stripe');
        
        }

        
      })
    }else{

    jQuery('.login_error').html('');
    $.ajax({
      url:'/order_process',
      data:jQuery('#order_form').serialize(),
      type: 'get',
      success:function(result){
        if(result.status=='Success'){
          Swal.fire({
            title: "Success",
            text: result.msg,
            icon: "success"
          });
          setTimeout(function() {
            window.location.href='/order_placed';
        }, 2000);
         
        }else{
          Swal.fire({
            title: "Oops..",
            text: result.msg,
            icon: "warning"
          });
        }
       
      }
    })

    }


   

   
  });

  $('#contact_form').submit(function(e){
    e.preventDefault();
    $.ajax({
      url:'/contact_process',
      data:jQuery('#contact_form').serialize(),
      type: 'get',
      success:function(result){
       
        if(result.status=='Success'){
          Swal.fire({
            title: "Success",
            text: result.msg,
            icon: "success"
          });
        
         $('#contact_form').trigger('reset');
         
        }else{
          Swal.fire({
            title: "Error",
            text: result.msg,
            icon: "error"
          });
        ;
          $('#contact_form').trigger('reset');

        }
       
      }
    })
   
  });

  function addToCart(id){
   
    var id=id;
    $.ajax({
      url:'/add_to_cart',
      data:{id:id},
      type:'post',
      success:function(result){


       
        if(result.status==2){
          Swal.fire({
            title: 'Success',
            text: result.msg,
            icon: "success"
          });
          setTimeout(function(){
            location.reload();
          },2000)
      
        
        }else{

          Swal.fire({
            title: 'Oops...',
            text: result.msg,
            icon: "warning"
          });
        }
      }
    })

   
  }


  $('#rating_form').submit(function(e){
    id=$('#id').val();
    e.preventDefault();
    $.ajax({
      url:'/rating',
      data:jQuery('#rating_form').serialize(),
      type: 'post',
      success:function(result){

       console.log(result);
       
        if(result.status=='success'){
          Swal.fire({
            title: "Success",
            text: result.msg,
            icon: "success"
          });
        
         $('#rating_form').trigger('reset');

         setTimeout(function() {
          window.location.href='/product-details/'+id;
      }, 3000);
         
        }else{
          Swal.fire({
            title: "Error",
            text: result.msg,
            icon: "error"
          });
        ;
          $('#rating_form').trigger('reset');

          setTimeout(function() {
            window.location.href='/product-details/'+id;
        }, 3000);
        }
       
      }
    })
   
  });



  $('#review_form').submit(function(e){
    //id=$('#user_id').val();
    // id=$('#service_id').val();
    e.preventDefault();
    $.ajax({
      url:'/review',
      data:jQuery('#review_form').serialize(),
      type: 'post',
      success:function(result){

        if(result.status=='success'){
          Swal.fire({
            title: "Success",
            text: result.msg,
            icon: "success"
          });
        
         $('#rating_form').trigger('reset');

         setTimeout(function() {
          window.location.href='/profile/'+result.user_id;
      }, 3000);
         
        }else{
          Swal.fire({
            title: "Error",
            text: result.msg,
            icon: "error"
          });
        ;
          $('#review_form').trigger('reset');

          setTimeout(function() {
            window.location.href='/user_review/'+id;
        }, 3000);
        }
       
       }
    })
   
  });

function user_order(id,user_id){
  id=id;
  user_id=user_id;
   Swal.fire({
    title: "Order Details",
    html: '<input id="prod_order_id" class="swal2-input" placeholder="Product Order Id">'+
    '<input id="price" class="swal2-input" placeholder="Price">'+
    '<input id="time" class="swal2-input" placeholder="Time">',
    
    inputAttributes: {
      autocapitalize: "off"
    },  
    showCancelButton: true,
    confirmButtonColor: "#bb2124",
    confirmButtonText: "Submit",
    showLoaderOnConfirm: true,
    preConfirm: async () => {
     
      product_order_id=$('#prod_order_id').val();
      price=$('#price').val();
      time=$('#time').val();
      id=id;
      user_id=user_id;

     

      $.ajax({
        url:'/user_order',
        data:{product_order_id:product_order_id,price:price,time:time,id:id,user_id:user_id},
        type:'post',
        success:function(result){

        
          if(result.status=='success'){
            Swal.fire({
              title: "Success",
              text: result.msg,
              icon: "success"
            });
        
          }else{
            Swal.fire({
              title: "Error",
              text: result.msg,
              icon: "error"
            });
            
          }
        }
      })


     
    }
  });
}
     

function action(id,action){

  id=id;
  action=action;


  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#bb2124",
    cancelButtonColor: "#808080",
    confirmButtonText: "Yes, Accepted"
  }).then((result) => {
    if (result.isConfirmed) {

      $.ajax({
        url:'/action',
        data:{id:id,action:action},
        type:'post',
        success:function(result){
    
       
          if(result.status=='success'){
            Swal.fire({
              title: "Success",
              text: result.msg,
              icon: "success"
            });
            setTimeout(function() {
              window.location.href='/customers_dashboard';
          }, 3000);
          }else{
            Swal.fire({
              title: "Error",
              text: result.msg,
              icon: "error"
            });
          }
        }
      })

     
    }
  });
  
 
}


function complete(id,action){
  id=id;
  action=action;


  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#bb2124",
    cancelButtonColor: "#808080",
    confirmButtonText: "Yes,Completed"
  }).then((result) => {
    if (result.isConfirmed) {

     
  $.ajax({
    url:'/complete',
    data:{id:id,action:action},
    type:'post',
    success:function(result){

    
      if(result.status=='success'){
        Swal.fire({
          title: "Success",
          text: result.msg,
          icon: "success"
        });
        setTimeout(function() {
          window.location.href='/customers_dashboard';
      }, 3000);
      }else{
        Swal.fire({
          title: "Error",
          text: result.msg,
          icon: "error"
        });
      }
    }
  })

     
    }
  });


  
}



////color 

$('#color').change(function(){
  var color = $(this).val(); 
  $('#color_val').val(color);
});

///size

$('#size').change(function(){
  var size = $(this).val(); 
  $('#size_val').val(size);
  $('#change_form').submit();
});


////account no 


function account(){
  val=$('#account_no').val();
  $('#account').val(val);
}

$('#account_no').change(function(){
  var account = $(this).val(); 
  $('#account').val(account);
  $('#account_form').submit();
});

