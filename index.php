<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel='stylesheet' id='stripe-checkout-button-css'  href='https://checkout.stripe.com/v3/checkout/button.css' type='text/css' media='all' />
        <title>Test stripe payment</title>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type='text/javascript' src='https://checkout.stripe.com/checkout.js'></script>
    </head>
    <body>
        <form id="hidden_success" method="POST" action="good.php">
            <input type="hidden" name="amount">
            <input type="hidden" name="description">
            <input type="hidden" name="strip_token">
        </form>
        <div class="container">
            <div class="col-md-12 text-center">
                <h1>Test stripe payment</h1>
            </div>
            <div class="col-md-12 row">
                <div class="col-md-6 text-center"></div>
                <div class="col-md-6 text-center">
                    <button id="customButton" class="stripe-button-el">Pay with Card</button>
                    <div class="input-group mb-2 col-md-6">
                        <div class="input-group-prepend">
                            <div class="input-group-text">$</div>
                        </div>
                        <input type="text" class="form-control amount numbers-only" id="inlineFormInputGroup" placeholder="amount">
                        <div class="error_ammount">The minimum amount allowed is $1.00</div>
                    </div>
                </div>
                <?php require_once('constant.php'); ?>
                <script>
                    window.onload = function () {
                        var description = 'Test description';
                        var handler = StripeCheckout.configure({
                            key: '<?= STRIPE_PUBLIC_KEY ?>',
                            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                            locale: 'auto',
                            token: function (token) {
                                var ammount = $('.amount').val();
                                ammount = parseInt(ammount);
                                $('form#hidden_success input[name="amount"]').val(ammount);
                                $('form#hidden_success input[name="description"]').val(description);
                                $('form#hidden_success input[name="strip_token"]').val(token.id);
                                $('form#hidden_success').submit();
                            }
                        });
                        document.getElementById('customButton').addEventListener('click', function (e) {
                            var ammount = $('.amount').val();
                            ammount = parseInt(ammount);
                            if (ammount >= 1) {
                                ammount = parseInt(ammount + '00');

                                handler.open({
                                    description: description,
                                    amount: ammount,
                                    billingAddress: true
                                });
                                $('.error_ammount').hide();
                            } else {
                                console.log('err');
                                $('.error_ammount').show();
                            }
                            e.preventDefault();
                        });

                        // Close Checkout on page navigation:
                        window.addEventListener('popstate', function () {
                            handler.close();

                        });
                    };

                    $(".numbers-only").keypress(function (e) {
                        if (e.which == 46) {
                            if ($(this).val().indexOf('.') != -1) {
                                return false;
                            }
                        }

                        if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });
                </script>
                <style>
                    .error_ammount{color:red; display:none;}
                    .stripe-button-el {
                        display: block;
                        position: relative;
                        padding: 0 12px;
                        height: 30px;
                        line-height: 30px;
                        background: #1275ff;
                        background-image: -webkit-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -moz-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -ms-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -o-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -webkit-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -moz-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -ms-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: -o-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        background-image: linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
                        font-size: 14px;
                        color: #fff;
                        font-weight: bold;
                        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                        text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
                        -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
                        -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
                        -ms-box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
                        -o-box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
                        box-shadow: inset 0 1px 0 rgba(255,255,255,0.25);
                        -webkit-border-radius: 4px;
                        -moz-border-radius: 4px;
                        -ms-border-radius: 4px;
                        -o-border-radius: 4px;
                        border-radius: 4px;
                        margin-left: 15px;
                        margin-bottom: 15px;
                        margin-top: 15px;
                    }

                </style>
            </div>
        </div>

    </body>
</html>