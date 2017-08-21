<?php
namespace Decision\Web\Response;

/**
 * Base response functionality
 * @author Simeon Banov <svbmony@gmail.com>
 */
interface BaseResponseInterface {
    
    public function __construct(Array $options);
    public function execute();
    
}