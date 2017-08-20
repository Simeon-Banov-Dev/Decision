<?php
namespace Decision\Web\Router;

/**
 * Base route type
 * @author Simeon Banov <svbmony@gmail.com>
 */
abstract class BaseRouteType implements \Decision\Web\Router\RouteInterface {
    
    /**
     * route options storage
     * @var array 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    protected $options = array();
    
    /**
     * construct a new Route
     * @param array $options route options
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function __construct(array $options) {
        $this->options = $options;
    }

    /**
     * get route response
     * @return \Decision\Web\Response
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function getResponse() {
        return new \Decision\Web\Response($this->options);
    }
    
}