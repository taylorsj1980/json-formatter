<?php
    include 'json-lib.php';

    $jsonUnformatted = '';
    $jsonFormatted = '';
    $message = '';
    $messageType = '';  //  success/info/warning/danger

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //  Determine the format direction - assume that we are planning to format the JSON value
            $formatDirection = $_POST['format_direction'];

            if (!in_array($formatDirection, ['format', 'unformat'])) {
                throw new \Exception('Unexpected format direction: must be format or unformat');
            }

            //  Check that the string is valid JSON - by default assume we are formatting rather than unformatting
            $formatting = true;
            $jsonStr = $jsonUnformatted = trim($_POST['json_unformatted']);

            if ($formatDirection == 'unformat') {
                $formatting = false;
                $jsonStr = $jsonFormatted = trim($_POST['json_formatted']);
            }

            $jsonArr = json_decode($jsonStr, true);

            if (!is_array($jsonArr)) {
                throw new \Exception(($formatting ? 'Unformatted' : 'Formatted') . ' JSON input is not valid JSON');
            }

            if ($formatting) {
                $jsonFormatted = getFormattedJson($jsonArr);
            } else {
                $jsonUnformatted = getUnformattedJson($jsonArr);
            }
        } else {
            $jsonUnformatted = '{"_id" : "xxxx-yyyy-zzzz", "createdAt" : "2017-05-16T15:38:03.440Z", "updatedAt" : "2017-05-16T15:39:09.996Z", "name" : {"title" : "Mr", "first" : "Steven", "last" : "Taylor"}, "address" : {"address1" : "1 Street Road", "address2" : "Some town", "address3" : null, "postcode" : "AB1 2CD"},"dob" : {"date" : "1980-06-14T00:00:00.000Z"}, "email" : {"address" : "taylorsj1980@email.com"},"objects": [{"name": "object1", "desc": "About object 1"},{"name": "object2", "desc": "About object 2"}]}';
        }
    } catch (\Exception $ex) {
        $message = $ex->getMessage();
        $messageType = 'danger';
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JSON Formatter</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.submit-button').click(function (e) {
                    //  Put the format direction value into the hidden input and submit
                    $('[name="format_direction"]').val($(this).data('format-direction'));
                    $(this).closest('form').submit();
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>JSON Formatter</h1>
                </div>
            </div>
            <?php if (!empty($message) && !empty($messageType)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-<?= $messageType ?>" role="alert"><?= $message ?></div>
                    </div>
                </div>
            <?php } ?>
            <form method="POST">
                <input type="hidden" name="format_direction" />
                <div class="row">
                    <div class="col-md-6">
                        Unformatted
                        <textarea class="form-control" rows="20" name="json_unformatted"><?= $jsonUnformatted ?></textarea>
                    </div>
                    <div class="col-md-6">
                        Formatted
                        <textarea class="form-control" rows="20" name="json_formatted"><?= $jsonFormatted ?></textarea>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px">
                    <div class="col-md-6">
                        <input class="btn btn-default submit-button" type="button" data-format-direction="format" value="Format JSON">
                    </div>
                    <div class="col-md-6">
                        <input class="btn btn-default submit-button" type="button" data-format-direction="unformat" value="Unformat JSON">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>