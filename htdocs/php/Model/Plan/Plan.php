<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Scrapper/Scrapper.php';
require_once 'php/Model/Database/Buildings.php';
require_once 'php/Model/Database/Floors.php';
class Plan implements functions_for_model
{
    public function getViewParams($post)
    {
        if (isset($post['numerPietro'])) {
            $floorNumber = $post['numerPietro'];
        } else {
            $floorNumber = 0;
        }
        $buildingNumber = $post['numerBudynku'];
        
        $floorsList = $this->getAvailableFloors($buildingNumber);

        $svgPlan = $this->getPlan($buildingNumber, $floorNumber);

        if (isset($post['numerPokoju'])) {
            $roomNumber = $post['numerPokoju'];
        } else {
            $roomNumber = null;
        }
        
        $output = array(
            "pageName" => "Plan",
            "HTML_BULDING_NUMBER" => $buildingNumber,
            "HTML_SVG_PLAN" => $svgPlan,
            "HTML_FLOOR_NUMBER" => $floorNumber,
            "HTML_FLOOR_LIST" => $floorsList,
            "HTML_ROOM_NUMBER" => $roomNumber
            );
        return $output;
    }
    private function getPlanFilePath($buildingNumber, $floorNumber = 0){
        $DB_BULDINGS = Buildings::findNumber($buildingNumber);
        if ($DB_BULDINGS == null) return null;
        $buldingID = $DB_BULDINGS->getBuildingID();
        $DB_FLOORS = Floors::findBuildingIDFloorNumber($buldingID, $floorNumber);
        if ($DB_FLOORS == null) return null;
        $photoUrl = $DB_FLOORS->getPhotoUrl();
        if ($photoUrl == null) return null;
        if ($photoUrl == "empty") return null;
        if (file_exists($photoUrl)) return $photoUrl;
        return null;
    }
    private function getPlan($buildingNumber, $floorNumber){
        $filePath = $this->getPlanFilePath($buildingNumber, $floorNumber);
        if ($filePath == null) return null;
        $file = fopen($filePath, "r");
        $fileContent = fread($file, filesize($filePath));
        fclose($file);
        return $fileContent;
    }
    private function getAvailableFloors($buildingNumber){
        $DB_BULDINGS = Buildings::findNumber($buildingNumber);
        $buldingID = $DB_BULDINGS->getBuildingID();
        $DB_FLOORS = Floors::findBuildingID($buldingID);
        $floorsList = array();
        foreach($DB_FLOORS as $floor){
            $floorsList[] = $floor->getFloorNumber();
        }
        return $floorsList;
    }
}