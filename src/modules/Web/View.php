<?php
namespace Decision\Web;

/**
 * @author Simeon Banov <svbmony@gmail.com>
 */
class View {
    
    /**
     * @var string 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $path;
    
    /**
     * @var string 
     * @author Simeon Banov <svbmony@gmail.com>
     */
    private $file;
    
    /**
     * @param string $path
     * @param string $spacificFile
     * @author Simeon Banov <svbmony@gmail.com>
     */
    public function __construct($path, $spacificFile="") {
        $this->path = $path;
        $this->file = $spacificFile;
    }
    
    /**
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    function getPath() {
        return $this->path;
    }
    
    /**
     * @return string
     * @author Simeon Banov <svbmony@gmail.com>
     */
    function getFile() {
        return $this->file;
    }
    
}