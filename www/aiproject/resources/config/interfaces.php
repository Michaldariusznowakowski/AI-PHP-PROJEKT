<?php
//@Author: Michał Nowakowski
// Klasa interfejsów służy do przechowywania
// nazw zmiennych, które otrzymujemy w wiadomości 
// zwrotnej od użytkownika
// dzięki nim możemy przejść do kolejnych działań
class interfaces{
    # Disable constructor
    private function __construct() {}
    // $nazwa = array('postZmienna'=1/0) 
    // 1 - wymagana,
    // 0 - nie wymagana
    // Mapa gdy otrzyma numer budynku to wyswietla pozycje na mapie
    private static $Map=array('numerBudynku'=>0) ;
    // Plan wyswietla plan budynku wymaga numer budynku i pietra
    private static $Plan=array('numerBudynku'=>1,'numerPietro'=>0,'numerPokoju'=>0);
    // Szukaj wyswietla wyniki wyszukiwania
    private static $Search=array('typ'=>0, 'numerBudynku'=>0,'numerPokoju'=>0, 'imie'=>0,'nazwisko'=>0,'godzina'=>0, 'dzien'=>0);
    // AdminPanel wymaga loginu i hasla
    private static$AdminPanel=array('login'=>0,'haslo'=>0,'secret'=>0);
    // Funkcja zwraca tablice z nazwami zmiennych
    public static function getInterface($interfaceName){
        switch($interfaceName){
            case 'Map':
                $interface = interfaces::$Map;
                break;
            case 'Plan':
                $interface = interfaces::$Plan;
                break;
            case 'Search':
                $interface = interfaces::$Search;
                break;
            case 'SearchPomieszczenie':
                $interface = interfaces::$SearchPomieszczenie;
                break;
            case 'SearchPracownik':
                $interface = interfaces::$SearchPracownik;
                break;
            case 'AdminPanel':
                $interface = interfaces::$AdminPanel;
                break;
            case 'AdminSession':
                $interface = interfaces::$AdminSession;
                break;
            default:
                $interface = null;
                break;
        }
        return $interface;
    }
}