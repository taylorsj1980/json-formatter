<?php
    $jsonRaw = '';
    $jsonFormatted = '';
    $message = '';
    $messageType = '';  //  success/info/warning/danger

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonRaw = trim($_POST['json_raw']);
            $jsonFormatted = trim($_POST['json_formatted']);

            if (!empty($jsonRaw) && empty($jsonFormatted)) {
                //  Take the raw JSON code and format it
                $jsonArr = json_decode($jsonRaw, true);

                if (is_array($jsonArr)) {
                    $jsonFormatted = getJsonLine($jsonArr);
                } else {
                    throw new \Exception($message = 'Raw input is not valid JSON');
                }
            } elseif (empty($jsonRaw) && !empty($jsonFormatted)) {
                //  TODO - To be completed...

            } else {
                throw new \Exception('Either raw or formatted input must be empty');
            }
        } else {
            $jsonRaw = '{"_id" : "xxxx-yyyy-zzzz", "createdAt" : "2017-05-16T15:38:03.440Z", "updatedAt" : "2017-05-16T15:39:09.996Z", "name" : {"title" : "Mr", "first" : "Steven", "last" : "Taylor"}, "address" : {"address1" : "1 Street Road", "address2" : "Some town", "address3" : null, "postcode" : "AB1 2CD"},"dob" : {"date" : "1980-06-14T00:00:00.000Z"}, "email" : {"address" : "taylorsj1980@email.com"},"objects": [{"name": "object1", "desc": "About object 1"},{"name": "object2", "desc": "About object 2"}]}';
        }
    } catch (\Exception $ex) {
        $message = $ex->getMessage();
        $messageType = 'danger';
    }

    function getJsonLine($valueIn, $indentCount = 1)
    {
        $valueOut = '';
        $indentString = '    ';

        if (is_array($valueIn)) {
            $firstIteration = true;

            foreach ($valueIn as $key => $value) {
                $valueOutFormat = '"%s": "%s"';

                if (!$firstIteration) {
                    $valueOut .= ",\n";
                }

                if (is_array($value)) {
                    $valueOutFormat = '"%s": %s';
                    $value = getJsonLine($value, $indentCount + 1);
                }

                $valueOut .= str_repeat($indentString, $indentCount) . sprintf($valueOutFormat, $key, $value);

                $firstIteration = false;
            }
        }

        return "{\n" . $valueOut . "\n" . str_repeat($indentString, $indentCount - 1) . "}";
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
                <div class="row">
                    <div class="col-md-6">
                        Raw
                        <textarea class="form-control" rows="20" name="json_raw"><?= $jsonRaw ?></textarea>
                    </div>
                    <div class="col-md-6">
                        Formatted
                        <textarea class="form-control" rows="20" name="json_formatted"><?= $jsonFormatted ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input class="btn btn-default" type="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>