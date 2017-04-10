<?php

require_once('vendor/autoload.php');

loadClasses('src');

function loadClasses($dir) {
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file)) {
            loadClasses($file);
        } else {
            require_once($file);
        }
    }
}