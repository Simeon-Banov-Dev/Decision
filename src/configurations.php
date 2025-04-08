<?php
/**
 * Loading of Decision module configurations 
 * @author Simeon Banov <svbmony@gmail.com>
 */
foreach (new \DirectoryIterator(DECISION_ROOT."modules".DIRECTORY_SEPARATOR) as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        if(is_file(DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$fileinfo->getFilename().DIRECTORY_SEPARATOR."config.php")) {
            require_once(DECISION_ROOT."modules".DIRECTORY_SEPARATOR.$fileinfo->getFilename().DIRECTORY_SEPARATOR."config.php");
        }
    }
}