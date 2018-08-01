<?php
/**
 * You can separate the configurations in separate files,
 * but We will put it in one, for simplicity of the first example.
 */

/**
 * Decision run script.
 */
require("../../src/run.php");

/**
 * Simplify finding the root of MyApp namespace.
 */
define("MYAPP_ROOT", substr(__DIR__, -1)!==DIRECTORY_SEPARATOR ? __DIR__.DIRECTORY_SEPARATOR : __DIR__);

/**
 * Autoload MyApp namespace.
 */
decision()->getAutoloader()->addPath("MyApp", MYAPP_ROOT);

/**
 * Add Intercept to specific routes.
 * In this example We will use only Literal route.
 * Meaning the route URI has to be exact route, else it would not activate.
 */
decision()->getWebRouter()->set(
    WEB_ROUTE_LITERAL,
    array(
        // You could set a name for the Route.
        "name" => "main",
        // You could match more then one route, executed only once per setting.
        "route" => array("/index.php", "/"),
        // easy way to define the path to the view file.
        "view" => "mainPage.php @ \\MyApp\\View"
    )
);
decision()->getWebRouter()->set(
    WEB_ROUTE_LITERAL,
    array(
        "route" => "/test.php",
        // You could have more then one view, they are executed in order of input.
        // Let Us show some diffrent ways to define a view file.
        "view" => array(
            // File at namespace folder.
            // Take notice that the view file does not need to declare namespace
            // as long as the main namespace is in the Autoloader.
            "start.php @ \\MyApp\\View\\Template",
            // The 1-st argument can also take an absolute path and
            // the 2-cd is not needed if You put the file name in the 1-st.
            new \Decision\Web\View("\\MyApp\\View","testPage.php"),
            // You could also give an absolute path.
            MYAPP_ROOT.DIRECTORY_SEPARATOR."View".DIRECTORY_SEPARATOR."Template".DIRECTORY_SEPARATOR."end.php"
        )
    )
);

// let the Router do his work
decision()->getWebRouter()->route();