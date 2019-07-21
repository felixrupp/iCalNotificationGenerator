<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use FelixRupp\iCalNotificationGenerator\Generator\GeneratorInterface;
use FelixRupp\iCalNotificationGenerator\Generator\iCalNotificationGenerator;

if (isset($_POST["generateSubmit"])) {

    $errorMessage = '';

    if(isset($_FILES['icalFile'])) {

        $fileName = $_FILES['icalFile']['name'];

        $fileNameExploded = explode(".", $fileName);

        $fileNameWithoutExtension = $fileNameExploded[0];
        $fileNameExtension = $fileNameExploded[1];

        if (strtolower($fileNameExtension) === 'ical' || strtolower($fileNameExtension) === 'ics') {

            /**
             * @var GeneratorInterface
             */
            $generator = new iCalNotificationGenerator();

            try {

                $result = $generator->generate($_FILES['icalFile']['tmp_name']);

                if (function_exists('mb_strlen')) {

                    $size = mb_strlen($result, '8bit');
                } else {

                    $size = strlen($result);
                }

                header('Content-Disposition: attachment; filename="'.$fileNameWithoutExtension.'-with-notification.'.$fileNameExtension.'"');
                header("Content-Type: text/calendar");
                header("Content-Length: " . $size);
                header("Connection: close");

                echo $result;
                #exit;

            } catch (Exception $e) {

                $errorMessage = $e->getMessage();
            }
        } else {

            $errorMessage = 'Uploaded file is not an .ical file.';
        }

    } else {

        $errorMessage = 'File upload failed or no file given.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>iCal Notification Generator</title>
</head>
<body>
<h1>iCal Notification Generator</h1>

<?php if(strlen($errorMessage) > 0) { ?>

    <div class="errorMessage">

        <h3>Error</h3>
        <p><?php echo $errorMessage; ?></p>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">
    <fieldset>

        <p><label for="icalFile">iCal File:</label>&nbsp;<input type="file" name="icalFile" id="icalFile"/></p>

        <p><label for="generateSubmit"></label>&nbsp;<input type="submit" name="generateSubmit" id="generateSubmit" value="Generate" /></p>

    </fieldset>
</form>
</body>
</html>