<?php
class Project extends Controller {
    public function index() {
        echo "Welcome to the Project/index";
    }
    
    public function news() {
        $data['title'] = 'News Page';
        $this->view('project/news', $data);
    }
}