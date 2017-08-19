<?php
require_once("Core/Decision.php");
require_once("Core/Autoloader.php");

define(
    "DECISION_ROOT", 
    substr(__DIR__, -1) !== DIRECTORY_SEPARATOR ? 
        __DIR__.DIRECTORY_SEPARATOR : __DIR__
);

/**
 * @param string $class
 * @author Simeon Banov <svbmony@gmail.com>
 */
function __autoload($class) {
    $dirPath = "";
    $parts = explode('\\', $class);
    $customCallbacks = decision()->getAutoloader()->getCustomCallbacks();
    $loader = decision()->getAutoloader()->getLoader();
    if(isset($customCallbacks[$parts[0]])) {
        $customCallbacks[$parts[0]]($class);
        return;
    } else if(isset($loader[$parts[0]])) {
        $dirPath = substr($loader[$parts[0]], -1) !== DIRECTORY_SEPARATOR ? 
                $loader[$parts[0]].DIRECTORY_SEPARATOR : $loader[$parts[0]];
        for($i=1; $i<count($parts) -1; $i++) {
            $dirPath .= $parts[$i].DIRECTORY_SEPARATOR;
        }
        require_once($dirPath . end($parts) . '.php');
    }
}

/**
 * shortcut to Decision::getInstance()
 * @return \Decision\Core\Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
function decision() {
    return \Decision\Core\Decision::getInstance();
}