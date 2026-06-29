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
            SS.toast('success', 'Success', result.msg);
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
        SS.toast('warning', 'Oops...', result.error);
      }else{
        SS.toast('success', 'Success', result.msg);
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
        SS.toast('success', 'Updated', result.message);
        setTimeout(function() {
          location.reload();
        }, 2000);
      }else{
        SS.toast('error', 'Error', result.message);
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

  SS.confirm({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    confirmText: 'Yes, delete it!',
    cancelText: 'Cancel'
  }).then(function(confirmed){
    if(confirmed){
      $.ajax({
        url:'/delete_cart',
        data:{id:product_id,attr_id:product_attr_id,_token:csrf_token},
        type:'post',
        success:function(result){
          if(result.status==true){
            SS.toast('success', 'Deleted!', result.message);
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
        SS.toast('success', 'Added to Cart', result.message);
        setTimeout(function() {
          location.reload();
        }, 2000);
      }else{
        SS.toast('warning', 'Oops..', result.message);
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
          SS.toast('success', 'Order Placed!', result.msg);
          setTimeout(function() {
            window.location.href='/order_placed';
          }, 2000);
        }else{
          SS.toast('warning', 'Oops..', result.msg);
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
        SS.toast('success', 'Message Sent!', result.msg);
        $('#contact_form').trigger('reset');
      }else{
        SS.toast('error', 'Error', result.msg);
        $('#contact_form').trigger('reset');
      }
    }
  })
});

function addToCart(id){
  $.ajax({
    url:'/add_to_cart',
    data:{id:id},
    type:'post',
    success:function(result){
      if(result.status==2){
        SS.toast('success', 'Added to Cart', result.msg);
        setTimeout(function(){
          location.reload();
        },2000)
      }else{
        SS.toast('warning', 'Oops...', result.msg);
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
        SS.toast('success', 'Review Submitted', result.msg);
        $('#rating_form').trigger('reset');
        setTimeout(function() {
          window.location.href='/product-details/'+id;
        }, 3000);
      }else{
        SS.toast('error', 'Error', result.msg);
        $('#rating_form').trigger('reset');
        setTimeout(function() {
          window.location.href='/product-details/'+id;
        }, 3000);
      }
    }
  })
});


$('#review_form').submit(function(e){
  e.preventDefault();
  $.ajax({
    url:'/review',
    data:jQuery('#review_form').serialize(),
    type: 'post',
    success:function(result){
      if(result.status=='success'){
        SS.toast('success', 'Review Submitted', result.msg);
        $('#rating_form').trigger('reset');
        setTimeout(function() {
          window.location.href='/profile/'+result.user_id;
        }, 3000);
      }else{
        SS.toast('error', 'Error', result.msg);
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
  SS.formModal({
    title: 'Order Details',
    fields: [
      { id: 'prod_order_id', placeholder: 'Product Order Id' },
      { id: 'price',         placeholder: 'Price' },
      { id: 'time',          placeholder: 'Time' }
    ],
    confirmText: 'Submit',
    cancelText: 'Cancel'
  }).then(function(res){
    if(res.confirmed){
      var product_order_id = res.values.prod_order_id;
      var price = res.values.price;
      var time  = res.values.time;
      $.ajax({
        url:'/user_order',
        data:{product_order_id:product_order_id,price:price,time:time,id:id,user_id:user_id},
        type:'post',
        success:function(result){
          if(result.status=='success'){
            SS.toast('success', 'Success', result.msg);
          }else{
            SS.toast('error', 'Error', result.msg);
          }
        }
      })
    }
  });
}


function action(id,action){
  id=id;
  action=action;

  SS.confirm({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    confirmText: 'Yes, Accept',
    cancelText: 'Cancel'
  }).then(function(confirmed){
    if(confirmed){
      $.ajax({
        url:'/action',
        data:{id:id,action:action},
        type:'post',
        success:function(result){
          if(result.status=='success'){
            SS.toast('success', 'Success', result.msg);
            setTimeout(function() {
              window.location.href='/customers_dashboard';
            }, 3000);
          }else{
            SS.toast('error', 'Error', result.msg);
          }
        }
      })
    }
  });
}


function complete(id,action){
  id=id;
  action=action;

  SS.confirm({
    title: 'Mark as Completed?',
    text: "You won't be able to revert this!",
    type: 'warning',
    confirmText: 'Yes, Complete',
    cancelText: 'Cancel'
  }).then(function(confirmed){
    if(confirmed){
      $.ajax({
        url:'/complete',
        data:{id:id,action:action},
        type:'post',
        success:function(result){
          if(result.status=='success'){
            SS.toast('success', 'Completed!', result.msg);
            setTimeout(function() {
              window.location.href='/customers_dashboard';
            }, 3000);
          }else{
            SS.toast('error', 'Error', result.msg);
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


function toggleWishlist(btn, productId) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var icon = btn.querySelector('i');

    $.ajax({
        url: '/wishlist/toggle',
        method: 'POST',
        data: { product_id: productId, _token: csrfToken },
        success: function(res) {
            if (res.status === 'added') {
                icon.className = 'fa-solid fa-heart text-[13px]';
                btn.classList.add('text-[#E63946]');
                btn.classList.remove('text-gray-400');
            } else if (res.status === 'removed') {
                icon.className = 'fa-regular fa-heart text-[13px]';
                btn.classList.remove('text-[#E63946]');
                btn.classList.add('text-gray-400');
            } else if (res.status === 'login') {
                SS.toast('warning', res.message, '', 3000);
            }
        }
    });
}
