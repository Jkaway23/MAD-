<?php
// Controller untuk menampilkan informasi tentang framework
class About extends Controller {
    
    public function index() {
        $data['title'] = 'About AIMVC Framework';
        $data['framework_name'] = 'AIMVC';
        $data['version'] = '1.0';
        $data['description'] = 'A simple MVC framework built with PHP';
        
        $this->view('about/index', $data);
    }
    
    public function features() {
        $data['title'] = 'Framework Features';
        $data['features'] = [
            'MVC Architecture',
            'URL Routing',
            'Database Connection',
            'Template System',
            'Clean URLs with .htaccess'
        ];
        
        $this->view('about/features', $data);
    }
}
?>
