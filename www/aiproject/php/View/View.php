<?php
class View{
    # Disable constructor
    private function __construct() {}
    # Function to render page
    public static function render($viewParams = null){
        $HTML = View::processPage($viewParams);
        echo $HTML;
    }
    # Function to process page
    public static function processPage($viewParams){
        if ($viewParams == null) $viewParams = array('pageName' => 'mainpage');
        if (!isset($viewParams['pageName'])) $viewParams['pageName'] = 'mainpage';
        $HTML = '';
        $HTML_PAGE = $viewParams['pageName'];
        // find name of interface
        $HTML_PAGE_NAME = interfaces::getInterfaceName($HTML_PAGE);
        // check if page needs footer and navbar
        if (interfaces::getOwnHTML($HTML_PAGE) == true) {
            $HTML_FOOTER = '';
            $HTML_NAVBAR = '';
        } else {
            ob_start();
            require 'resources/html/footer.html.php';
            $HTML_FOOTER = ob_get_clean();
            ob_start();
            require 'resources/html/navbar.html.php';
            $HTML_NAVBAR = ob_get_clean();
        }
        ob_start();
        extract($viewParams);
        require 'resources/html/'.strtolower($HTML_PAGE).'.html.php';
        $HTML_MAIN = ob_get_clean();
        if (interfaces::getOwnHTML($HTML_PAGE)) {
            return $HTML_MAIN;
        }
        ob_start();
        require 'resources/html/base.html.php';
        $HTML = ob_get_clean();
        return $HTML;
    }
}