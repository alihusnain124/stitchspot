<!DOCTYPE html>
<html>

<head>
    <title>Payments</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .container{
            margin-top:250px;
        }
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
        .StripeElement--focus {
            border-color: #66afe9;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
            outline: 0;
        }
        .StripeElement--invalid {
            border-color: #a94442;
        }
    </style>
</head>

<body>
    <div class="container ">
       
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table">
                        <h3 class="panel-title">Payment Details</h3>
                    </div>
                    <div class="panel-body">
                        @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif
                        <form role="form" action="{{ route('stripe_pay_tailor.post') }}" method="post" id="payment-form">
                            @csrf

                            <input type="hidden" name='id' value='{{$id}}'>
                            <input type="hidden" name='user_id' value='{{$user_id}}'>
                            <input type="hidden" name='price' value='{{$price}}'>

                            <div class='form-row row'>
                                <div class='col-xs-12 form-group'>
                                    <label class='control-label'>Credit or Debit Card</label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <div id="card-errors" role="alert" style="color: #a94442; margin-top: 10px; display: none;" class="alert alert-danger"></div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="submit-button">Pay Now
                                        ({{$price}})</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();

    var style = {
        base: {
            color: '#333333',
            fontFamily: '"Helvetica Neue", Helvetica, Arial, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '14px',
            '::placeholder': {
                color: '#999999'
            }
        },
        invalid: {
            color: '#a94442',
            iconColor: '#a94442'
        }
    };

    var card = elements.create('card', {
        style: style,
        hidePostalCode: true
    });

    card.mount('#card-element');

    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.style.display = 'block';
        } else {
            displayError.textContent = '';
            displayError.style.display = 'none';
        }
    });

    var form = document.getElementById('payment-form');
    var submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';

        stripe.confirmCardPayment('{{ $client_secret }}', {
            payment_method: {
                card: card
            }
        }).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                errorElement.style.display = 'block';
                
                submitButton.disabled = false;
                submitButton.textContent = 'Pay Now ({{$price}})';
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.paymentIntent.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            }
        });
    });
</script>
</body>
</html>