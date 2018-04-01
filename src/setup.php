<?php

/**
 * Global constants of Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
define(
    "DECISION_ROOT", 
    substr(__DIR__, -1) !== DIRECTORY_SEPARATOR ? 
        __DIR__.DIRECTORY_SEPARATOR : __DIR__
);

/**
 * make keys case insensitive
 * @param array $array
 */
function makeKeysCaseInsensitive(Array &$array) {
    foreach ($array as $key=>$value) {
        if(strtolower($key) != $key) {
            $array[strtolower($key)] = $value;
        }
        if(is_array($value)) {
            makeKeysCaseInsensitive($array[strtolower($key)]);
        }
        if(strtolower($key) != $key) {
            unset($array[$key]);
        }
    }
}

/**
 * Generate javadoc string for either an array or string
 * @param Mixed $javadoc either an array or string
 */
function getJavaDoc($javadoc) {
    $return = "\t/**".PHP_EOL;
    if(isset($javadoc['javadoc']) && is_array($javadoc['javadoc'])) {
        if(isset($javadoc['javadoc']['comment'])) {
            if(is_array($javadoc['javadoc']['comment'])) {
                foreach($javadoc['javadoc']['comment'] as $javadocCommentRow) {
                    $return.= "\t * ".$javadocCommentRow.PHP_EOL;
                }
            } else {
                $return.= "\t * ".$javadoc['javadoc']['comment'].PHP_EOL;
            }
        }

        if(isset($javadoc['javadoc']['return'])) {
            $return.= "\t * @return ".$javadoc['javadoc']['return'];
        }

        if(isset($javadoc['javadoc']['author']) && is_string($javadoc['javadoc']['author'])) {
            $return.= "\t * @author ".$javadoc['javadoc']['author'];
        }

        if(isset($javadoc['javadoc']['vars'])) {
            foreach($javadoc['javadoc']['vars'] as $var) {
                if(is_array($var)) {
                    $return.= "\t * ";
                    if(isset($var["type"])) {
                        $return.= "@var ".$var['type']." ";
                    } else {
                        $return.= "@var Mixed ";
                    }
                    if(isset($var['name'])) {
                        $return.= "$".$var['name']." ";
                    } else {
                        $return.= "\$something ";
                    }
                    if(isset($var['description'])) {
                        $return.= $var['description'];
                    }
                    $return.= PHP_EOL;
                } else {
                    $return.= $var;
                }
            }
        }
        foreach($javadoc['javadoc'] as $key=>$value) {
            if(!in_array($key,['author','return','vars','comment'])) {
                $return.= "\t * ".$value;
            }
        }
    } else if(isset($javadoc['javadoc']) && is_string($javadoc['javadoc'])) {
        $return.= $javadoc['javadoc'] .PHP_EOL;
    }
    return $return.= "\t */".PHP_EOL;
}

/**
 * Extracts the function modifier from params array
 * @param array $params
 * @return string
 */
function getFunctionModifier(Array $params) {
    $return = "";
    if(isset($params['modifier']) && is_string($params['modifier'])) {
        switch ($params['modifier']) {
            case "public":
            case "private":
            case "protected":
                $return = $params['modifier'];
                break;
        }
    }
    return $return;
}

/**
 * Extracts the function parameters from params array
 * @param array $params
 * @return string
 */
function getFunctionParams(Array $params) {
    $return = "";
    if(isset($params['params']) && is_array($params['params'])) {
        $notFirst = false;
        foreach($params['params'] as $param) {
            if(is_array($param)) {
                $return.= $notFirst?", ":"";
                if($param['type']) {
                    $return.= $param['type'];
                }
                if($param['name']) {
                    $return.= "$".$param['name'];
                } else {
                    $return.= "\$something";
                }
                if($param['default']) {
                    $return.= " = ".$param['default'];
                }
            } else if(is_string($param)) {
                $return.= ($notFirst?", ":"").$params['params'];
            }
            $notFirst = true;
        }
    } else if(isset($params['params']) && is_string($params['params'])) {
        $return = $params['params'];
    }
    return $return;
}

/**
 * Extract the body of the function
 * @param array $params
 * @return string
 */
function getFunctionBody(Array $params) {
    $return = "";
    if(is_array($params['body'])) {
        $hasRows = false;
        foreach ($params['body'] as $row) {
            $return.= $hasRows?PHP_EOL:"";
            $return.= "\t\t".$row;
            $hasRows = true;
        }
    } else if(is_string($params['body'])) {
        $return = $params['body'];
    }
    return $return;
}

/**
 * Generate setup script final output
 * @param array $warnings
 * @param array $errors
 */
function output(Array &$warnings, Array &$errors) {
    // TODO: make a better error page, preferably an HTML page
    print "<pre>";
    print count($errors)==0?"Errors -<br/>":"No Errors<br/>";
    count($errors)==0?"":print_r($errors);
    print "<br/>";
    print count($warnings)==0?"Warnings -<br/>":"No Warnings<br/>";
    count($warnings)==0?"":print_r($warnings);
    print "</pre>";
    print "<br/>";
    if(count($errors)==0 && count($warnings)==0) {
        print "All done, Decision was setuped and ready to use.";
    } else if(count($errors)!=0) {
        print "Decision was not setuped, please fix the errors and try again.";
    } else if(count($errors)!=0) {
        print "Decision was setuped, but some features will not be availiable.";
    }
}

/**
 * Scripts error and warning containers for later output
 */
$warnings = [];
$errors = [];

/**
 * Decision class base start, middle and end content
 */
$decisionClassStart = "<?php".PHP_EOL."namespace "."Decision;".PHP_EOL."".PHP_EOL."/**".PHP_EOL." * Main entry point for the package".PHP_EOL." * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL." */".PHP_EOL."class "."Decision {".PHP_EOL."".PHP_EOL."\t/**".PHP_EOL."\t * Singleton design pattern".PHP_EOL."\t * @var "."Decision\\Decision".PHP_EOL."\t * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL."\t */".PHP_EOL."\tprivate static $"."instance = NULL;".PHP_EOL."\t".PHP_EOL."\t/**".PHP_EOL."\t * Singleton design pattern".PHP_EOL."\t * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL."\t */".PHP_EOL."\tprivate function __construct() {}".PHP_EOL."\t".PHP_EOL."\t/**".PHP_EOL."\t * Singleton design pattern".PHP_EOL."\t * @return "."Decision\\Decision".PHP_EOL."\t * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL."\t */".PHP_EOL."\tpublic static function getInstance() {".PHP_EOL."\t\tif(self::$"."instance == NULL) {".PHP_EOL."\t\t\tself::$"."instance = new "."Decision();".PHP_EOL."\t\t\t}".PHP_EOL."\t\treturn self::$"."instance;".PHP_EOL."\t}".PHP_EOL."\t".PHP_EOL."\t/**".PHP_EOL."\t * lazy initialization storage for "."Decision modules".PHP_EOL."\t * @var array".PHP_EOL."\t * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL."\t */".PHP_EOL."\tprivate $"."modules = array();".PHP_EOL."\t".PHP_EOL."\t/**".PHP_EOL."\t * using lazy initialization of class to ensure initializing it only when needed".PHP_EOL."\t * @return \\"."Decision\\Autoloader".PHP_EOL."\t * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL."\t */".PHP_EOL."\tpublic function &getAutoloader() {".PHP_EOL."\t\tif(!isset($"."this->modules['Decision Autoloader'])) {".PHP_EOL."\t\t\t$"."this->modules['Decision Autoloader'] = \\"."Decision\\Autoloader::getInstance();".PHP_EOL."\t\t}".PHP_EOL."\t\treturn $"."this->modules['Decision Autoloader'];".PHP_EOL."\t}".PHP_EOL."\t".PHP_EOL."\t/**\t * Mainly used by "."Decision modules to add themselves\t * @return array lazy initialization storage for "."Decision modules".PHP_EOL."\t * @author Simeon Banov <svbmony@gmail.com>".PHP_EOL."\t */".PHP_EOL."\tpublic function &__getModules() {".PHP_EOL."\t\treturn $"."this->modules;".PHP_EOL."\t}".PHP_EOL."\t".PHP_EOL."\t".PHP_EOL;
$decisionClassMiddle = "";
$decisionClassEnd = PHP_EOL.'}';

/**
 * load the modules folder names
 */
$modules = [];
foreach (new \DirectoryIterator(DECISION_ROOT."modules".DIRECTORY_SEPARATOR) as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $modules[] = $fileinfo->getFilename();
    }
}

/**
 * construct Decision class middle from modules
 * load and check any hard dependencies
 * display warnings on any soft dependencies that are not met 
 */
foreach ($modules as $module) {
    // get setupConfig.php of module, if no setupConfig.php present - skip
    $cpath = DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR."setupConfig.php";
    if(!is_file($cpath)) {
        continue;
    }
    $setupConfig = require_once($cpath);
    
    // make keys case insensitive
    makeKeysCaseInsensitive($setupConfig);
    
    // check dependencies
    if(isset($setupConfig['dependencies'])) {
        
        // hard dependencies check, error on not met
        if(isset($setupConfig['dependencies']['hard'])) {
            foreach($setupConfig['dependencies']['hard'] as $hardDependency) {
                if(!in_array($hardDependency, $modules)) {
                    $errors[] = "Hard dependency '".$hardDependency."' is not met";
                }
            }
        }
        
        // soft dependencies check, warrning on not met
        if(isset($setupConfig['dependencies']['soft'])) {
            foreach($setupConfig['dependencies']['soft'] as $softDependency) {
                if(!in_array($softDependency, $modules)) {
                    $warrnings[] = "Soft dependency '".$softDependency."' is not met";
                }
            }
        }
        
    }
    
    // add methods to Decision from module setupConfig.php
    if(count($errors) == 0 && isset($setupConfig['decisionaddonmethod'])) {
        foreach($setupConfig['decisionaddonmethod'] as $key => $params) {
            if(!is_string($key)) {
                $warnings[] = "Module ".$module." has incorect index ".$key." for 'DecisionAddonMethod' array in setupConfig.php and the method definition was not implemented.";
                continue;
            }
            $decisionClassMiddle.= PHP_EOL;            
            // add javadoc if present
            if(isset($params['javadoc'])) {
                $decisionClassMiddle.= getJavaDoc($params);
            }
            
            // construct the method
            $decisionClassMiddle.= 
                    "\t".
                    getFunctionModifier($params).
                    " function ".
                    (is_bool($params['returnbyreference']) && $params['returnbyreference']? "&":"").
                    $key.
                    "(".getFunctionParams($params).
                    ") {".PHP_EOL.
                    getFunctionBody($params).
                    PHP_EOL."\t}".PHP_EOL;
        }
    }
}

if(count($errors)==0) {
    if(!($decisionClass = fopen("Decision.php", "w"))){
        $errors[] = "setup.php does not have permission to write in directory ".DECISION_ROOT;
    }
    if(count($errors)==0) {
        fwrite($decisionClass, $decisionClassStart.$decisionClassMiddle.$decisionClassEnd);
        fclose($decisionClass);
    }
}

output($warnings, $errors);
