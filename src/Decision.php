<?php
namespace Decision;

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
            $dirPath += $parts[$i].DIRECTORY_SEPARATOR;
        }
        require_once($dirPath . end($parts) . '.php');
    }
}

/**
 * shortcut to Decision::getInstance()
 * @return Decision\Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
function decision() {
    return Decision::getInstance();
}

/**
 * Main entry point for the package
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Decision {
    
    /**
     * Singleton design pattern
     * @var Decision\Decision 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private static $instance = NULL;
    
    /**
     * Singleton design pattern
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function __construct() {}
    
    /**
     * Singleton design pattern
     * @return Decision\Decision
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public static function getInstance() {
        if(self::$instance == NULL) {
            self::$instance = new Decision();
        }
        return self::$instance; 
    }
    
    /**
     * lazy initialization storage for Decision modules
     * @var array 
     */
    private $module = array();
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Core\Web\Request
     */
    public function getRequest() {
        if(!isset($this->module["Decision Core Web Request"])) {
            $this->module["Decision Core Web Request"] = new \Decision\Core\Web\Request();
        }
        return $this->module["Decision Core Web Request"];
    }
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Core\Autoloader
     */
    public function getAutoloader() {
        if(!isset($this->module["Decision Core Autoloader"])) {
            $this->module["Decision Core Autoloader"] = \Decision\Core\Autoloader::getInstance();
        }
        return $this->module["Decision Core Autoloader"];
    }
    
}