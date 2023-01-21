<?php
require 'resources/html/base.html.php'
require 'resources/html/map.html.php'
require 'resources/html/nav.html.php'
require 'resources/html/search.html.php'
class View{
    public static function render($pageName, $viewParams = null){
        require 'resources/config/paths.php';
        $output = Paths::get($page, $viewParams);
        echo $output;
    }
    private static function get($page, $viewParams){}
}