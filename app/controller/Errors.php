<?php
// controllers/Errors.php

class Errors extends Controller {

    public function index() {
        // Default method → 404
        $this->error404();
    }

    public function error403() {
        $this->view('error/403', ['title' => 'Access Forbidden']);
    }

    public function error404() {
        $this->view('error/404', ['title' => 'Page Not Found']);
    }
}
