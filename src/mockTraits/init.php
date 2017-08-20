<?php
/**
 * Decision class always needs some Traits
 * If a module is not present, then the needed Trait is
 * not present and we need to create it.
 * @author Simeon Banov <svbmony@gmail.com>
 */
if(!trait_exists("\Decision\Web\WebTrait", true)) {
    require_once("WebTrait.php");
}