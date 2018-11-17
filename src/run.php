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

require_once("Autoloader.php");
// TODO: enable the programer to define his __autoload function
// meaning that this has to be in the \Decision namespace
/**
 * Namespace autoloading
 * @param string $namespaceOrClass namespace + class name or only class name
 * @author Simeon Banov <svbmony@gmail.com>
 */
spl_autoload_register(array('Decision\Autoloader','autoload'));

/**
 * Decision class always needs some Traits
 * If a module is not present, then the needed Trait is
 * not present and we need to create it.
 * @author Simeon Banov <svbmony@gmail.com>
 */
// require_once("mockTraits/init.php");

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
