$(document).ready(function(){
    const key = "pk_test_51N0qjnK0l5jNIJDFuOkNr6IFpbDxuY9hyFjdHgv6YJmm3TSBegPIyjfliVts4BG9RgS6U0E6jqtvDecN9nJD2m1j00hqneyGh2";
const stripe = Stripe(key);
const elements = stripe.elements();
// Custom styling can be passed to options when creating an Element.
const style = {
  base: {
    // Add your base input styles here. For example:
    fontSize: "16px",
    color: "#32325d"
  },
};
// Create an instance of the card Element.
const card = elements.create("card", { style });

// Add an instance of the card Element into the `card-element` <div>.
card.mount("#card-element");

card.on("change", function (event) {
    if (event.complete) {
      $(".__add_card").fadeIn(200);
    } else if (event.error) {
      console.log(event.error);
      $(".__add_card").fadeOut(200);
    } else {
      $(".__add_card").fadeOut(200);
    }
  });

$("#add-card").click(function(){
  stripe.createToken(card).then(function (result) {
  if (result.error) {
    // Handle error
  } else {
    // Get the token ID
    var token = result.token.id;

    // Get the card details
    var card = result.token.card;
    var cardNumber = card.last4;
    var cardExpMonth = card.exp_month;
    var cardExpYear = card.exp_year;

    addCardAndSubscribe(token, card);
  }
});
});

//Wallet pay
var paymentRequest = stripe.paymentRequest({
    country: 'GB',
    currency: 'gbp',
    total: {
      label: 'Set Jobs Membership',
      amount: 100,
    },
    requestPayerName: true,
    requestPayerEmail: true,
  });

  // 3. Create a PaymentRequestButton element
  const prButton = elements.create('paymentRequestButton', {
    paymentRequest: paymentRequest,
  });

  // Check the availability of the Payment Request API,
  // then mount the PaymentRequestButton
  paymentRequest.canMakePayment().then(function (result) {
    if (result) {
      prButton.mount('#payment-request-button');
    } else {
      document.getElementById('payment-request-button').style.display = 'none';
      $(".__wallet").fadeOut(200);
      addMessage('Pay support not found. Check the pre-requisites above and ensure you are testing in a supported browser.');
    }
  });

  paymentRequest.on('paymentmethod', async (e) => {
    // Make a call to the server to create a new
    // payment intent and store its client_secret.
    const {error: backendError, clientSecret} = await fetch(
      '/create-payment-intent',
      {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          currency: 'gbp',
          paymentMethodType: 'card',
        }),
      }
    ).then((r) => r.json());

    if (backendError) {
      addMessage(backendError.message);
      e.complete('fail');
      return;
    }

    addMessage(`Client secret returned.`);

    // Confirm the PaymentIntent without handling potential next actions (yet).
    let {error, paymentIntent} = await stripe.confirmCardPayment(
      clientSecret,
      {
        payment_method: e.paymentMethod.id,
      },
      {
        handleActions: false,
      }
    );

    if (error) {
      addMessage(error.message);

      // Report to the browser that the payment failed, prompting it to
      // re-show the payment interface, or show an error message and close
      // the payment interface.
      e.complete('fail');
      return;
    }
    // Report to the browser that the confirmation was successful, prompting
    // it to close the browser payment method collection interface.
    e.complete('success');

    // Check if the PaymentIntent requires any actions and if so let Stripe.js
    // handle the flow. If using an API version older than "2019-02-11" instead
    // instead check for: `paymentIntent.status === "requires_source_action"`.
    if (paymentIntent.status === 'requires_action') {
      // Let Stripe.js handle the rest of the payment flow.
      let {error, paymentIntent} = await stripe.confirmCardPayment(
        clientSecret
      );
      if (error) {
        // The payment failed -- ask your customer for a new payment method.
        addMessage(error.message);
        return;
      }
      addMessage(`Payment ${paymentIntent.status}: ${paymentIntent.id}`);
    }

    addMessage(`Payment ${paymentIntent.status}: ${paymentIntent.id}`);
  }); //Wallet pay
});

function addCardAndSubscribe(token, card)
{
  $.ajax({
    url: baseUrl + "/api/add-card",
    type: "POST",
    data: {
      _token: csrf,
      token: token,
      card: card
    },
    beforeSend: function () {
        $(".__modal_background").fadeIn(200);
        $(".__loading").fadeIn(200);
        $("#loading-box").fadeIn(200);
    },
    success: function (response) {
      console.log(response);
        $(".__modal_background").fadeOut(200);
        $(".__loading").fadeOut(200);
        $("#loading-box").fadeOut(200);
        if(response.success)
        {
            Swal.fire({
                icon: 'success',
                title: 'Done',
                text: response.message
            });
            $("#payment-method").html("");
        }
        if(response.success == false)
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: response.message
            });
        }
    },
    error: function (xhr, status, error) {
      console.log(error);
        $(".__modal_background").fadeOut(200);
        $(".__loading").fadeOut(200);
        $("#loading-box").fadeOut(200);
    },
    complete: function () {
        $(".__modal_background").fadeOut(200);
        $(".__loading").fadeOut(200);
        $("#loading-box").fadeOut(200);

    },
  });
}

function addMessage(message)
{
  // Swal.fire({
  //   icon: 'info',
  //   title: 'Message',
  //   text: message
  // });
  console.log(message);
}