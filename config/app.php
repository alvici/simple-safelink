<?php

$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

$config['app_name'] = 'Simple Safelink';
$config['slogan'] = 'Fast, clean safelinks without the hassle.';

$config['post_author'] = 'admin';
$config['post_ext'] = 'xhtm';
$config['countdown'] = 5; //5 seconds

//* AdBlock
$config['adblock'] = 1;
$config['adblock_msg'] = 'Matikan AdBlock terlebih dahulu';