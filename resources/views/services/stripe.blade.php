<script src="https://js.stripe.com/v2/"></script>
<script>
  $(document).ready(function(){

    var enableJqueryPayments = function() {
      $('input.cc-num').payment('formatCardNumber');
      $('input.cc-cvc').payment('formatCardCVC');
      $('input.cc-exp').payment('formatCardExpiry');
    };

    enableJqueryPayments();

    var form              = $('[role="payment-form"]'),
        stripeApiKey      = form.attr('data-gateway-publishable-key'),
        submit            = form.find('[role="submit"]'),
        submitInitialText = submit.text();

    Stripe.setPublishableKey(stripeApiKey);

    $(submit).on('click', function(e){
      e.preventDefault();

      var cardExpiryData = $('input.cc-exp').payment('cardExpiryVal');
      $('input[data-stripe="exp-month"]').val(parseInt(cardExpiryData.month));
      $('input[data-stripe="exp-year"]').val(parseInt(cardExpiryData.year));

      $(this)
      .attr('disabled', 'disabled')
      .text('Just one moment...');

      Stripe.card.createToken(form, function(status, response) {
        var token;

        if(response.error)
        {
          form
          .find('.payment-errors')
          .text(response.error.message)
          .show();
          
          submit
          .removeAttr('disabled')
          .text(submitInitialText);

        } else {
          token = response.id;
          
          form
          .append($('<input type="hidden" name="token" />').val(token))
          .submit();
        }

      });
    });
  });
</script>