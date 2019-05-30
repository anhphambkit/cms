@extends("layouts.master")

@section('styles')
    <style type="text/css">
        body{ background-color: #f5f5f5;}
    </style>
    <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
    <script>
        // Set the application ID
        var applicationId = "{{ env("SQUARE_APPLICATION_ID") }}";

        // Set the location ID
        var locationId = "{{ env("SQUARE_LOCATION_ID") }}";

        /*
         * function: requestCardNonce
         *
         * requestCardNonce is triggered when the "Pay with credit card" button is
         * clicked
         *
         * Modifying this function is not required, but can be customized if you
         * wish to take additional action when the form button is clicked.
         */
        function requestCardNonce(event) {

            // Don't submit the form until SqPaymentForm returns with a nonce
            event.preventDefault();

            // Request a nonce from the SqPaymentForm object
            paymentForm.requestCardNonce();
        }

        // Create and initialize a payment form object
        var paymentForm = new SqPaymentForm({

            // Initialize the payment form elements
            applicationId: applicationId,
            locationId: locationId,
            inputClass: 'sq-input',

            // Customize the CSS for SqPaymentForm iframe elements
            inputStyles: [{
                fontSize: '.9em'
            }],

            // Initialize the credit card placeholders
            cardNumber: {
                elementId: 'sq-card-number',
                placeholder: '•••• •••• •••• ••••'
            },
            cvv: {
                elementId: 'sq-cvv',
                placeholder: 'CVV'
            },
            expirationDate: {
                elementId: 'sq-expiration-date',
                placeholder: 'MM/YY'
            },
            postalCode: {
                elementId: 'sq-postal-code'
            },

            // SqPaymentForm callback functions
            callbacks: {

                /*
                 * callback function: methodsSupported
                 * Triggered when: the page is loaded.
                 */
                methodsSupported: function (methods) {

                },

                /*
                 * callback function: createPaymentRequest
                 * Triggered when: a digital wallet payment button is clicked.
                 */
                createPaymentRequest: function () {
                    // The payment request below is provided as
                    // guidance. You should add code to create the object
                    // programmatically.
                    return {
                        requestShippingAddress: false,
                        currencyCode: "USD",
                        countryCode: "US",

                        total: {
                            label: "Merchant Name",
                            amount: "1.01",
                            pending: false,
                        },

                        lineItems: [
                            {
                                label: "Subtotal",
                                amount: "1.00",
                                pending: false,
                            },
                            {
                                label: "Tax",
                                amount: "0.01",
                                pending: false,
                            }
                        ]
                    };
                },

                /*
                 * callback function: cardNonceResponseReceived
                 * Triggered when: SqPaymentForm completes a card nonce request
                 */
                cardNonceResponseReceived: function(errors, nonce, cardData) {
                    if (errors) {
                        // Log errors from nonce generation to the Javascript console
                        errors.forEach(function(error) {
                            console.log('  ' + error.message);
                        });

                        return;
                    }

                    console.log('Nonce received: ' + nonce); /* FOR TESTING ONLY */
                    // Assign the nonce value to the hidden form field
                    document.getElementById('card-nonce').value = nonce;

                    // POST the nonce form to the payment processing page
//                    document.getElementById('nonce-form').submit();
                    let data = $("#nonce-form").serialize();
                    $.ajax({
                        url: "{{ route("payment.square") }}",
                        type: "post",
                        data: data,
                        success: function (result) {
                            console.log(result)
                        }
                    })

                },

                /*
                 * callback function: unsupportedBrowserDetected
                 * Triggered when: the page loads and an unsupported browser is detected
                 */
                unsupportedBrowserDetected: function() {
                    /* PROVIDE FEEDBACK TO SITE VISITORS */
                },

                /*
                 * callback function: inputEventReceived
                 * Triggered when: visitors interact with SqPaymentForm iframe elements.
                 */
                inputEventReceived: function(inputEvent) {
                    switch (inputEvent.eventType) {
                        case 'focusClassAdded':
                            /* HANDLE AS DESIRED */
                            break;
                        case 'focusClassRemoved':
                            /* HANDLE AS DESIRED */
                            break;
                        case 'errorClassAdded':
                            /* HANDLE AS DESIRED */
                            break;
                        case 'errorClassRemoved':
                            /* HANDLE AS DESIRED */
                            break;
                        case 'cardBrandChanged':
                            /* HANDLE AS DESIRED */
                            break;
                        case 'postalCodeChanged':
                            /* HANDLE AS DESIRED */
                            break;
                    }
                },

                /*
                 * callback function: paymentFormLoaded
                 * Triggered when: SqPaymentForm is fully loaded
                 */
                paymentFormLoaded: function(result) {
                    /* HANDLE AS DESIRED */
                    console.log(result);

                }
            }
        });
    </script>
@endsection

@section('content')
{!! Form::open(['method' => 'post', 'autocomplete' => 'off', 'id' => 'nonce-form']) !!}
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="panel">
                    
                    <div class="form-group-fl">
                        <input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="text" class="form-control-fl" placeholder="Card Number*" id="sq-card-number"/>
                    </div>

                    <div class="form-group-fl">
                        <input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="text" class="form-control-fl" placeholder="Cvv*" id="sq-cvv"/>
                    </div>

                    <div class="form-group-fl">
                        <input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="text" class="form-control-fl" placeholder="Expiration Date*" id="sq-expiration-date"/>
                    </div>

                    <div class="form-group-fl">
                        <input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="text" class="form-control-fl" placeholder="Postal Code*" id="sq-postal-code"/>
                    </div>
                    <button onclick="requestCardNonce(event)" id="sq-creditcard" type="button" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">
                        Sign in
                    </button>
                    <div class="gray-color">or <a href="{{ route('public.customer.create-account') }}">Create a New Account</a>  |  <a href="#">Forgot Password?</a></div>
                    <input type="hidden" id="card-nonce" name="nonce">
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@stop