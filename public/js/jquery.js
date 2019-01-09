 const rockpos_check = 'pos_confirm';
 const online_check = 'normal-confirm';



$(document).ready(function(){
  $("select").material_select();
  $(".button-collapse").sideNav();
  $('.datepicker').pickadate({
    selectMonths:true,
    selectYear:15,
    closeOnSelect:true
   });

   $('ul.tabs').tabs({
     swipeable : true,
     responsiveThreshold : 1920
   });


   //1.new order ajax call
   $('#get-new-order').click(function(e){
      e.preventDefault();
      let url = window.location.href+'neworder';

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    var mycall =  $.ajax({
        url:url,
        type:'get',
        dateType:'json',
        success:function(data){
          console.log(data);
          let htmlresult = '';
          data['order'].forEach(function(e){
              htmlresult+=
              "<li id='each-order-details'>"+
                "<div class='collapsible-header order-basic-info'>"
                  +"<i class='material-icons indigo-text'>payment</i>"
                  +"<span class='order-ref indigo-text'>"+e.reference+"</span>"
                  +"<span class='hide-on-med-and-down'>"+e.date_add+"</span>"
                  +"<span class='total-amount indigo-text'>"+parseInt(e.total_paid_tax_incl)+" &euro;</span>"
                +"</div>"
                +"<div class='collapsible-body row'>"
                  +"<div class='col s9'>"
    								+"<span>"+e.product_name+"</span></br>"
    								+"<span class='indigo-text'>"+e.email+"</span></br>"
    								+"<span>"+e.credits+"&euro; <span class='voucher-status'>reward amount</span></span>"
    							+"</div>"

  							+"<button class='col s3 btn green' id='payment-accept'>Payment Accept</button>"
                +"<button class='col s3 btn hide orange white-text' id='check-remain-voucher'>Transition Completed</button>"

                +"<input type='hidden' value="+e.id_reward+" class='order-reward_id'>"
                +"<input type='hidden' value="+e.email+" class='order-email'>"
                +"<input type='hidden' value="+e.firstname+" class='order-firstname'>"
                +"<input type='hidden' value="+e.lastname+" class='order-lastname'>"
                +"<input type='hidden' value="+e.credits+" class='order-credits'>"
                +"<input type='hidden' value="+e.id_customer+" class='order-customer_id'>"
                +"<input type='hidden' value="+e.product_name+" class='order-product_name'>"
                +"<input type='hidden' value="+e.reference+" class='order-reference'>"
                +"<input type='hidden' value="+e.id_order+" class='order-order_id'>"
                +"<input type='hidden' value="+e.product_id+" class='order-product_id'>"
                +"<input type='hidden' value="+1+" class='is_device'>"
                +"<input type='hidden' value="+e.product_id+" class='order-product_id'>"
                +"<input type='hidden' value="+e.total_paid_tax_incl+" class='order-total_paid'>"
                +"<input type='hidden' value="+data['staff'][0].name+" class='shopname'>"
                +"<input type='hidden' value="+data['staff'][0].shop_id+" class='shop_id'>"
                +"<input type='hidden' value="+new Date().toISOString().slice(0, 19).replace('T', ' ')+" class='current_date'>"

                +"</div>"

              +"</li>"
          });

          $('#order-info').html(htmlresult);
          //2.confirm payment ajax call
          $('#order-info').on('click','#payment-accept',function(e){
            $(this).attr('disabled','disabled');

            $('#get-new-order').attr('disabled','disabled');

            let current_time = new Date().toISOString().slice(0, 19).replace('T', ' ');
            e.preventDefault();
            $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });

           $.ajax({
             url:window.location.href+'createvoucher',
             type:'post',
             dataType:'json',
             data:{
               email:$(this).parent().find('.order-email').val(),
               firstname:$(this).parent().find('.order-firstname').val(),
               lastname:$(this).parent().find('.order-lastname').val(),
               credits:$(this).parent().find('.order-credits').val(),
               id_customer:$(this).parent().find('.order-customer_id').val(),
               product_name:$(this).parent().find('.order-product_name').val(),
               reference:$(this).parent().find('.order-reference').val(),
               order_id:$(this).parent().find('.order-order_id').val(),
               id_reward:$(this).parent().find('.order-reward_id').val(),
               product_id:$(this).parent().find('.order-product_id').val(),
               device:$(this).parent().find('.is_device').val(),
               total_paid:$(this).parent().find('.order-total_paid').val(),
               shopname:$(this).parent().find('.shopname').val(),
               shop_id:$(this).parent().find('.shop_id').val(),
               current_time:current_time,
             },
             success:function(response){
               console.log(response);

               $('.voucher-status').html("<span> reward amount is ready to use</span>");
               $('#check-remain-voucher').removeClass('hide');

               $('#check-remain-voucher').click(function(e){

                 $(this).attr('disabled','disabled');
                 e.preventDefault();
                 $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                $.ajax({
                  url:window.location.href+'checkreward',
                  type:'post',
                  dataType:'json',
                  data:{
                    pos_credits:response.pos_credits,
                    pos_rewardid:response.pos_rewardid,
                    online_orderid:response.online_orderid,
                    online_customerid:response.online_customerid,
                    online_rewardid:response.online_rewardid
                  },
                  success:function(response){
                    if(response.reward_used == 1){
                      $('#each-order-details').remove();
                      $('#get-new-order').removeAttr('disabled');
                    }else if(response.reward_used == 0){
                      let $toastContent = $("<p>Do you wanna proceed without using the reward?</p>")
                      .add($('<button id="click-toast" class="btn-flat red-text toast-action warning-proceed">Proceed</button>'))
                      .add($('<button id="click-toast" class="btn-flat toast-action warning-reverse">NO!</button>'));
                      Materialize.toast($toastContent);

                      $('.warning-proceed').click((e)=>{
                        console.log('proceed');
                      });

                      $('.warning-reverse').click((e)=>{
                        console.log('refused');
                      });
                    }

                  }
                })


                $('#click-toast').click((e)=>{
                  console.log(3123123);
                });
               });

             },
             error:function(){
               console.log('fail to accept payment');
             }
           });

          });
        },
        statusCode:{
          404:function(){
            console.log('page not found');
          },
          401:function(){
            console.log('Login has expired, please try login again');
          }
        }
      });
   });//end of new order get request



   /*=========== search voucher by email ============*/




      $("#email-for-voucher").change(function(){
        let input = $(this).val();
         $('#search-voucher-by-email').click(function(e){

             e.preventDefault();

             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });

             $.ajax({
               url:window.location.href+'voucher_results',
               type:'post',
               dateType:'json',
               data:{email:input},
               success:function(response){
                 console.log(response);
                 if(response.hasVoucher == 0){
                   $('.voucher-results').html("<p class='red-text flow-text'>Can not find match record!</p>");
                 }else if(response.hasVoucher > 0){

                 }
               },
               error:function(){
                 console.log('email can not be found!');
               }
             })
         });
      });




















});
