<?php

namespace App\Controllers;

use \App\Controllers\PostController;

class HomeController extends Controller
{
    function __construct() {

    }
    public function index() {
        if($this->get('go')) {
            $random = $this->random_post($this->get('go'));
            app()->redirect($random); exit;
        }
        $head = [
            'title' => 'Safelink Generator',
            'heading' => config('app_name'),
            'type' => 'site',
            'subheading' => config('slogan'),
        ];
        $allpost = $this->get_all_post();
        // echo "<pre>";
        // print_r($allpost); exit;
        $this->load_view('layouts.header', $head);
        $this->load_view('home', ['allPost' => $allpost]);
        $this->load_view('layouts.footer');
    }
    
    private function get_all_post() {
        $files = glob(BASEPATH . '/resources/posts/*.' . config('post_ext'));
        if (!$files) return array();
        $list = array();
        foreach ($files as $file) {
            $slug = pathinfo($file, PATHINFO_FILENAME);
            $list[] = [
                'slug' => $slug,
                'date' => post_timestamp($slug),
            ];
        }
        usort($list, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });
        return $list;
    }
    private function random_post($link) {
        $allPost = $this->get_all_post();
        if (empty($allPost)) return base_url();
        $post = $allPost[array_rand($allPost)];
        return $post['slug'] . "?go=$link";
    }
    public function fullpage() {
        $head = [
            'title' => 'Auto Safelink Script',
            'heading' => config('app_name'),
            'type' => 'site',
            'subheading' => config('slogan'),
        ];
        $this->load_view('layouts.header', $head);
        $this->load_view('fullpage');
        $this->load_view('layouts.footer');
    }
}
