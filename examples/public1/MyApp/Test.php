<?php
namespace MyApp;

/**
 * Simple class, it can be Utility, Controller, Helper or anything You want.
 * For the example We will use it for a view content helper.
 */
class Test {
    
    public function __construct() {
        $this->msg();
    }
    
    public function msg() {
        print "Simple Example of Decision framework-library";
        if(decision()->getWebRequest()->getRouteName() == "main") {
            print " Page 1</br><a href='/test.php'>go to Page 2</a>";
        } else {
            print " Page 2</br><a href='/'>go to Page 1</a>";
        }
    }
    
}