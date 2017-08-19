<?php
namespace Decision\Core;

/**
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Autoloader {
    
    
    /**
     * Singleton design pattern
     * @var Decision\Core\Autoloader 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private static $instance = NULL;
    
    /**
     * Singleton design pattern
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function __construct() {
        $this->loader["Decision"] = DECISION_ROOT;
    }
    
    /**
     * Singleton design pattern
     * @return Decision\Core\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public static function getInstance() {
        if(self::$instance == NULL) {
            self::$instance = new Autoloader();
        }
        return self::$instance; 
    }
    
    /**
     * storage for namespace autoloading
     * Structure:
     *   array(
     *     "Decision" => "path to Decision main folder"
     *   )
     * @var array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $loader = array();
    
    /**
     * storage for namespace custom autoloading callback anonymous functions
     * Structure:
     *   array(
     *     "MyApp" => 
     *       function($class) {
     *         if($class == "MyApp\Test") {
     *           include("path to Test class");
     *         }
     *       }
     *   )
     * @var array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $customCallbacks = array();
    
    /**
     * get loader storage
     * @return array @see Autoloader $loader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getLoader() {
        return $this->loader;
    }
    
    /**
     * get customCallbacks storage
     * @return array @see Autoloader $customCallbacks
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getCustomCallbacks() {
        return $this->customCallbacks;
    }
    
    /**
     * @see Autoloader $customCallbacks
     * @param string $namespaceStart the namespace start (name)
     * @param function $callback callback anonymous function, argument is namespace+class path as string
     * @return \Decision\Core\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function addCustomCallback($namespaceStart, $callback) {
        $this->customCallbacks[$namespaceStart] = $callback;
        return this;
    }
    
    /**
     * @see Autoloader $loader
     * @param string $namespaceStart
     * @param string $rootFolder
     * @return \Decision\Core\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function addPath($namespaceStart, $rootFolder) {
        $this->loader[$namespaceStart] = substr($rootFolder, -1) !== DIRECTORY_SEPARATOR ? $rootFolder.DIRECTORY_SEPARATOR : $rootFolder;
        return this;
    }
    
}
