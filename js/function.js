function PluginDibsEasy_v1(){
  /**
   * Intern ajax call.
   */
  this.internCheckout = function(){
    $.ajax({
      url: '/payment/createpayment',
      dataType: 'json',
      success: function(data) {
        data = JSON.stringify(data);
        data = jQuery.parseJSON(data);
        PluginDibsEasy_v1.dibsCheckout(data.paymentId);
      }
    });
  }
  /**
   * Call to DIBS server using their js library.
   */
  this.dibsCheckout = function(paymentID){
    var checkoutKey = 'live-checkout-key-'+document.getElementById('dibs-complete-checkout').getAttribute('data-checkout-key');
    var checkoutOptions = {
      checkoutKey: checkoutKey,
      paymentId : paymentID,
      containerId : "dibs-complete-checkout",
      language: "sv-SE"
    };
    var checkout = new Dibs.Checkout(checkoutOptions);
    checkout.on('payment-completed', function(response) {
      /**
       * When payment is done.
       * This code is not gonna run because of checkout/url param.
       */
      window.location = '/PaymentSuccessful';
    });
  }
}
var PluginDibsEasy_v1 = new PluginDibsEasy_v1();


