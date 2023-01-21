<?php
require 'php/Model/AdminPanel/AdminPanel.php';
require 'php/Model/Map/Map.php';
require 'php/Model/Plan/Plan.php';
require 'php/Model/Search/Search.php';
require 'php/View/View.php';


class Model{
    private $Map=null;
    private $Search=null;
    private $Plan=null;
    private $AdminPanel=null;

    public function __construct(){
        $this->Map = new Map();
        $this->Search = new Search();
        $this->Plan = new Plan();
        $this->AdminPanel = new AdminPanel();
    }

    private function ViewRender($page,$viewParams){
        View::render($page,$viewParams);
    }

    private function getViewParams($page,$post){
        switch($page){
            case 'Map':
                return $this->Map->getViewParams($post);
            case 'Search':
                return $this->Search->getViewParams($post);
            case 'Plan':
                return $this->Plan->getViewParams($post);
            case 'AdminPanel':
                return $this->AdminPanel->getViewParams($post);
        }
    }
    
    public function getPage($page, $posts) {
        $viewParams = $this->getViewParams($page, $posts);
        $this->ViewRender($page, $viewParams);
    }

    public function StartPage(){
        View::render('Mainpage');
    }
    



}