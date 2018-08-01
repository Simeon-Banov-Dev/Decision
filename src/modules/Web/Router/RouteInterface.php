<?php
namespace Decision\Web\Router;

/**
 * All route types must implement this interface
 * @author Simeon Banov <svbmony@gmail.com>
 */
interface RouteInterface {
    
    public function __construct(Array $options);
    public function getResponse();
    /**
     * checks if the route matches to the request
     * @return boolean (TRUE) route match the request, (FALSE) route does not match the request
     * @param \Decision\Web\Request $request
     */
    public function matches($request);
    public function getName();
    
}