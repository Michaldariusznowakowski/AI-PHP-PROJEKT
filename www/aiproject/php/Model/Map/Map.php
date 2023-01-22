<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Map/TEMP_DATABASE/base.php';
class Map implements functions_for_model
{
    // TODO 
    // CHANGE FOR DATABASE
    private function GetBuildingData()
    {
       
        global $buildingsArray;
        $buildingLocations = "[";
        $buildingData = "[";
        for ($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator) {
            $buildingLocation = $buildingsArray[$buildingIterator]->getLocation();
            $buildingName = $buildingsArray[$buildingIterator]->getName();
            $xLoc = $buildingLocation->xLocation;
            $yLoc = $buildingLocation->yLocation;   

 
            $street = $buildingLocation->street;
            $bNumber = $buildingLocation->BuildingNumber;
            $pCode = $buildingLocation->PostalCode;
            $city = $buildingLocation->City;


            $buildingLocations .= <<<LOC
            [$xLoc, $yLoc],
            LOC;

            $buildingData .= <<<DATA
            ["$buildingName", "$street", "$bNumber" , "$pCode" , "$city"],
            DATA;
            // if(bccomp($x, $xLoc, 12) && bccomp($y, $yLoc, 12))
            // {
            //     return $buildingIterator;
            // }        
        }
        $buildingData .= "['','','','','']]";
        $buildingLocations .= "[-1,-1]]";
        return [$buildingLocations,$buildingData];
    }

    // TODO 
    // CHANGE FOR DATABASE

    public function getViewParams($post)
    {
        global $buildingsArray;
        $output = array("MAP_MARKERS" => "");
        $output['MAP_BUTTON_CASES'] = "";
        $output['BUILDING_BUTTONS'] = "";
        $output["BUILDING_LOCATIONS"] = "";
        $output["BUILDING_DATA"] = "";
        $output["status"] = "OK";

        $buildingDataAndLocation = $this->GetBuildingData();
        $output["BUILDINGS_LOCATIONS"] = $buildingDataAndLocation[0];
        $output["BUILDINGS_DATA"] = $buildingDataAndLocation[1];
        
        //TODO REWRITE FOR DB
        //CHANGE AFTER DATABASE WORKS
 
       

        // crate js, that will put markers on a map
        for($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator)
        {
            $buildingLocation = $buildingsArray[$buildingIterator]->getLocation();
            $xLoc = $buildingLocation->xLocation;
            $yLoc = $buildingLocation->yLocation;
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
            $buildingLocation = $buildingsArray[$buildingIterator]->getLocation();
            $xLoc = $buildingLocation->xLocation;
            $yLoc = $buildingLocation->yLocation;
            $output['MAP_BUTTON_CASES'] .= <<<CASE
                case $buildingIterator:
                    map.panTo([$xLoc,$yLoc],18);
                break; \n
            CASE;
        }


        for($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator)
        {
            $BuildingName = $buildingsArray[$buildingIterator]->getName();
            $output['BUILDING_BUTTONS'] .= <<<BUTTON
                <button onClick="ButtonOnClick($buildingIterator)"> <p>$BuildingName</p></button>
            BUTTON;
        }


        // END DATABASE
        # How to return values used in View
        # Input : array("a" => "one", "b" => "two", "c" => "three")
        # Extract(Input) : $a = "one" , $b = "two" , $c = "three"
        $output["status"] = "OK";
        return $output;
    }
}