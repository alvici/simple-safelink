<?php

namespace App\Controllers;

class PostController extends Controller
{
    function __construct() {

    }
    public function index($slug=null) {
        $title = unslug($slug);
        $post = $slug.'.'.config('post_ext');
        $post_path = BASEPATH.'/resources/posts/';
        if(file_exists($post_path.$post)) {
            $data['post_content'] = $post_path.$post;
            $head['post_date'] = post_timestamp($slug);
            $is_not_found = false;
        } else {
            $data['post_content'] = $post_path.'404.php';
            $is_not_found = true;
        }
        $head['title'] = ($is_not_found) ? 'Page not found' : $title;
        $head['heading'] = ($is_not_found) ? 'Page not found' : $title;
        $head['is_not_found'] = $is_not_found;
        $head['type'] = 'post';
        
        $this->load_view('layouts.header', $head);
        $this->load_view('post', $data);
        $this->load_view('layouts.footer');
    }
    public function convert_ajax() {
        $links = \Flight::request()->getBody();
        $links = explode("\n", $links);
        $result = array();
        foreach ($links as $key => $link) {
            $link = trim($link);
            if ($link === '') continue;
            $result[] = base_url('?go='.bin2hex($link)); 
        }
        return app()->json([
            'success' => true,
            'data' => $result
        ]);
    }
    public function convert() {
        $head = [
            'title' => 'Link Converter',
            'heading' => config('app_name'),
            'type' => 'site',
            'subheading' => config('slogan'),
        ];
        $this->load_view('layouts.header', $head);
        $this->load_view('converter');
        $this->load_view('layouts.footer');
    }
    
}