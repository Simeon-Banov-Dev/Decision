<?php
namespace Decision;

/**
 * Main entry point for the package
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Decision {

	/**
	 * Singleton design pattern
	 * @var Decision\Decision
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
	 * @return Decision\Decision
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public static function getInstance() {
		if(self::$instance == NULL) {
			self::$instance = new Decision();
			}
		return self::$instance;
	}
	
	/**
	 * lazy initialization storage for Decision modules
	 * @var array
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	private $modules = array();
	
	/**
	 * using lazy initialization of class to ensure initializing it only when needed
	 * @return \Decision\Autoloader
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function &getAutoloader() {
		if(!isset($this->modules['Decision Autoloader'])) {
			$this->modules['Decision Autoloader'] = \Decision\Autoloader::getInstance();
		}
		return $this->modules['Decision Autoloader'];
	}
	
	/**	 * Mainly used by Decision modules to add themselves	 * @return array lazy initialization storage for Decision modules
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function &__getModules() {
		return $this->modules;
	}
	
	

	public function &getwebrequest() {
		$modules = decision()->__getModules();
		if(!isset($modules["Decision Web Request"])) {
		$modules["Decision Web Request"] = \Decision\Web\Request::getInstance();
		}
		return $modules["Decision Web Request"];
	}

	public function &getwebrouter() {
		$modules = decision()->__getModules();
		if(!isset($modules["Decision Web Router Router"])) {
		$modules["Decision Web Router Router"] = \Decision\Web\Router\Router::getInstance();
		}
		return $modules["Decision Web Router Router"];
	}

}