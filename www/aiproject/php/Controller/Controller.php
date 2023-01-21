<?php
require 'resources/config/interfaces.php';
require 'php/Model/Model.php';
class Controller{
    //constructor tworzacy obiekt modelu
    public function __construct(){
        $this->model = new Model();
    }
    // metoda sprawdzająca wstępnie poprawność danych
    // jeśli dane są poprawne to przekazuje je do modelu
    public function process(){
        if(isset($_POST[page])){
            $page = $_POST[page];
            // sprawdzamy czy wszystkie wymagane zmienne są ustawione
            if($this->checkIfPostSet($page)){
                $posts = $this->getPosts($page);
                $this->model->getPage($page, $posts);
            }else{
                // jeśli nie to wyświetlamy stronę startową
                $this->model->StartPage();
            }
        }else{
            $this->model->StartPage();
        }
    }
    // funkcja sprawdzająca czy wszystkie
    // wymagane zmienne są ustawione
    function checkIfPostSet($interfaceName){
        $interface = interfaces::getInterface($interfaceName);
        // jeśli interfejs wymagany nie istnieje to zwracamy false
        foreach($interface as $key => $value){
            if($value==1){
                if(!isset($_POST[$key])){
                    return false;
                }
            }
        }
        return true;
    }
    // funkcja pobierająca dane z POST
    // na podstawie interfejsu
    function getPosts($interfaceName){
        $interface = interfaces::getInterface($interfaceName);
        $posts = array();
        foreach($interface as $key => $value){
            if($value==1){
                if(isset($_POST[$key])){
                    $posts[$key] = $_POST[$key];
                }
            }
        }
        return $posts;
    }
}