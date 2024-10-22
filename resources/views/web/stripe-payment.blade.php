<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        $websetting = App\Models\WebSetting::first();
    @endphp
    <link rel="icon" type="image/png" href="{{ $websetting?->websiteFaviconPath ?? asset('web/favIcon.png') }}">
    <title>{{ $websetting->title ?? config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
</head>


<body>
    <div class="min-h-screen bg-gray-200 d-flex justify-content-center align-items-center">
        <div class="w-full max-w-xl">
            <a href="{{ config('app.frontend_url') }}" class="pb-3 d-flex justify-content-center text-center">
                <img src="{{ $websetting->websiteLogoPath ?? asset('web/logo.png') }}" alt="Logo" width="200">
            </a>
            @if ($order->payment_status == 'Paid')
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h2>Hello</h2>
                        <h3 class="card-title">We already received your payment</h3>
                        <p class="card-text text-lite">Some quick example text to build on the card title and
                            make up the bulk of the card's content.</p>
                        <h1 class="card-title">Thanks for stay with us.</h1>
                    </div>
                </div>
            @else
                <div class="shadow bg-white rounded-md p-3">
                    <form id="payment-form">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $amount }}">

                        <div class="w-full mb-3">
                            <label>Card Holder Name</label>
                            <input id="card-holder-name" class="form-control" type="text"
                                placeholder="Card Holder Name" />
                        </div>

                        <div class="my-3">
                            <div id="card-element" class="form-control"></div>
                        </div>

                        <!-- Used to display form card errors and others messages. -->
                        <div id="card-errors" role="alert" class="text-danger"></div>
                        <div id="card-thank" style="color: green;"></div>
                        <div id="card-message" style="color: green;"></div>
                        <div id="card-success" style="color: green;font-weight:bolder"></div>


                        <div class="stripe-errors"></div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif

                        <button id="submit"
                            class="w-full btn py-2 rounded-md bg-blue-1 d-flex justify-content-center text-center text-white font-black mt-2">
                            <div id="loading" class="hidden">
                                <div class="spinner-border text-white spinner-border-sm">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <span class="" id="price">
                                Submit Payment €{{ $amount }}
                            </span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        $('#card-success').text('');
        $('#card-errors').text('');
        var stripe = Stripe('{{ config('app.stripe_key') }}');
        var elements = stripe.elements();
        $('#submit').prop('disabled', true);
        // Set up Stripe.js and Elements to use in checkout form
        var style = {
            base: {
                color: "#32325d",
            }
        };

        var card = elements.create("card", {
            style: style
        });
        card.mount("#card-element");

        card.addEventListener('change', ({
            error
        }) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.textContent = error.message;
                $('#submit').prop('disabled', true);
            } else {
                displayError.textContent = '';
                $('#submit').prop('disabled', false);
            }
        });

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(ev) {
            $('.loading').css('display', 'block');
            ev.preventDefault();

            setLoading(true)

            const cardHolderName = document.getElementById('card-holder-name');
            const cardHolderEmail = document.getElementById('card-holder-email');
            //cardnumber,exp-date,cvc
            stripe.confirmCardPayment('{{ $client_secret }}', {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardHolderName.value,

                    }
                },
                setup_future_usage: 'off_session'
            }).then(function(result) {
                $('.loading').css('display', 'none');

                if (result.error) {
                    setLoading(false)
                    $('#card-errors').text(result.error.message);
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        setLoading(false)
                        $('#card-success').text("payment successfully completed.");
                        setTimeout(
                            function() {
                                window.location.href =
                                    "{{ route('charge', 'orderId=' . request()->get('orderId')) }}";
                            }, 2000);
                    }
                    return false;
                }
            });
        });


        function setLoading(isLoading) {
            if (isLoading) {
                document.querySelector("#submit").disabled = true;
                document.querySelector("#submit").classList.add("opacity-30");
                document.querySelector("#submit").classList.add("cursor-not-allowed");
                document.querySelector("#loading").classList.remove("hidden");
                document.querySelector("#price").classList.add("hidden");
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#submit").classList.remove("opacity-30");
                document.querySelector("#submit").classList.remove("cursor-not-allowed");
                document.querySelector("#loading").classList.add("hidden");
                document.querySelector("#price").classList.remove("hidden");
            }
        }
    </script>
</body>


</html>
