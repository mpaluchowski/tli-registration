<?php

$f3 = require('../lib-fatfree/base.php');

// Set path-related options
$f3->set('ROOT', realpath('../'));
$f3->set('AUTOLOAD', '../lib-fatfree/;../lib-php-jwt/;../app/');
$f3->set('UI', '../app/ui/');
$f3->set('LOCALES','../app/dict/');
$f3->set('ESCAPE', 0);

$f3->config('../app/defaults.ini');
// read user config, if it exists
if(file_exists('../app/config.ini'))
    $f3->config('../app/config.ini');

// Define routes
$f3->config('../app/routes.ini');

// Interceptors
\models\L11nManager::setLanguage($f3->get('GET.language'));

$f3->run();
