<?php
//@Author: Michał Nowakowski
// Klasa interfejsów służy do przechowywania
// nazw zmiennych, które otrzymujemy w wiadomości 
// zwrotnej od użytkownika
// dzięki nim możemy przejść do kolejnych działań
class interfaces{
    // Disable constructor
    private function __construct() {}
    
    // Nazwy zmiennych w tablicy
    public static $interfaceNames=array(
        'Strona Główna' => 'mainpage',
        'Mapa' => 'map',
        'Plan' => 'plan',
        'Szukaj' => 'search',
        'Admin Panel' => 'adminpanel'
    );

    // $nazwa = array('postZmienna'=1/0) 
    // 1 - wymagana,
    // 0 - nie wymagana
    // Mapa gdy otrzyma numer budynku to wyswietla pozycje na mapie
    private static $map=array('numerBudynku'=>0) ;
    // Plan wyswietla plan budynku wymaga numer budynku i pietra
    private static $plan=array('numerBudynku'=>1,'numerPietro'=>0,'numerPokoju'=>0);
    // Szukaj wyswietla wyniki wyszukiwania
    private static $search=array('typ'=>0, 'numerBudynku'=>0,'numerPokoju'=>0, 'imie'=>0,'nazwisko'=>0,'godzina'=>0, 'dzien'=>0);
    // AdminPanel wymaga loginu i hasla
    private static $adminpanel=array('login'=>0,'haslo'=>0,'secret'=>0);
    // Strona główna
    private static $mainpage=array('page'=>0);
    // Funkcja zwraca tablice z nazwami zmiennych
    public static function getInterface($interfaceName){
        foreach (interfaces::$interfaceNames as $name => $interface) {
            if ($name == $interfaceName) {
                $interface = 'interfaces::$'.$interface;
                $interface = eval('return '.$interface.';');
                break;
            } else {
                $interface = null;
            }
        }
        return $interface;
    }
}