<?php
require_once("constants.php");
require_once("autoloaderSetuped.php");

use Decision\Setup\DecisionSetup;
print (new DecisionSetup())->process();
