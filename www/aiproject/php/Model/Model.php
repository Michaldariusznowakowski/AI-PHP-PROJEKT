<?php
require 'php/Model/AdminPanel.php';
require 'php/Model/Map.php';
require 'php/Model/Plan.php';
require 'php/Model/Search.php';
require 'php/view/View.php';


class Model{
    private $Map=null;
    private $Search=null;
    private $Plan=null;

    public function __construct(){
        $this->Map = new Map();
        $this->Search = new Search();
        $this->Plan = new Plan();
    }

    public function StartPage(){
        View::render('StartPage');
    }

    function ViewRender($page,$viewParams){
        View::render($page,$viewParams);
    }

    function getViewParams($page,$post){
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
    
    function getPage($page, $posts) {
        $viewParams = $this->getViewParams($page, $posts);
        $this->ViewRender($page, $viewParams);
    }

    



}