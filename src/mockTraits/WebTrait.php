<?php
namespace Decision\Web;

/**
 * Decision class always needs this Trait
 * If the module is not present, then this Trait is
 * created here
 * @author Simeon Banov <svbmony@gmail.com>
 */
trait WebTrait {
    
    /**
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getRequest() {
        throw new \Exception("In order to use Request, please install Web module of Decision.");
    }
    
    /**
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getRouter() {
        throw new \Exception("In order to use Request, please install Web module of Decision.");
    }
    
}