<?php
require_once("Autoloader.php");
// TODO: enable the programer to define his __autoload function
// meaning that this has to be in the \Decision namespace
/**
 * Namespace autoloading
 * @param string $namespaceOrClass namespace + class name or only class name
 * @author Simeon Banov <svbmony@gmail.com>
 */
function __autoload($namespaceOrClass) {
    $autoloader = \Decision\Autoloader::getInstance();
    if($autoloader->hasCustomCallback($namespaceOrClass)) {
        $autoloader->callback($namespaceOrClass);
    }
    if($autoloader->hasNamespace($namespaceOrClass)) {
        require_once($autoloader->getNamespacePath($namespaceOrClass) . '.php');
    }
}