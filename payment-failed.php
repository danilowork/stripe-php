<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>PAYMENT FAILED</title>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    </head>
    <?php
    if (!isset($_COOKIE['error_msg'])) {
        header('Location: index.php');
        exit;
    }
    ?>


    <body>
        <div class="margin_250"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6"><b>PAYMENT FAILED</b></div>
                <div class="col-md-6">
                    <div class="col-md-12"><?= $_COOKIE['error_msg']; ?></div>
                    <?php setcookie('error_msg', null, -1, '/'); ?>
                </div>

            </div>
        </div>
        <style>.margin_250{margin-top:250px;}</style>
    </body>
</html>