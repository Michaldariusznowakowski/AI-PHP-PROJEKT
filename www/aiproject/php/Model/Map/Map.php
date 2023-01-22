<?php 
require_once 'php/Model/interface.php';

class Map implements functions_for_model
{
    // TODO 
    // CHANGE FOR DATABASE
    private function CheckBuildingID(&$x, &$y)
    {
        global $buildingsArray;
        $bc = count($buildingsArray);
        for ($buildingIterator = 0; $buildingIterator < count($buildingsArray); ++$buildingIterator) {
            $buildingLocation = $buildingsArray[$buildingIterator]->getLocation();
            $xLoc = $buildingLocation->xLocation;
            $yLoc = $buildingLocation->yLocation;   

            if(bccomp($x, $xLoc, 12) && bccomp($y, $yLoc, 12))
            {
                return $buildingIterator;
            }        
        }
        return -1;
    }

    // TODO 
    // CHANGE FOR DATABASE
    private function GetBuildingData($buildingId)
    {
        global $buildingsArray;
        if ($buildingId == -1 || $buildingId > count($buildingsArray))
        {
            $data = <<<RETURN
            {"ID":"$buildingId","name": "", "content": ""}
            RETURN;
            return -1;
        } 

        // ASDD READING DATA FROM DATABASAE API
        // TEST
        $buildingName = $buildingsArray[$buildingId]->getName();
        $buildingLocaton = $buildingsArray[$buildingId]->getLocation();
        $street = $buildingLocaton->street;
        $bNumber = $buildingLocaton->BuildingNumber;

        $pCode = $buildingLocaton->PostalCode;

        $city = $buildingLocaton->City;

        $data = <<<RETURN
        {"ID":"$buildingId","name": "$buildingName","content": "<form method='get' action='plan.php'> <input name='test' id='t' type='hidden' value='$buildingId'>$buildingName <p>$street, $bNumber</p> <p>$pCode $city</p> <button>$street</button></form>"}
        RETURN;
        // TESTS

        return $data;
    }

    public function getViewParams($post)
    {
        $output = array("MAP_MARKERS" => "");
        $output['MAP_BUTTON_CASES'] = "";
        $output['BUILDING_BUTTONS'] = "";
        $output["DATA"] = "";
        $output["status"] = "OK";

        if(!empty($_POST["Function"]))
        {
            // use requested funcion
            switch($_POST["Function"])
            {
            case 1:
                $x = $_POST["x"];
                $y = $_POST["y"];    
                $buildingId = $this->CheckBuildingID($x, $y);
                $output["DATA"] = $this->GetBuildingData($buildingId);
            break;
            }
            return $output;
        }
        //TODO REWRITE FOR DB
        //CHANGE AFTER DATABASE WORKS
        require_once 'php/Model/Map/TEMP_DATABASE/base.php';
       

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