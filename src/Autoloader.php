<?php
namespace Decision;

/**
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Autoloader {
    
    
    /**
     * Singleton design pattern
     * @var Decision\Autoloader 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private static $instance = NULL;
    
    /**
     * Singleton design pattern
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function __construct() {
        $this->loader["Decision"] = DECISION_ROOT."modules".DIRECTORY_SEPARATOR;
    }
    
    /**
     * Singleton design pattern
     * @return Decision\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public static function &getInstance() {
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
     *       },
     *     "Test" => "msg@\MyApp\Test",
     *     "Test2" => "functionName"
     *   ),
     * @var array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $customCallbacks = array();
    
    /**
     * get loader storage
     * Structure:
     *   array(
     *     "Decision" => "path to Decision main folder"
     *   )
     * @return array 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getLoader() {
        return $this->loader;
    }
    
    /**
     * get customCallbacks storage
     * Structure:
     *   array(
     *     "MyApp" => 
     *       function($class) {
     *         if($class == "MyApp\Test") {
     *           include("path to Test class");
     *         }
     *       },
     *     "Test" => "msg@\MyApp\Test",
     *     "Test2" => "functionName"
     *   )
     * @return array 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getCustomCallbacks() {
        return $this->customCallbacks;
    }
    
    /**
     * @see Autoloader $customCallbacks
     * @param string $namespaceStart the namespace start (name)
     * @param function $callback callback anonymous function, argument is namespace+class path as string
     * @return \Decision\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &addCustomCallback($namespaceStart, $callback) {
        $this->customCallbacks[$namespaceStart] = $callback;
        return $this;
    }
    
    /**
     * adds to storage for namespace autoloading
     * Structure:
     *   array(
     *     "Decision" => "path to Decision main folder"
     *   )
     * @param string $namespaceStart
     * @param string $rootFolder
     * @return \Decision\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &addPath($namespaceStart, $rootFolder) {
        $namespaceStart = substr($namespaceStart, 0, 1)==="\\" ? substr($namespaceStart, 1) : $namespaceStart;
        $this->loader[$namespaceStart] = substr($rootFolder, -1) !== DIRECTORY_SEPARATOR ? $rootFolder.DIRECTORY_SEPARATOR : $rootFolder;
        return $this;
    }
    
    /**
     * @param string $namespace
     * @return boolean (TRUE) if autoloader knows of the namespace, (FALSE) if autoloader does not know of the namespace
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function hasNamespace($namespace) {
        $namespace = substr($namespace, 0, 1)==="\\" ? substr($namespace, 1) : $namespace;
        $parts = array();
        if(strpos($namespace, "\\") === FALSE) {
            $parts[0] = $namespace;
        } else {
            $parts = explode("\\", $namespace);
        }
        return isset($this->loader[$parts[0]]);
    }
    
    /**
     * @param string $namespace
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getNamespacePath($namespace) {
        $namespace = substr($namespace, 0, 1)==="\\" ? substr($namespace, 1) : $namespace;
        $parts = array();
        if(strpos($namespace, "\\") === FALSE) {
            $parts[0] = $namespace;
        } else {
            $parts = explode("\\", $namespace);
        }
        if(count($parts)==2 && $parts[0]=="Decision") {
            $dirPath = DECISION_ROOT;
        } else {
            $dirPath = substr($this->loader[$parts[0]], -1) !== DIRECTORY_SEPARATOR ? 
                    $this->loader[$parts[0]].DIRECTORY_SEPARATOR : $this->loader[$parts[0]];
            for($i=1; $i<count($parts) -1; $i++) {
                $dirPath .= $parts[$i].DIRECTORY_SEPARATOR;
            }
        }
        return $dirPath . end($parts);
    }
    
    /**
     * @param string $namespaceOrClass
     * @return boolean (TRUE) if autoloader knows of the namespace or class, (FALSE) if autoloader does not know of the namespace or class
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function hasCustomCallback($namespaceOrClass) {
        return isset($this->customCallbacks[$namespaceOrClass]);
    }
    
    /**
     * @param string $namespaceOrClass
     * @return \Decision\Autoloader
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &customCallback($namespaceOrClass) {
        if(is_executable($this->customCallbacks[$namespaceOrClass])) {
            $this->customCallbacks[$namespaceOrClass]();
        } else if(strpos($this->customCallbacks[$namespaceOrClass], "@") !== FALSE) {
            $parts = explode("@", $this->customCallbacks[$namespaceOrClass]);
            $object = new $parts[2];
            if(method_exists($parts[0], $object)) {
                $object->$parts[0]();
            }
        } else if (function_exists($this->customCallbacks[$namespaceOrClass])) {
            call_user_func($this->customCallbacks[$namespaceOrClass]);
        }
        return $this;
    }
    
}
