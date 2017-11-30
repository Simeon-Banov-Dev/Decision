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
    $return = "\t/**\n";
    if(is_array($javadoc['javadoc'])) {
        if(isset($javadoc['javadoc']['comment'])) {
            if(is_array($javadoc['javadoc']['comment'])) {
                foreach($javadoc['javadoc']['comment'] as $javadocCommentRow) {
                    $return.= "\t * ".$javadocCommentRow."\n";
                }
            } else {
                $return.= "\t * ".$javadoc['javadoc']['comment']."\n";
            }
        }

        if(isset($javadoc['javadoc']['return'])) {
            $return.= "\t * @return ".$javadoc['javadoc']['return'];
        }

        if(isset($javadoc['javadoc']['author'])) {
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
                    $return.= "\n";
                } else {
                    $return.= $var;
                }
            }
        }
        foreach($javadoc['javadoc'] as $key=>$value) {
            if($key != "author" && $key != "return" && $key != "vars" && $key != "comment") {
                $return.= "\t * ".$value;
            }
        }
    } else if(is_string($params['javadoc'])) {
        $return.= $javadoc['javadoc'] ."\n";
    }
    $return.= "\t */\n";
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
    if(is_array($params['params'])) {
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
    } else if(is_string($params['params'])) {
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
            $return.= $hasRows?"\n":"";
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
$decisionClassStart = '<?php\nnamespace Decision;\n\n/**\n * Main entry point for the package\n * @author Simeon Banov <svbmony@gmail.com>\n */\nclass Decision {\n\n\t/**\n\t * Singleton design pattern\n\t * @var Decision\\Decision\n\t * @author Simeon Banov <svbmony@gmail.com>\n\t */\n\tprivate static $instance = NULL;\n\t\n\t/**\n\t * Singleton design pattern\n\t * @author Simeon Banov <svbmony@gmail.com>\n\t */\n\tprivate function __construct() {}\n\t\n\t/**\n\t * Singleton design pattern\n\t * @return Decision\\Decision\n\t * @author Simeon Banov <svbmony@gmail.com>\n\t */\n\tpublic static function getInstance() {\n\t\tif(self::$instance == NULL) {\n\t\t\tself::$instance = new Decision();\n\t\t\t}\n\t\treturn self::$instance;\n\t}\n\t\n\t/**\n\t * lazy initialization storage for Decision modules\n\t * @var array\n\t * @author Simeon Banov <svbmony@gmail.com>\n\t */\n\tprivate $modules = array();\n\t\n\t/**\n\t * using lazy initialization of class to ensure initializing it only when needed\n\t * @return \\Decision\\Autoloader\n\t * @author Simeon Banov <svbmony@gmail.com>\n\t */\n\tpublic function &getAutoloader() {\n\t\tif(!isset($this->modules["Decision Autoloader"])) {\n\t\t\t$this->modules["Decision Autoloader"] = \\Decision\\Autoloader::getInstance();\n\t\t}\n\t\treturn $this->modules["Decision Autoloader"];\n\t}\n\t\n\t/**\t * Mainly used by Decision modules to add themselves\t * @return array lazy initialization storage for Decision modules\n\t * @author Simeon Banov <svbmony@gmail.com>\n\t */\n\tpublic function &__getModules() {\n\t\treturn $this->modules;\n\t}\n\t\n\t\n';
$decisionClassMiddle = "";
$decisionClassEnd = '/n}';

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
    if(!is_file(DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$fileinfo->getFilename().DIRECTORY_SEPARATOR."setupConfig.php")) {
        continue;
    }
    $setupConfig = require_once(DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$fileinfo->getFilename().DIRECTORY_SEPARATOR."setupConfig.php");
    
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
            $decisionClassMiddle.= "\n";
            
            // add javadoc if present
            if(isset($params['javadoc'])) {
                $decisionClassMiddle.= getJavaDoc($params['javadoc']);
            }
            
            // construct the method
            $decisionClassMiddle.= 
                    "\t".
                    getFunctionModifier($params).
                    "function ".
                    (is_bool($params['returnbyreference']) && $params['returnbyreference']? "&":"").
                    $key.
                    "(".getFunctionParams($params).
                    ") {\n".
                    getFunctionBody($params).
                    "\n\t}\n";
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