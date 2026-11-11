<?php

if(!function_exists('app')) {
    function app() {
        global $app;
        return $app;
    }
}

if(!function_exists('base_url')) {
    function base_url($link='') {
        global $config;
        $base_url = rtrim($config['base_url'], '/');
        return "$base_url/$link";
    }
}
if(!function_exists('base_domain')) {
    function base_domain($url=null) {
        if(!$url) $url = base_url();
        $host = @parse_url($url, PHP_URL_HOST);
        // If the URL can't be parsed, use the original URL
        // Change to "return false" if you don't want that
        if (!$host)
            $host = $url;
        // The "www." prefix isn't really needed if you're just using
        // this to display the domain to the user
        if (substr($host, 0, 4) == "www.")
            $host = substr($host, 4);
        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50)
            $host = substr($host, 0, 47) . '...';
        return $host;
    }
}
if(!function_exists('config')) {
    function config($item=null) {
        if($item) {
            global $config;
            if(isset($config[$item])) return $config[$item];
            return false;
        } return false;
    }
}

if(!function_exists('asset')) {
    function asset($path='') {
        global $config;
        $base_url = rtrim(base_url('public/assets'), '/');
        return "$base_url/$path";
    }
}

if(!function_exists('asset_v')) {
    function asset_v($path='') {
        $file = BASEPATH . '/public/assets/' . ltrim($path, '/');
        $version = file_exists($file) ? filemtime($file) : time();
        return asset($path) . '?v=' . $version;
    }
}

if(!function_exists('public_url')) {
    function public_url($path='') {
        global $config;
        $base_url = rtrim(base_url('public'), '/');
        return "$base_url/$path";
    }
}

if(!function_exists('slugit')) {
    function slugit($str, $replace=array(), $delimiter='-') {
        if ( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        return $clean;
    }
}

if(!function_exists('url')) {
	function url($path='') {
		if ( (! empty($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') ||
		(! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ||
		(! empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) {
			$server_request_scheme = 'https';
		} else {
			$server_request_scheme = 'http';
		}
		$root = $server_request_scheme . '://' . $_SERVER['HTTP_HOST'];
		$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		return rtrim($root, "/") . '/'. $path;
	}
}

if(!function_exists('unslug')) {
    function unslug($slug) {
        $raw = str_replace('-', ' ', $slug);
        return ucwords($raw);
    }
}

if(!function_exists('post_timestamp')) {
    function post_timestamp($slug) {
        $seed = abs(crc32((string) $slug));
        $year = 2024 + ($seed % 2);
        $month = 1 + (($seed >> 3) % 12);
        $day = 1 + (($seed >> 9) % 28);
        $hour = ($seed >> 13) % 24;
        $minute = ($seed >> 17) % 60;
        return mktime($hour, $minute, 0, $month, $day, $year);
    }
}

function random_date() {
	$date = date('Y-m-d', strtotime( '+'.mt_rand(-90,0).' days'))." ".date('H', strtotime( '+'.mt_rand(0,24).' hours')).":".rand(1,59).":".rand(1,59);
	return date('M d, Y', strtotime($date));
}