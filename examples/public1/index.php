<?php
include("../../src/run.php");
decision()->getAutoloader()->addPath("MyApp", __DIR__);
decision()->getWebRouter()->set("/index.php","");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Example 1</title>
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <div class="body">
            Example 1<br/>
            <?php new \MyApp\Test();?>
        </div>
    </body>
</html>