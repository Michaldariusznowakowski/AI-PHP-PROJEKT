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
        switch ($pageName) {
            case 'Map':
                extract($viewParams);
                ob_start();
                require 'resources/html/map.html.php';
                $main = ob_get_clean();
                break;
            case 'Search':
                extract($viewParams);
                ob_start();
                require 'resources/html/search.html.php';
                $main = ob_get_clean();
                break;
            case 'Plan':
                extract($viewParams);
                ob_start();
                require 'resources/html/plan.html.php';
                $main = ob_get_clean();
                break;
            case 'Mainpage':
                extract($viewParams);
                ob_start();
                require 'resources/html/mainpage.html.php';
                $main = ob_get_clean();
                break;
            default:
                throw new Exception("Page not found");
                break;
        }
        return $main;
    }
}