<?php
namespace Decision\Web;

/**
 * Decision class depends on this Trait to tell
 * it where and how to get to the functionality of the module
 * @author Simeon Banov <svbmony@gmail.com>
 */
trait WebTrait {
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Web\Request
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getWebRequest() {
        if(!isset($this->module["Decision Web Request"])) {
            $this->module["Decision Web Request"] = new \Decision\Web\Request();
        }
        return $this->module["Decision Web Request"];
    }
    
    /**
     * using lazy initialization of class to ensure initializing it only when needed
     * @return \Decision\Web\Router\Router
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getWebRouter() {
        if(!isset($this->module["Decision Web Router Router"])) {
            $this->module["Decision Web Router Router"] = \Decision\Web\Router\Router::getInstance();
        }
        return $this->module["Decision Web Router Router"];
    }
}