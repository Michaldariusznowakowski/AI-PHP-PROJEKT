<?php 
require_once 'php/Model/interface.php';
require_once 'php\Model\Database\Buildings.php';

class Map implements functions_for_model
{
    private function GetBuildingData()
    {
        $a = new Buildings();
        $buildingsArray = $a->findAll();
        $a->delete();

        $buildingLocations = "[";
        $buildingData = "[";
        for ($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator) {
            // get building information from database
            $buildingDescription = $buildingsArray[$buildingIterator]->getAdditionalDesc(); 
            $adress = $buildingsArray[$buildingIterator]->getBuildingAddress();
            $buildingNumber = $buildingsArray[$buildingIterator]->getBuildingNumber();
            $buildingData .= <<<DATA
            ["$buildingDescription", "$buildingNumber" , "$adress"],
            DATA;    

            // get building location from database
            $xLoc = $buildingsArray[$buildingIterator]->getLatitude();
            $yLoc = $buildingsArray[$buildingIterator]->getLongitude();  
            $buildingLocations .= <<<LOC
            [$xLoc, $yLoc],
            LOC;
        }
        $buildingData .= "['','','']]";
        $buildingLocations .= "[-1,-1]]";
        return [$buildingLocations,$buildingData];
    }

    public function getViewParams($post)
    {
        $a = new Buildings();
        $buildingsArray = $a->findAll();
        $a->delete();
        
        $output = array("MAP_MARKERS" => "");
        $output['MAP_BUTTON_CASES'] = "";
        $output['BUILDING_BUTTONS'] = "";
        $output["BUILDING_LOCATIONS"] = "";
        $output["BUILDING_DATA"] = "";
        $output["status"] = "OK";

        $buildingDataAndLocation = $this->GetBuildingData();
        $output["BUILDINGS_LOCATIONS"] = $buildingDataAndLocation[0];
        $output["BUILDINGS_DATA"] = $buildingDataAndLocation[1];

        // crate js, that will put markers on a map
        for($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator)
        {
            // get building location from database
            $xLoc = $buildingsArray[$buildingIterator]->getLatitude();
            $yLoc = $buildingsArray[$buildingIterator]->getLongitude();  

            // create js code as string 
            $output["MAP_MARKERS"] .= <<<MARK
                var marker = L.marker([$xLoc, $yLoc]).addTo(map);
                marker.on('click', onPolyClick);
                markers.push(marker);
                var popupContent = "";
                popupTable.push(popupContent);
                marker.bindPopup(popupContent,{
                    keepInView: true,
                    closeButton: false
                    }).openPopup();
                MARK;
        }

        // crate cases for buttons, that will put markers on a map
        for($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator)
        {
            $xLoc = $buildingsArray[$buildingIterator]->getLatitude();
            $yLoc = $buildingsArray[$buildingIterator]->getLongitude();  
            $output['MAP_BUTTON_CASES'] .= <<<CASE
                case $buildingIterator:
                    map.panTo([$xLoc,$yLoc],16);
                break; \n
            CASE;
        }


        for($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator)
        {
            $BuildingName = $buildingsArray[$buildingIterator]->getAdditionalDesc();
            $output['BUILDING_BUTTONS'] .= <<<BUTTON
                <button onClick="ButtonOnClick($buildingIterator)"> <p>$BuildingName</p></button>
            BUTTON;
        }
        $output["status"] = "OK";
        $output["pageName"] = "Map";

        return $output;
    }
}