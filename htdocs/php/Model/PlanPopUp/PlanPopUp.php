<?php
require_once 'php/Model/DataBase/Buildings.php';
require_once 'php/Model/DataBase/Floors.php';
require_once 'php/Model/DataBase/Rooms.php';
require_once 'php/Model/Database/EmployeesInRooms.php';
require_once 'php/Model/Scrapper/Scrapper.php';
require_once 'php/Model/Database/Employees.php';
class PlanPopUp implements functions_for_model {

    public function __construct() {
    }
    public function getViewParams($post) {
        $numerBudynku = $post['numerBudynku'];
        $numerPietra = $post['numerPietra'];
        $numerPomieszczenia = $post['numerPokoju'];
        $output = array();
        $output['pageName'] = "PlanPopUp";
        $output['HTML_ROOM'] = $this->getRoomInfo($numerBudynku, $numerPietra, $numerPomieszczenia);
        return $output;
    }
    private function getRoomInfo($numerBudynku, $numerPietra, $numerPomieszczenia) {
        // Temporary function
        $output = array();

        $DB_BUDYNEK = Buildings::findNumber($numerBudynku);

        $idbudynku = $DB_BUDYNEK->getBuildingID();

        $DB_FLOORS = Floors::findBuildingIDFloorNumber($numerBudynku ,$numerPietra);
        $idpietra = $DB_FLOORS->getFloorID();

        if ($idpietra == null) {
            $output['TYPE'] = "Błąd w bazie danych, nie ma takiego piętra.";
            return $output;
        }

        $DB_ROOMS = Rooms::findFloorIDNumberRoom($idpietra,$numerPomieszczenia);  
        if ($DB_ROOMS == null) {
            $output['TYPE'] = "Błąd w bazie danych, nie ma takiego pokoju.";
            return $output;
        }
        
        $idpomieszczenia = $DB_ROOMS->getRoomID();

        if ($idpomieszczenia == null) {
            $output['TYPE'] = "Brak informacji o tym pokoju.";
            return $output;
        }
        $typ = $DB_ROOMS->getRoomType();
        if ($typ == null) {
            $output['TYPE'] = "Błąd w bazie danych, nie ma takiego typu pokoju.";
            return $output;
        } elseif ($typ == 1) {
            $output['TYPE'] = "Sala wykładowa/laboratorium";
            return $output;
        } else {
            $output['TYPE'] = "Gabinet";
        }

        $DB_EMPLOYEES = EmployeesInRooms::findByRooms($idpomieszczenia);
        $len = count($DB_EMPLOYEES);
        print_r($DB_EMPLOYEES);
        for ($i = 0; $i < $len; $i++) {
            $idpracownika = $DB_EMPLOYEES[$i]->getEmployeeID();
            $DB_EMPLOYEES = Employees::find($idpracownika);
            $output['TEACHER-NAME'][$i] = $DB_EMPLOYEES->getName();
            $output['TEACHER-SURNAME'][$i] = $DB_EMPLOYEES->getSurname();
            $output['TEACHER-ACADEMIC-TITLE'][$i] = $DB_EMPLOYEES->getAcademicTitle();
            $DB_EMPLOYEES_IN_ROOMS = EmployeesInRooms::findByEmployees($idpracownika);
            $len = count($DB_EMPLOYEES_IN_ROOMS);
            for ($k = 0; $k < $len; $k++) {
                    $roomid=$DB_EMPLOYEES_IN_ROOMS[$k]->getRoomID();
                    $DB_ROOMS=Rooms::find($roomid);
                    $room = $DB_ROOMS->getRoomNumber();
                    $output['TEACHER-FAVORITE-ROOMS'][$i][$k] = $room;
            }   
        }
        $numOfteachers= count($output['TEACHER-NAME']);
        for ($i = 0; $i < $numOfteachers; $i++) {
            $output['TEACHER-SCHEDULE'][$i] = $this->getSchedule($output['TEACHER-NAME'][$i], $output['TEACHER-SURNAME'][$i]);
        }
        
        return $output;
    }
    private function getSchedule($name, $surname) {
        $currentTime= new DateTime();
        $currentTime->setTimezone(new DateTimeZone('Europe/Warsaw'));
        $today = $currentTime->format(DateTime::ATOM);
        $maxLastDate =  new DateTime();
        $maxLastDate->setTimezone(new DateTimeZone('Europe/Warsaw'));
        $maxLastDate->add(new DateInterval('P20D'));
        $end = $maxLastDate->format(DateTime::ATOM);
        $plan = Scrapper::getSchedule($name, $surname, $today, $end);
        $output = array();
        $output['TEACHER_CURRENT_LESSON'] = "Brak zajęć w tym momencie.";
        $output['TEACHER_NEXT_LESSON'] = "Brak zajęć w przeciągu najbliższych 20 dni.";
        if($plan != null) {
            if (is_array($plan) || is_object($plan)) {
                if ($plan[0]["end"] < $currentTime->format(DateTime::ATOM)) { // Obecne zajęcia
                    $output['TEACHER_CURRENT_LESSON'] = $plan[0]["title"] . "\n" . $plan[0]["room"];
                }
            if (count($plan) > 1) {
                $humanDateFormat = new DateTime($plan[1]["start"]);
                $humanDateFormat->setTimezone(new DateTimeZone('Europe/Warsaw'));
                $output['TEACHER_NEXT_LESSON'] = $plan[1]["title"]."\n".$plan[1]["room"]."\n".$humanDateFormat->format('d.m.Y H:i')."\n";
            }
        }
        return $output;
    }
}
}
