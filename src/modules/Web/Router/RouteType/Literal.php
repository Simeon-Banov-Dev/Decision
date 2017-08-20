<?php
namespace Decision\Web\Router\RouteType;

/**
 * Literal route type
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Literal extends \Decision\Web\Router\BaseRouteType {
    
    /**
     * checks if the route matches to the request
     * @return boolean (TRUE) route match the request, (FALSE) route does not match the request
     * @param \Decision\Web\Request $request
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function matches($request) {
        $match = FALSE;
        $routes = $this->extractRoutes();
        for($i=0; $i<count($routes) && $match === FALSE; $i++) {
            $match = $routes[$i] == $request->getURI();
        }
        return $match;
    }

    /**
     * extract the routes option of this route
     * @return array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function extractRoutes() {
        if(isset($this->options["route"])) {
            return is_array($this->options["route"]) ? $this->options["route"] : array($this->options["route"]);
        }
        return array();
    }
}
