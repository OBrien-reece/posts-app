<?php

class Posts extends Controller {

    public function __construct() {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index() {

        $posts = $this->postModel->getPosts();
        $data = [
          'posts' => $posts,
        ];

        $this->view('posts/index', $data);
    }

    public function add() {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];

            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter a title';
            }

            if(empty($data['body'])) {
                $data['body_err'] = 'The textarea cannot be blank';
            }

            if(empty($data['title_err']) && empty($data['body_err'])) {

                if($this->postModel->addPosts($data)) {
                    redirect('posts');
                }
            }else {

                $this->view('posts/add', $data);
            }

        } else {
            $data = [
              'title' => '',
              'body' => '',
              'title_err' => '',
              'body_err' => '',
            ];
        }

        $this->view('posts/add', $data);
    }

    public function show($id) {
        $post = $this->postModel->findPostById($id);
        $user = $this->userModel->findUserById($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user,
        ];
        $this->view('posts/show', $data);
    }

    public function edit($id) {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'body' => trim($_POST['body']),
                'title' => trim($_POST['title']),
                'title_err' => '',
                'body_err' => ''
            ];

            if(empty($data['title'])) {
                $data['title_err'] = 'You cannot submit an empty title';
            }

            if(empty($data['body'])) {
                $data['body_err'] = 'Body cannot be blank';
            }

            if(empty($data['title_err']) && empty($data['body_err'])) {

                if($this->postModel->updatePost($data)) {
                    redirect('posts');
                }else {
                    die("Error");
                }
            }else {

                $this->view('posts/edit', $data);
            }

        }else {

            $post = $this->postModel->findPostById($id);

            if($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'body' => $post->body,
                'title' => $post->title,
            ];
            $this->view('posts/edit', $data);
        }
    }

    public function delete($id) {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $post = $this->postModel->findPostById($id);

            if($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }else {
                if($this->postModel->deletePost($id)) {
                    redirect('posts');
                }else {
                    die("Error");
                }
            }
        }else {
            redirect('posts');
        }
    }
}