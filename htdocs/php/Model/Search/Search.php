<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Database/Buildings.php';
require_once 'php/Model/Database/Floors.php';
require_once 'php/Model/Database/Rooms.php';
require_once 'php/Model/Database/Employees.php';
require_once 'php/Model/Database/EmployeesInRooms.php';
class Search implements functions_for_model
{
    public function getViewParams($post)
    {
        $type = 0;
        // numerBudynku, numerPokoju -> type = 0
        // imie, nazwisko -> type = 1

        $output = array();
        if (isset($post['numerBudynku']) && isset($post['numerPokoju'])) {
            $buldingNumber = $post['numerBudynku'];
            $roomNumber = $post['numerPokoju'];
            $type = 1;
        } else if (isset($post['imie']) && isset($post['nazwisko'])) {
            $name = $post['imie'];
            $surname = $post['nazwisko'];
            $type = 2;
        } else {
            $type = null;
        }
        if ($type == 1) {
            $rooms = $this->searchByRoom($buldingNumber, $roomNumber);
            if ($rooms == null) {
                $output["HTML_SEARCH_RESULT"]["FOUND"] = false;
            } else {
                $output["HTML_SEARCH_RESULT"]["RESULT"]= $rooms;
                $output["HTML_SEARCH_RESULT"]["FOUND"] = true;
            }
        } else if ($type == 2) {
            $rooms = $this->searchByPerson($name, $surname);
            if ($rooms == null) {
                $output["HTML_SEARCH_RESULT"]["FOUND"] = false;
            } else {
                $output["HTML_SEARCH_RESULT"]["RESULT"]= $rooms;
                $output["HTML_SEARCH_RESULT"]["FOUND"] = true;
            }
        }
        $output["HTML_BUILDINGS_LIST"] = $this->getListOfBuildings();
        $output["pageName"] = "Search";
        return $output;
    }
    private function getListOfBuildings(){
        $DB_BUILDINGS = Buildings::findAll();
        if ($DB_BUILDINGS == null) return null;
        $buildingsList = array();
        foreach ($DB_BUILDINGS as $DB_BUILDING) {
            $buildingsList[] = $DB_BUILDING->getBuildingNumber();
        }
        return $buildingsList;
    }
    private function searchByRoom($buldingNumber, $roomNumber){
        $DB_BUILDINGS = Buildings::findNumber($buldingNumber);
        if ($DB_BUILDINGS == null) return null;
        $DB_FLOORS = Floors::findBuildingID($DB_BUILDINGS->getBuildingID());
        if ($DB_FLOORS == null) return null;
        $len_floors= count($DB_FLOORS);
        for ($i = 0; $i < $len_floors; $i++) {
            $DB_ROOMS = Rooms::findFloorID($DB_FLOORS[$i]->getFloorID());
            $this_floor = $DB_FLOORS[$i]->getFloorNumber();
            if ($DB_ROOMS == null) return null;
            $len_rooms = count($DB_ROOMS);
            for ($j = 0; $j < $len_rooms; $j++) {
                if ($DB_ROOMS[$j]->getRoomNumber() == $roomNumber) {
                    $output[0] = array(
                        "BUILDING_NUMBER" => $buldingNumber,
                        "ROOM_NUMBER" => $roomNumber,
                        "FLOOR_NUMBER" => $this_floor,
                        );
                    return $output;
                }
            }
        }
        return null;
    }
    private function searchByPerson($name, $surname){
        $DB_EMPLOYEES = Employees::findNameSurname($name, $surname);
        if ($DB_EMPLOYEES == null) return null;
        $DB_EMPLOYEES_IN_ROOMS = EmployeesInRooms::findByEmployees($DB_EMPLOYEES->getEmployeeID());
        if ($DB_EMPLOYEES_IN_ROOMS == null) return null;
        $rooms = array();
        $floors = array();
        $buildings = array();
        foreach ($DB_EMPLOYEES_IN_ROOMS as $DB_EMPLOYEES_IN_ROOM) {
            $room = $DB_EMPLOYEES_IN_ROOM->getRoomID();
            $DB_ROOM = Rooms::find($room);
            $rooms[] = $DB_ROOM->getRoomNumber();
            $floor = $DB_ROOM->getFloorID();
            $DB_FLOOR = Floors::find($floor);
            $floors[] = $DB_FLOOR->getFloorNumber();
            $building = $DB_FLOOR->getBuildingID();
            $DB_BUILDING = Buildings::find($building);
            $buildings[] = $DB_BUILDING->getBuildingNumber();
        }
        $output = array();
        for ($i = 0; $i < count($rooms); $i++) {
            $output[$i] = array(
                "BUILDING_NUMBER" => $buildings[$i],
                "ROOM_NUMBER" => $rooms[$i],
                "FLOOR_NUMBER" => $floors[$i],
                );
        }
        return $output;
    }
}