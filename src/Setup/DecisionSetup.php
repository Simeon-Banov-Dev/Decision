<?php 
namespace Decision\Setup;

/**
 * Generation of Decision.php
 * @author Simeon Banov <svbmony@gmail.com>
 */
class DecisionSetup {

	/**
	 * Scripts error and warning containers for later output
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public $warnings = [];
	public $errors = [];


	/**
	 * Decision class base start, middle and end content
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public $decisionClassStart = "";
	public $decisionClassMiddle = "";
	public $decisionClassEnd = PHP_EOL.'}';

	/**
	 * load needed constants and resources
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function __construct() {
		$this->decisionClassStart = $this->extractDecisionClassTemplateAsString();
	}

	/**
	 * make keys case insensitive
	 * @param array $array
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function makeKeysCaseInsensitive(Array &$array, $recursiveIndex = 1) {
	    foreach ($array as $key=>$value) {
	        if($recursiveIndex != 2 && strtolower($key) != $key) {
	            $array[strtolower($key)] = $value;
	        }
	        if(is_array($value)) {
	            $this->makeKeysCaseInsensitive($array[strtolower($key)], $recursiveIndex+1);
	        }
	        if($recursiveIndex != 2 && strtolower($key) != $key) {
	            unset($array[$key]);
	        }
	    }
	}

	/**
	 * Generate javadoc string for either an array or string
	 * @param Mixed $javadoc either an array or string
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function getJavaDoc($javadoc) {
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
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function getFunctionModifier(Array $params) {
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
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function getFunctionParams(Array $params) {
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
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function getFunctionBody(Array $params) {
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
	 * Generate setup script final output as string
	 * @param array $warnings
	 * @param array $errors
	 * @return string
	 * @author Daniel
	 */
	public function output(Array &$warnings, Array &$errors) {
            $return = "";
	    // TODO: make a better error page, preferably an HTML page
	    $return .= "<pre>";
	    $return .= count($errors)>0?"Errors -<br/>":"No Errors<br/>";
	    $return .= count($errors)==0?"":print_r($errors, true);
	    $return .= "<br/>";
	    $return .= count($warnings)>0?"Warnings -<br/>":"No Warnings<br/>";
	    $return .= count($warnings)==0?"":print_r($warnings, true);
	    $return .= "</pre>";
	    $return .= "<br/>";
	    if(count($errors)==0 && count($warnings)==0) {
	        $return .= "All done, Decision was setuped and ready to use.";
	    } else if(count($errors)!=0) {
	        $return .= "Decision was not setuped, please fix the errors and try again.";
	    } else if(count($errors)!=0) {
	        $return .= "Decision was setuped, but some features will not be availiable.";
	    }
	    return $return;
	}

	/**
	 * special function for extracting Decision Template
	 * without the ending class bracket "}"
	 * @return string
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function extractDecisionClassTemplateAsString() {
		$pathToFile = DECISION_ROOT."Setup/DecisionClassTemplate.php";
		if(!file_exists($pathToFile)) {
			die("Unable To Ffind File: ".$pathToFile);
		}
		$return = "";
		$fh = fopen($pathToFile, "r") or die("Unable To Open File: ".$pathToFile);
		while(!feof($fh)) {
			$line = fgets($fh, 4096) or die("Unable To Read File: ".$pathToFile);
			if($line != "}") {
				if(strpos($line, "namespace") !== false) {
					$return.= 'namespace Decision;'.PHP_EOL;
				} else if(strpos($line, "class DecisionClassTemplate") !== false) {
					$return.= 'class Decision {'.PHP_EOL;
				} else {
					$return.= $line;
				}
			}
		}
		fclose($fh);
		return $return;
	}

	/**
	 * @param string $pathToFile absolute path to Class Template 
	 * @return string template class as string
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function extractTemplateClassBodyAsString($pathToFile) {
		if(!file_exists($pathToFile)) {
			die("Unable To Ffind File: ".$pathToFile);
		}
		$return = "";
		$fh = fopen($pathToFile, "r") or die("Unable To Open File: ".$pathToFile);
		$startedBody = false;
		while(!feof($fh)) {
			$line = fgets($fh, 4096) or die("Unable To Read File: ".$pathToFile);
			if($startedBody && $line != "}") {
				$return.= $line;
			} else if(strpos(trim($line), "class") === 0) {
				$startedBody = true;
			}
		}
		fclose($fh);
		return $return;
	}

	/**
	 * Start generation of Decision.php
	 * @author Simeon Banov <svbmony@gmail.com>
	 */
	public function process() {
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
			$templateClassesBody = "";
			$templateClassPath = DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR."SetupDecisionClassTemplate.php";
			if(file_exists($templateClassPath)) {
			    $this->decisionClassMiddle.= $this->extractTemplateClassBodyAsString($templateClassPath);
			} else {
			    // get setupConfig.php of module, if no setupConfig.php present - skip
			    $cpath = DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR."setupConfig.php";
			    if(!is_file($cpath)) {
			        continue;
			    }
			    $setupConfig = require_once($cpath);
			    
			    // make keys case insensitive
			    $this->makeKeysCaseInsensitive($setupConfig);
			    
			    // check dependencies
			    if(isset($setupConfig['dependencies'])) {
			        
			        // hard dependencies check, error on not met
			        if(isset($setupConfig['dependencies']['hard'])) {
			            foreach($setupConfig['dependencies']['hard'] as $hardDependency) {
			                if(!in_array($hardDependency, $modules)) {
			                    $this->errors[] = "Hard dependency '".$hardDependency."' is not met";
			                }
			            }
			        }
			        
			        // soft dependencies check, warrning on not met
			        if(isset($setupConfig['dependencies']['soft'])) {
			            foreach($setupConfig['dependencies']['soft'] as $softDependency) {
			                if(!in_array($softDependency, $modules)) {
			                    $this->warrnings[] = "Soft dependency '".$softDependency."' is not met";
			                }
			            }
			        }
			        
			    }
			    
			    // add methods to Decision from module setupConfig.php
			    if(count($this->errors) == 0 && isset($setupConfig['decisionaddonmethod'])) {
			        foreach($setupConfig['decisionaddonmethod'] as $key => $params) {
			            if(!is_string($key)) {
			                $warnings[] = "Module ".$module." has incorect index ".$key." for 'DecisionAddonMethod' array in setupConfig.php and the method definition was not implemented.";
			                continue;
			            }
			            $this->decisionClassMiddle.= PHP_EOL;            
			            // add javadoc if present
			            if(isset($params['javadoc'])) {
			                $this->decisionClassMiddle.= $this->getJavaDoc($params);
			            }
			            
			            // construct the method
			            $this->decisionClassMiddle.= 
			                    "\t".
			                    $this->getFunctionModifier($params).
			                    " function ".
			                    (is_bool($params['returnbyreference']) && $params['returnbyreference']? "&":"").
			                    $key.
			                    "(".$this->getFunctionParams($params).
			                    ") {".PHP_EOL.
			                    $this->getFunctionBody($params).
			                    PHP_EOL."\t}".PHP_EOL;
			        }
			    }
			}
		}

		if(count($this->errors)==0) {
		    if(!($this->decisionClass = fopen(DECISION_ROOT."Decision.php", "w"))){
		        $this->errors[] = "setup.php does not have permission to write in directory ".DECISION_ROOT;
		    }
		    if(count($this->errors)==0) {
		        fwrite($this->decisionClass, $this->decisionClassStart.$this->decisionClassMiddle.$this->decisionClassEnd);
		        fclose($this->decisionClass);
		    }
		}

		return $this->output($this->warnings, $this->errors);
	}

}