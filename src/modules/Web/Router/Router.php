<?php
namespace Decision\Web\Router;

/**
 * @author Simeon Banov <svbmonny@gmail.com>
 */
class Router {
    
    /**
     * Singleton design pattern
     * @var Decision\Web\Router\Router
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
     * @return Decision\Web\Router\Router
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public static function &getInstance() {
        if(self::$instance == NULL) {
            self::$instance = new Router();
        }
        return self::$instance; 
    }
    
    /**
     * Storage for routes and their execute options
     * @var array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $routes = array(
        "GET"  => array(),
        "POST" => array()
    );
    
    /**
     * \Decision\Web\Response storage
     * @var array 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $responses = array();
    
    /**
     * Set a route to Intercept and options to execute upon Intercepting
     * @param Mixed $routeType \Decision\Web\Router\RouteInterface or string with the namespace of the Route type, please use Decision predefined constants beginning with "WEB_ROUTE_"
     * @param array $options
     * @return \Decision\Web\Router\RouteInterface
     * @throws Exception "Decision Web Router set accepts only 'string' or instance of \Decision\Web\Router\RouteInterface"
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &set($routeType, $options = array()) {
        if($routeType instanceof \Decision\Web\Router\RouteInterface) {
            $routeTypeInstance = $routeType;
        } else if(is_string($routeType)) {
            $routeTypeInstance = new $routeType($options);
        } else {
            throw new Exception("Decision Web Router set accepts only 'string' or instance of \Decision\Web\Router\RouteInterface");
        }
        $this->routes[$this->extractRequestMethod($options)][] = $routeTypeInstance;
        return $routeTypeInstance;
    }
    
    /**
     * @param array $options
     * @return string
     */
    private function extractRequestMethod(Array $options) {
        if(isset($options["method"]) && (strtoupper($options['method']) == "GET" || strtoupper($options['method']) == "POST")) {
            return strtoupper($options['method']);
        }
        return "GET";
    }
    
    /**
     * Intercept current route, store the responses and execute if param allows it
     * @param boolean $execute (TRUE) executes the responses immediately, (FALSE) store the responses for executing later by responsesExecute method 
     * @return \Decision\Web\Router\Router
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &route($execute=TRUE) {
        $request = \Decision\Web\Request::getInstance();
        foreach($this->routes[$request->getMethod()] as $route) {
            if($route->matches($request)) {
                // TODO: what to do if more then one Route matches?
                $request->setRouteName($route->getName());
                $this->responses[] = $route->getResponse();
            }
        }
        if($execute) {
            $this->responsesExecute();
        }
        return $this;
    }
    
    /**
     * executes the responses of the Intecepted route
     * @return \Decision\Web\Router\Router
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function responsesExecute() {
        foreach ($this->responses as $response) {
            $response->execute();
        }
    }
    
    /**
     * @return array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getResponses() {
        return $this->responses;
    }
    
}