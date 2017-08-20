<?php

/**
 * Global constants of Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
define(
    "DECISION_ROOT", 
    substr(__DIR__, -1) !== DIRECTORY_SEPARATOR ? 
        __DIR__.DIRECTORY_SEPARATOR : __DIR__
);

/**
 * Namespace autoloading
 * @param string $class namespace + class name
 * @author Simeon Banov <svbmony@gmail.com>
 */
require_once("Autoloader.php");
function __autoload($class) {
    $dirPath = "";
    $parts = explode('\\', $class);
    $autoloader = \Decision\Autoloader::getInstance();
    $customCallbacks = $autoloader->getCustomCallbacks();
    $loader = $autoloader->getLoader();
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
 * Loading of Decision module configurations 
 * @author Simeon Banov <svbmony@gmail.com>
 */
foreach (new \DirectoryIterator(DECISION_ROOT) as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot() && $fileinfo->getFilename()!=="mockTraits") {
        if(is_file(DECISION_ROOT.$fileinfo->getFilename().DIRECTORY_SEPARATOR."config.php")) {
            require_once(DECISION_ROOT.$fileinfo->getFilename().DIRECTORY_SEPARATOR."config.php");
        }
    }
}

/**
 * Decision class always needs some Traits
 * If a module is not present, then the needed Trait is
 * not present and we need to create it.
 * @author Simeon Banov <svbmony@gmail.com>
 */
require_once("mockTraits/init.php");

/**
 * Decision class is the main point of entry
 * when using this framework-library
 * @author Simeon Banov <svbmony@gmail.com>
 */
require_once("Decision.php");

/**
 * shortcut to \Decision\Decision::getInstance()
 * @return \Decision\Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
function decision() {
    return \Decision\Decision::getInstance();
}