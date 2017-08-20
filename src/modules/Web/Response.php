<?php
namespace Decision\Web;

/**
 * Main executing method
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Response {
    
    /**
     * view paths storage
     * @var array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $views = array();
    
    /**
     * Constructing new response
     * @param array $options response instructions, they may come from custom code or from a route in the \Decision\Web\Router\Router
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function __construct(array $options) {
        if(isset($options['view'])) {
            $autoloader = decision()->getAutoloader();
            foreach($options['view'] as $path => $file) {
                if($autoloader->hasNamespace($path)) {
                    // the path is actualy a namespace
                    $this->views[] = $autoloader->getNamespacePath($path) . DIRECTORY_SEPARATOR . $file;
                }
            }
        }
    }

    /**
     * executing the response
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function execute() {
        if(!empty($this->views)) {
            foreach($this->views as $viewFilePath) {
                include($viewFilePath);
            }
        }
    }
    
    public function getViews() {
        return $this->views;
    }

}