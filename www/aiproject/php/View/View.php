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
        $HTML_MAIN = View::processPage($pageName, $viewParams);
        extract($viewParams);
        ob_start();
        require 'resources/html/base.html.php';
        $HTML = ob_get_clean();
        echo $HTML;
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

        
        
        # if interfaces_name == pageName foreach
        foreach (interfaces::$interfaceNames as $name => $interface) {
            if ($name == $pageName) {
                extract($viewParams);
                require 'resources/html/' . $interface . '.html.php';
                break;
            }
        }
        $HTML_MAIN = ob_get_clean();
        return $HTML_MAIN;
    }
}