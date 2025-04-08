<?php
namespace Decision\Web;

/**
 * @author Simeon Banov <svbmony@gmail.com>
 */
class SetupDecisionClassTemplate {

	/**
	 * using lazy initialization of class to ensure initializing it only when needed
	 * @return \Decision\Web\Request
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function &getWebRequest() {
		$modules = decision()->__getModules();
		if(!isset($modules["Decision Web Request"])) {
			$modules["Decision Web Request"] = \Decision\Web\Request::getInstance();
		}
		return $modules["Decision Web Request"];
	}

	/**
	 * using lazy initialization of class to ensure initializing it only when needed
	 * @return \Decision\Web\Router\Router
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function &getWebRouter() {
		$modules = decision()->__getModules();
		if(!isset($modules["Decision Web Router Router"])) {
			$modules["Decision Web Router Router"] = \Decision\Web\Router\Router::getInstance();
		}
		return $modules["Decision Web Router Router"];
	}

}