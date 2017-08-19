<?php
namespace Decision\Core;

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
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Core\Web\Router
     */
    public function getRouter() {
        if(!isset($this->module["Decision Core Web Router"])) {
            $this->module["Decision Core Web Router"] = \Decision\Core\Web\Router::getInstance();
        }
        return $this->module["Decision Core Web Router"];
    }
    
}