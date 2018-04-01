<?php
require_once("constants.php");

if(!is_file(DECISION_ROOT."Decision.php")) {
    // TODO: better error page
    die("Decision is not setup, please run setup.php in the decision folder to setup.");
}

/**
 * Loading of Decision module configurations 
 * @author Simeon Banov <svbmony@gmail.com>
 */
foreach (new \DirectoryIterator(DECISION_ROOT."modules".DIRECTORY_SEPARATOR) as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        if(is_file(DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$fileinfo->getFilename().DIRECTORY_SEPARATOR."config.php")) {
            require_once(DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$fileinfo->getFilename().DIRECTORY_SEPARATOR."config.php");
        }
    }
}

require_once('autoloadedSetuped.php');

/**
 * shortcut to \Decision\Decision::getInstance()
 * @return \Decision\Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
function decision() {
    return \Decision\Decision::getInstance();
}