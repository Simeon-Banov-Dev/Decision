<?php
/**
 * Global constants of Decision
 * @author Simeon Banov <svbmony@gmail.com>
 */
require_once 'constants.php';
require_once 'Setup/DecisionSetup.php';
$setup = new \Decision\Setup\DecisionSetup();
print($setup->process());
if(count($setup->errors)==0) {
    print("<br/><br/>Redirecting in <span class='counter'>10</span> seconds.");
    $script = file_get_contents("Setup/refresh.js", FILE_USE_INCLUDE_PATH) or die("<br/><br/>Unable to read auto-refresh scrip, please refresh the page when done reading to start Decision.");
    print("<script type='text/JavaScript'>".$script."</script>");
}