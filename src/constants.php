<?php

/**
 * Global constants of Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
if(!defined("DECISION_ROOT")) {
	$decisionPath = __FILE__;
	$decisionPath = substr($decisionPath, 0, strrpos($decisionPath, DIRECTORY_SEPARATOR));
	if(substr($decisionPath, -1) != DIRECTORY_SEPARATOR) {
		$decisionPath .= DIRECTORY_SEPARATOR;
	}
	define("DECISION_ROOT", $decisionPath);
}