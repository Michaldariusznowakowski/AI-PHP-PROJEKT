<?php
require_once 'resources/config/interfaces.php';
require 'php/View/View.php';
foreach(interfaces::$interfaceNames as $name => $interface) {
    if ($interface == "MainPage") {
        continue;
    }
    require 'php/Model/'.$interface.'/'.$interface.'.php';
}

class Model{
    private $models;
    public function __construct(){
        foreach(interfaces::$interfaceNames as $name => $interface) {
            if ($interface == "MainPage") {
                continue;
            }
            eval('$int = new '.$interface.'();');
            $this->models[$interface] = $int;
            
        }
    }

    private function ViewRender($page,$viewParams){
        View::render($viewParams);
    }

    private function getViewParams($page,$post){
        print(count($this->models));
        eval('$viewParams=$this->models[$page]->getViewParams($post);');
        return $viewParams;
    }
    
    public function getPage($page, $post) {
        $viewParams = $this->getViewParams($page, $post);
        $this->ViewRender($page, $viewParams);
    }

    public function StartPage(){
        View::render();
    }
    



}