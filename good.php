<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>PAYMENT CONFIRMATION</title>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    </head>
    <?php
    if (empty($_POST)) {
        header('Location: index.php');
        exit;
    }

    require_once('constant.php');
    require_once('stripe_lib/vendor/autoload.php');

    use Stripe\Stripe;
    use Stripe\Charge;
    use Stripe\Token;
    use Stripe\Error\InvalidRequest;
    use Stripe\Error\Card;

Stripe::setApiKey(STRIPE_SECRET_KEY);
    $success = false;
    $error_msg = "";
    try {
        $token_details = Token::retrieve($_POST['strip_token']);

        $charge = Charge::create(array(
                    "amount" => $_POST['amount'] * 100,
                    "currency" => "usd",
                    "source" => $_POST['strip_token'],
                    "description" => $_POST['description']
        ));
        if (!empty($charge->id)) {
            $success = true;
        } else {
            $error_msg = "Error while processing request. Please try again.";
        }
    } catch (InvalidRequest $e) {
        $error_msg = $e->getMessage();
    } catch (Card $e2) {
        $error_msg = $e2->getMessage();
    }
    if (!$success) {
        setcookie('error_msg', $error_msg, time() + (86400 * 30), "/");
        header('Location: payment-failed.php');
        exit;
    }
    ?>

    <body>
        <div class="margin_250"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6"><b>PAYMENT CONFIRMATION</b></div>
                <div class="col-md-6">
                    <div class="col-md-12">Thanks for your purchase. Here are the details of your payment:</div><Br><br>
                    <div class="col-md-12"><b>Purchased From:</b> <?= $charge->source->name; ?></div>
                    <div class="col-md-12"><b>Payment Date:</b> <?= date('F d, Y', $charge->created); ?></div>
                    <div class="col-md-12"><b>Payment Amount:</b> <?= ($charge->amount / 100) ?>.00$</div>
                </div>
            </div>
        </div>
        <style>.margin_250{margin-top:250px;}</style>
    </body>
</html>