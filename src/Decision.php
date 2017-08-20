<?php
namespace Decision;

/**
 * Main entry point for the package
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Decision {
    use \Decision\Web\WebTrait;
    
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
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $module = array();
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getAutoloader() {
        if(!isset($this->module["Decision Autoloader"])) {
            $this->module["Decision Autoloader"] = \Decision\Autoloader::getInstance();
        }
        return $this->module["Decision Autoloader"];
    }
    
}