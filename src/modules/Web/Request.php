<?php
namespace Decision\Web;

/**
 * @author Simeon Banov <svbmony@gmail.com>
 */
class Request {
    
    /**
     * Singleton design pattern
     * @var Decision\Web\Request
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private static $instance = NULL;
    
    /**
     * Singleton design pattern
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function __construct() {
        $this->processRequest();
    }
    
    /**
     * Singleton design pattern
     * @return Decision\Web\Request
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public static function &getInstance() {
        if(self::$instance == NULL) {
            self::$instance = new Request();
        }
        return self::$instance; 
    }
    
    private $protocol;
    private $port;
    private $host;
    private $timestamp;
    private $referer;
    private $uri;
    private $get;
    private $post;
    
    /**
     * Extract all possible data for the Web Request
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private function processRequest() {
        $s      = $_SERVER;
        $ssl    = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
        $sp     = strtolower( $s['SERVER_PROTOCOL'] );
        $getPos = strpos($s['REQUEST_URI'], "?");
        
        $this->protocol  = strtoupper(substr( $sp, 0, strpos( $sp, '/' ) )) . ( ( $ssl ) ? 'S' : '' );
        $this->port      = $s['SERVER_PORT'];
        $this->host      = isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null;
        $this->host      = isset( $this->host ) ? $this->host : $s['SERVER_NAME'] . $this->port;
        $this->method    = strtoupper($s['REQUEST_METHOD']);
        $this->timestamp = isset($s['REQUEST_TIME']) ? $s['REQUEST_TIME'] : time();
        $this->referer   = isset($s['HTTP_REFERER']) ? $s['HTTP_REFERER'] : "";
        $this->uri       = $getPos !== FALSE ? substr($s['REQUEST_URI'], 0, $getPos) : $s['REQUEST_URI'];
        $this->get       = $_GET;
        $this->post      = $_POST;
        
        // TODO: find a way to configure
        if(true) {
            unset($_GET);
            unset($_POST);
        }
    }
    
    /**
     * Request method
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getMethod() {
        return $this->method;
    }
    
    /**
     * Request protocol
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getProtocol() {
        return $this->protocol;
    }
    
    /**
     * Request port
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getPort() {
        return $this->port;
    }
    
    /**
     * Request host
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getHost() {
        return $this->host;
    }
    
    /**
     * Request timestamp
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getTimestamp() {
        return $this->timestamp;
    }
    
    /**
     * Request referer
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getReferer() {
        return $this->referer;
    }
    
    /**
     * Request uri
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getUri() {
        return $this->uri;
    }
    
    /**
     * Request get parameters
     * @return array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getGet() {
        return $this->get;
    }
    
    /**
     * Request post parameters
     * @return array
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function &getPost() {
        return $this->post;
    }
    
}