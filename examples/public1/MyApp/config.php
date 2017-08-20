<?php
/**
 * Decision run script
 */
require("../../src/run.php");

/**
 * Simplify finding the root of MyApp namespace
 */
define("MYAPP_ROOT", substr(__DIR__, -1)!==DIRECTORY_SEPARATOR ? __DIR__.DIRECTORY_SEPARATOR : __DIR__);

/**
 * Autoload MyApp namespace
 */
decision()->getAutoloader()->addPath("MyApp", MYAPP_ROOT);

/**
 * Add Intercept to specific routes
 */
decision()->getWebRouter()->set(
    WEB_ROUTE_LITERAL,
    array(
        "route" => array("/index.php","/"),
        "view" => array(
            "\MyApp\View" => "mainPage.php"
        )
    )
);
decision()->getWebRouter()->set(
    WEB_ROUTE_LITERAL,
    array(
        "route" => "/test.php",
        "view" => array(
            "\MyApp\View" => "testPage.php"
        )
    )
);

decision()->getWebRouter()->route();