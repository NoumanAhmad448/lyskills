<meta name="csrf-token" content="{{ csrf_token() }}">


    <input type="hidden" id="amount" name="amount" value="20.0">
    <!--<input type="hidden" id="storeId" name="storeId" value="12255">-->
    <input type="hidden" id="storeId" name="storeId" value="63628">
    <input type="hidden" id="callBackURL" name="callBackURL" value="{{route('get-token-pay')}}">
    <input type="hidden" id="orderId" name="orderId" value="{{rand(10, 10000)}}">
    <input type="hidden" id="token" name="token" value="{{$time}}">
    <!--<input type="hidden" id="encryptedHashRequest" name="encryptedHashRequest" value="HHRGU5NT3RPVHV2L">-->
    <input type="hidden" id="encryptedHashRequest" name="encryptedHashRequest" value="L3L9LHA58FE7BCU3">
    <input type="hidden" id="timeStamp" name="timeStamp" value="{{date("Y-m-d").'T'.date("h:i:s")}}">
    <input type="hidden" id="paymentMethod" name="paymentMethod" value="MA_PAYMENT_METHOD">
    
    <input type="button" class="d-none invisible" style="display: none" id="submitPaymentMethod" />


<iframe id="easypay-iframe" name="easypay-iframe" src="about:blank" width="100%" 
height="500px"></iframe>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/ricmoo/aes-js/e27b99df/index.js"></script>

<script>
        function loadIframe(iframeName, url) {
 
 var storeID = document.getElementById("storeId").value;
 var amount = document.getElementById("amount").value;
 var orderID = document.getElementById("orderId").value;
 var token = document.getElementById("token").value;
 var callBackURL = document.getElementById("callBackURL").value;
 var merchantPaymentMethod = 
        document.getElementById("paymentMethod").value;


 var encryptedHashRequest = document.getElementById("encryptedHashRequest").value;
 var timeStamp = document.getElementById("timeStamp").value;
           
 
        //   callBackUrl: "{{route('get-token-pay')}}",
        //   {{route('get-token-pay')}}  
            var params = {  amount: amount, orderRefNum: orderID,
            paymentMethod: "InitialRequest",postBackURL : callBackURL,  storeId: storeID, 
            timeStamp: ''  };
            var str = "";
            for (var key in params) {
                if (str != "") {
                    str += "&";
                }
                str += key + "=" + params[key];
            }
            console.error(str);
            
            // var str = jQuery.param( params);
            // console.log(str);
            
            $.ajax({url : "{{route('get-easy-pay-enc')}}",
                        headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                
                data: 
              {
                str: str
              },
              type: "post",
              success:   
              function(data, status){
                var  hashRequest = data.param;
                    var $iframe = $('#' + iframeName);
                console.log(data.ss);
                console.log(data.param);
                var params1 = { storeId: storeID, orderId: orderID, transactionAmount: amount,     mobileAccountNo: '',emailAddress: '',
                transactionType: "InitialRequest", tokenExpiry: '', bankIdentificationNumber: '', merchantPaymentMethod: '', postBackURL: callBackURL , signature: '',
                encryptedHashRequest: hashRequest };
                var str1 = jQuery.param( params1);
                
                console.log(str1);

                 if ( $iframe.length ) {
                 if(params1.storeId != "" && params1.orderId !="") {
                 console.log(url+'?'+str1);
                 $iframe.attr('src',url+'?'+str1); 
                 } 
                 return false;
                 }
                 
                 return true;
              }
              
            }
              );
            
             
             }
             
             
             
     $( "#submitPaymentMethod" ).click(function() { 
             return loadIframe('easypay-iframe','https://easypaystg.easypaisa.com.pk/tpg/'); 
     });
             
             
     $('#submitPaymentMethod').click();
                
            
</script>