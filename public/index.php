<?php

require_once (__DIR__."/../vendor/autoload.php");

use FelixRupp\iCalNotificationGenerator\Generator\GeneratorInterface;
use FelixRupp\iCalNotificationGenerator\Generator\iCalNotificationGenerator;

/**
 * @var GeneratorInterface
 */
$generator = new iCalNotificationGenerator();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>iCal Notification Generator</title>
</head>
<body>
    <h1>iCal Notification Generator</h1>

    <form action="index.php" method="POST" enctype="multipart/form-data">

    </form>
</body>
</html>