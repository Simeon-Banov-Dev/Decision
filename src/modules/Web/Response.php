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
            if(is_array($options['view'])) {
                foreach($options['view'] as $view) {
                    $this->extractView($view);
                }
            } else {
                $this->extractView($options['view']);
            }
        }
    }
    
    /**
     * @param Mixed $view
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function extractView($view) {
        $autoloader = decision()->getAutoloader();
        $path = "";
        $file = "";
        if($view instanceof \Decision\Web\View) {
            $path = $view->getPath();
            $file = $view->getFile();
        } else if(strpos($view, "@") !== FALSE) {
            $parts = explode("@", $view);
            $path = trim($parts[1]);
            $file = trim($parts[0]);
        } else if(!empty($view)) {
            $path = $view;
        }
        // TODO: a way to have more then one file from the same path
        if($autoloader->hasNamespace($path)) {
            // the path is actualy a namespace
            $this->views[] = $autoloader->getNamespacePath($path) . DIRECTORY_SEPARATOR . $file;
        } else if(!empty($file)) {
            $path = substr($path, -1) !== DIRECTORY_SEPARATOR ? $parts.DIRECTORY_SEPARATOR : $path;
            $this->views[] = $path.$file;
        } else if(!empty($path)) {
            $this->views[] = $path;
        }
    }

    /**
     * executing the response
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function execute() {
        if(!empty($this->views)) {
            foreach($this->views as $viewFilePath) {
                require($viewFilePath);
            }
        }
    }
    
    public function getViews() {
        return $this->views;
    }

}