<?php

class Users extends Controller {

    public function __construct() {

        $this->userModel = $this->model('User');
    }

    public function register() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
              'name' => trim($_POST['name']),
              'email' => trim($_POST['email']),
              'password' => trim($_POST['password']),
              'confirm_password' => trim($_POST['confirm_password']),
              'name_err' => '',
              'email_err' => '',
              'password_err' => '',
              'confirm_password_err' => '',
            ];

            //validate name
            if(empty($data['name'])) {
                $data['name_err'] = "Please enter the name";

            }elseif (strlen($data['name']) < 3) {
                $data['name_err'] = "Name should be 3 characters and above";
            }

            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } else {
                if($this->userModel->findUserByEmail($data['email'])) {

                    $data['email_err'] = 'The E-Mail already Exists';
                }
            }

            if(empty($data['password'])) {
                $data['password_err'] = "Please enter the password";

            }elseif (strlen($data['password']) < 6) {
                $data['password_err'] = "Password should be 6 characters long";
            }

            // Validate Confirm Password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            //check whether there are no errors
            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                //Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if($this->userModel->registerUser($data)) {
                    redirect('users/login');
                }
            }else {
                //load views with errors
                $this->view('/users/register', $data);
            }

        } else {
            //init data again so that when the page reloads it wont be an empty form
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',

            ];
            $this->view('/users/register', $data);
        }
    }

    public function login() {
        if(isLoggedIn()) {
            redirect('posts');
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            if(empty($data['email'])) {
                $data['email_err'] = "Please enter an email address";
            }
            if(empty($data['password'])) {
                $data['password_err'] = "Please enter a Password";
            }

                //check the email
                if($this->userModel->findUserByEmail($data['email'])) {
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    if($loggedInUser) {
                        $this->createSession($loggedInUser);
                    }else {
                        $data['password_err'] = "Invalid Password. Please try again";
                        $this->view('users/login', $data);
                    }
                }else {
                    $data['email_err'] = 'No user with those credentials exists';
                }

            if(empty($data['email_err']) && empty($data['password_err'])) {

                die('Success');
            }else {
                //load view with errors
                $this->view('/users/login', $data);
            }

        }else {

            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('users/login', $data);
        }

    }

    //createUserSession
    public function createSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('posts');

    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }
}