<?php
//@Author: Michał Nowakowski
// Klasa interfejsów służy do przechowywania
// nazw zmiennych, które otrzymujemy w wiadomości 
// zwrotnej od użytkownika
// dzięki nim możemy przejść do kolejnych działań
class interfaces{
    public function __construct(){
    // $nazwa = array('postZmienna'=1/0) 
    // 1 - wymagana,
    // 0 - nie wymagana
    // Mapa gdy otrzyma numer budynku to wyswietla pozycje na mapie
    $Map=array('numerBudynku'=>0) ;
    // Plan wyswietla plan budynku wymaga numer budynku i pietra
    $Plan=array('numerBudynku'=>1,'numerPietro'=>1,'numerPokoju'=>0);
    // typ 1 - szukaj pomieszczenia, 2 - szukaj osoby
    $Search=array('typ'=>0);
    // Szukaj pomieszczenia wymaga numer budynku i numer pokoju
    $SearchPomieszczenie=array('numerBudynku'=>1,'numerPokoju'=>1);
    // Szukaj osoby wymaga imienia, nazwiska, godziny i dnia
    $SearchPracownik=array('imie'=>1,'nazwisko'=>1,'godzina'=>1, 'dzien'=>1);
    // AdminPanel wymaga loginu i hasla
    $AdminPanel=array('login'=>1,'haslo'=>1);
    // AdminSession wymaga sekretu
    $AdminSession=array('secret'=>1);
    }
    // Funkcja zwraca tablice z nazwami zmiennych
    function getInterface($interfaceName){
        switch($interfaceName){
            case 'Map':
                $interface = $Map;
                break;
            case 'Plan':
                $interface = $Plan;
                break;
            case 'Search':
                $interface = $Search;
                break;
            case 'SearchPomieszczenie':
                $interface = $SearchPomieszczenie;
                break;
            case 'SearchPracownik':
                $interface = $SearchPracownik;
                break;
            case 'AdminPanel':
                $interface = $AdminPanel;
                break;
            case 'AdminSession':
                $interface = $AdminSession;
                break;
            default:
                $interface = null;
                break;
        }
        return $interface;
    }
}