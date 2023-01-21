<?php
class View{
    # Disable constructor
    private function __construct() {}
    # Function to render page
    public static function render($pageName, $viewParams = null){
        if ($viewParams == null) {
            $viewParams = [];
        }
        $HTML_PAGE_NAME = $pageName;
        $main = View::processPage($pageName, $viewParams);
        extract($viewParams);
        ob_start();
        require 'resources/html/base.html.php';
        $html = ob_get_clean();
        echo $html;
    }
    # Function to process page
    public static function processPage($pageName, $viewParams){
        # Zabezpieczenie przeciwko nadpisania zmiennych używanych w tej funkcji
        if (isset($viewParams['pageName'])) {
            unset($viewParams['pageName']);
        }
        if (isset($viewParams['main'])) {
            unset($viewParams['main']);
        }

        extract($viewParams);
        
        switch ($pageName) {
            case 'Mapa':
                require 'resources/html/map.html.php';
                break;
            case 'Szukaj':
                require 'resources/html/search.html.php';
                break;
            case 'Plan':
                require 'resources/html/plan.html.php';
                break;
            case 'Admin Panel':
                require 'resources/html/adminpanel.html.php';
                break;
            default:
                require 'resources/html/mainpage.html.php';
                break;
        }
        $main = ob_get_clean();
        return $main;
    }
}