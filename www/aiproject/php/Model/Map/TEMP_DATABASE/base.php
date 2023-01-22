<?php
require_once("room.php");
require_once("person.php");
require_once("floor.php");
require_once("building.php");

// moglibyśmy czytać z bazy danych ( o ile wymagana, nie czytałem wymagań xd )
$json_Buildings = ""; // needed for future 
$buildingsArray = array();
// TEST
// przykładowe osoby
$person1 = new person("1", "1", 1, 1, "student");
$person2 = new person("2", "2", 2, 2, "student");
$person3 = new person("3", "3", 3, 3, "student");
$person4 = new person("4", "4", 4, 4, "Teacher");

// tworzenie pokoi ( moznaby ladniej jakas petla, ale to tylko test xD )
$test = new room(101);
$test2 = new room(102, $person3);
$test3 = new room(103);
$test4 = new room(104);

$test5 = new room(204);
$test6 = new room(202, $person3);
$test7 = new room(203);
$test8 = new room(204);

$test9 = new room(301);
$test10 = new room(302, $person3);
$test11 = new room(303);
$test12 = new room(304);


// ustawwianie właściciela pokoju
$test->setRoomOwner($person1);
// dodawanie pokoi do pokoju przed wstawieniem na piętro
$test->setPersonsInRoom($person1,$person2,$person3,$person4);

// dodawanie pokoi do piętra
$testFloor = new floor(1,$test,$test2,$test3,$test4);
$testFloor1 = new floor(2,$test5,$test6,$test7,$test8);
$testFloor2= new floor(3,$test9,$test10,$test11,$test12);

// test ustwień po dodaniu na piętro 
$test3->setRoomOwner($person4);
$test3->setPersonsInRoom($person2,$person3);

//echo $testFloor; // mozna wypisywac sobie dane, poniwaz ( person, room, floor maja przeciazone operatory rzutowania na string)

// wynik testu: dane mozna edytowac w dowolnym momencie, zmiana ustawien pojedynczego pokoju, zmienia ustawienia pokoju na pietrze


// stworzenie 2 przykladowych budynkow ( mozna dodac wiecej, przyciski, znaczniki i kwadraty zostana wstawione automatycznie)
$WI1 = new building("WI1",53.44699845087021,14.49236040997529,0.0005,0.0005,"zolnierska","49","71-899","Szczecin",$testFloor,$testFloor1);
$WI2 = new building("WI2",53.44864696404248,14.491047783223161,0.0005,0.0005,"zolnierska","52","71-899","Szczecin",$testFloor,$testFloor1,$testFloor2);
$WI3 = new building("WI3",53.45068696404248,14.493097783223161,0.0005,0.0005,"zolnierska","52","71-899","Szczecin",$testFloor,$testFloor1,$testFloor2);

array_push($buildingsArray, $WI1, $WI2);
// TEST