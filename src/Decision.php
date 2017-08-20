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
    private $modules = array();
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getAutoloader() {
        if(!isset($this->modules["Decision Autoloader"])) {
            $this->modules["Decision Autoloader"] = \Decision\Autoloader::getInstance();
        }
        return $this->modules["Decision Autoloader"];
    }
    
    /**
     * Warring!
     * Mainly used by Decision modules
     * The returned value is by reference.
     * @return array lazy initialization storage for Decision modules
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &__getModules() {
        return $this->modules;
    }
    
}