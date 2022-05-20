<?php
session_start();

function redirect($location) {
    header("Location:" .URLROOT. '/' .$location);
}

function isLoggedIn() {
    if(isset($_SESSION['user_id'])) {
        return true;

    }else {
        return false;
    }
}