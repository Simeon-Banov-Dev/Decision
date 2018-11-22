<?php
/**
 * Global constants of Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
require_once 'constants.php';

if(!is_file(DECISION_ROOT."Decision.php")) {
    // TODO: better error page
    print("Decision is not setup, runing setup.php in the decision folder to setup.<br/><br/>");
    include('setup.php');
    die();
}

require_once("configurations.php");
require_once("Autoloader.php");
// TODO: enable the programer to define his __autoload function
// meaning that this has to be in the \Decision namespace
/**
 * Namespace autoloading
 * @param string $namespaceOrClass (namespace + class name) or only class name
 * @author Simeon Banov <svbmony@gmail.com>
 */
spl_autoload_register(array('Decision\Autoloader','autoload'));

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