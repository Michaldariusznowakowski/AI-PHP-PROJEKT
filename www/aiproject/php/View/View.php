<?php
require 'resources/html/base.html.php';
require 'resources/html/map.html.php';
require 'resources/html/nav.html.php';
require 'resources/html/search.html.php';
class View{
    public static function render($pageName, $viewParams = null){
        $bodyClass = $pageName;
        $main = View::processPage($pageName, $viewParams);
        extract($viewParams);
        ob_start();
        require 'resources/html/base.html.php';
        $html = ob_get_clean();
        echo $html;
    }
    public static function processPage($pageName, $viewParams = null){
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
    }
}