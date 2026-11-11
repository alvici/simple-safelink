<?php

namespace System\Controllers;

class BaseController
{
    function load_view($filePath, $variables = array(), $print = true) {
        $output = NULL;
        $filePath = str_replace('.', DIRECTORY_SEPARATOR, $filePath);
        $filePath = VIEWPATH . DIRECTORY_SEPARATOR . $filePath . '.php';
        // echo VIEWPATH . DIRECTORY_SEPARATOR . $filePath . '.php';
        if(file_exists($filePath)){
            // Extract the variables to a local namespace
            extract($variables);
            // Start output buffering
            ob_start();
            // Include the template file
            include $filePath;
            // End buffering and return its contents
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;
    }
    function load_helper(string $fileName) {
        $fileName = ucwords($fileName);
        $system_helper = SYSTEMPATH . DIRECTORY_SEPARATOR . 'Helpers' . DIRECTORY_SEPARATOR . $fileName . '.php';
        $custom_helper = BASEPATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Helpers' . DIRECTORY_SEPARATOR . $fileName . '.php';
        if(file_exists($system_helper)) {
            include_once $system_helper;
        } elseif(file_exists($custom_helper)) {
            include_once $custom_helper;
        }
    }
    function post($str='') {
        if($str) return \Flight::request()->data->{$str};
        return \Flight::request()->data;
    }
    function get($str='') {
        if($str) return \Flight::request()->query->{$str};
        return \Flight::request()->query;
    }
}
