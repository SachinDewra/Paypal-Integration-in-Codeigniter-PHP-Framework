<!DOCTYPE html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Ensures optimal rendering on mobile devices. -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <!-- Optimal Internet Explorer compatibility -->
</head>
<body style="margin: 0px; text-align: center;">
   <!-- Suceess -->
   <div class='container' id="show_notification_data"></div>
   <!-- Failure -->
   <div class='container' id="failure_content"></div>
   <div  id="fullpayment_body">
      <script
         src="https://www.paypal.com/sdk/js?client-id=/*client-id*/&currency=<?=$currency?>"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.</script>
      <!-- loader -->
      <p style="color: #fff;background: #f00;padding: 10px;margin: 0px;">* Please do not referesh the page or press back button</p>
      <center>
         <h2>SD Paypal CI Integration Sample</h2>
      </center>
      <div class="col-lg-4 mbr-col-md-10">
         <p style="font-size: 18px;margin: 10px;"><strong>Total Amount:</strong> <?=$amount?> <?=$currency?></p>
      </div>
      <div id="paypal-button-container" style="margin: 10px;"></div>
   </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script type="text/javascript">
      $(document).ready(function() {
       $("#successful_content").hide();
       $("#failure_content").hide();
       // $("#loader").hide();
      
      });
      
      
   </script>
   <script>
      paypal.Buttons({
        createOrder: function(data, actions) {
          return actions.order.create({
           purchase_units: [{
              amount: {
                value: '<?=$amount?>'
              }
            }]
          });
        },
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            // Call your server to save the transaction
            return fetch('paypal_order', {
              method: 'post',
              headers: {
                'accept': 'application/json',
                'content-type': 'application/json'
              },
              body: JSON.stringify({
                orderID: data.orderID,
                pattern:'<?=$order?>'//'1-20-year-0-0'
              })
            }).then(function(res) {
               // $("#loader").show();
              if(res.status === 200) 
              {
                $("#fullpayment_body").hide();
                // $("#successful_content").show();
                //alert('Transaction Successful');
                var successful_content1 = "<div class='row text-center'><div class='col-sm-12'><br><br><br><br><br><img src='<?=base_url("uploads/paypal/")."/"?>checked.svg' style='width:100px;'><h1 style='color:#3DB39E'>Payment Successful</h1><h3>Your payment was successful!</h3><p style='font-size:20px;color:#5C5C5C;'></p><br><br></div></div>"
                $('#show_notification_data').html(successful_content1);
              } else 
              {
                //alert('apology! you have to try again');
                $("#fullpayment_body").hide();
                // $("#failure_content").show();
                var failure_content1 = "<div class='row text-center'><div class='col-sm-12'><br><br><br><br><br><img src='<?=base_url("uploads/paypal/")."/"?>cancel.svg' style='width:100px;'><h1 style='color:#E24C4B'>Payment Failed</h1><br><b>apology! you have to try again</b><br></div></div>"
                $('#show_notification_data').html(failure_content1);
                 //alert('Transaction Fail');
                
              }
            }).then(function(details) {
               if (details.error === 'INSTRUMENT_DECLINED') {
                  return actions.restart();
                }
              });
          });
        },
        
        onCancel: function(data) {
            console.log('The payment was cancelled!');
        }
      }).render('#paypal-button-container');
   </script>
</body>