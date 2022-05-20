<?php

class Pages extends Controller {

    public function __construct() {
        //      if(!isset($_SESSION['user_id'])) {
        //     redirect('users/login');
        // }
     
    }

    public function index() {
        if(isloggedIn()) {
            redirect('posts');
        }
        $this->view('pages/index');
    }
    public function about() {
        $data = [
            'title' => 'About OBR EXEC',
            'version' => '2.0',
            'author' => "O'Brien Reece",
        ];
        $this->view('pages/about', $data);
    }

}