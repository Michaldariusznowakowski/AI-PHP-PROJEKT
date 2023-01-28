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
        'Strona Główna' => 'MainPage',
        'Mapa' => 'Map',
        'Plan' => 'Plan',
        'Szukaj' => 'Search',
        'Admin Panel' => 'AdminPanel',
        "Plan PopUp" => "PlanPopUp"
    );

    // Ta zmienna przechowuje interfejsy, które zostaną wyświetlone 
    // bez navbara, footera i base.html.php 
    // Przykład: 'planpopup'  
    //   wyświetli tylko planpopup.html.php (Popup zostanie użyty w Plan.html.php przy uzyciu JS jako dymek)
    private static $ownHTML=array('planpopup');

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
    private static $adminpanel=array('login'=>1,'haslo'=>1,'secret'=>0);
	// AdminLogin 
    private static $adminlogin=array('login'=>0,'haslo'=>0,'secret'=>0);
    // Strona główna
    private static $MainPage=array('page'=>0);
    // Plan PopUp
    private static $PlanPopUp=array('numerBudynku'=>1,'numerPietro'=>1,'numerPokoju'=>1);
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
    public static function getInterfaceName($interfaceName){
        foreach (interfaces::$interfaceNames as $name => $interface) {
            if ($name == $interfaceName) {
                return $interface;
            }
        }
        return null;
    }

    // Funkcja zwraca true jeśli interfejs ma własny HTML
    public static function getOwnHTML($interfaceName){
        foreach (interfaces::$ownHTML as $name) {
            if ($name == $interfaceName) {
                return true;
            }
        }
        return false;
    }
}
