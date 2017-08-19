<?php
include("../../src/Decision.php");
decision()->getAutoloader()->addPath("MyApp", __DIR__);
decision()->getRouter()->set("/index.php","");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Example 1</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <div class="body">
            Example 1
        </div>
    </body>
</html>