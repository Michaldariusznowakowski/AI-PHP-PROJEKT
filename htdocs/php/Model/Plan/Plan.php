<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Scrapper/Scrapper.php';
class Plan implements functions_for_model
{
    public function getViewParams($post)
    {
        if (!isset($post['numerPiętra'])) $post['numerPiętra'] = 1;
        $floorNumber = $post['numerPiętra'];
        $buildingNumber = $post['numerBudynku'];
        
        //Fake database
        $floorsList = array(-1,0,1,2);
        //$output = array("HTML_BULDING_NUMBER" => $post['numerBudynku'],
        //                "HTML_SCHEDULE" => $schedule);
        
        $output = array(
            "pageName" => "Plan",
            "HTML_BULDING_NUMBER" => $post['numerBudynku'],
            "HTML_SVG_PLAN" => $this->getPlan($buildingNumber, $floorNumber),
            "HTML_FLOOR_NUMBER" => $floorNumber, // temp
            "HTML_FLOOR_LIST" => $floorsList); // temp
        return $output;
    }
    private function getPlanFilePath($buildingNumber, $floorNumber = 0){
        // TODO: get plan from database
        return "upload/pietro1.svg";
    }
    private function getPlan($buildingNumber, $floorNumber){
        $filePath = $this->getPlanFilePath($buildingNumber, $floorNumber);
        $file = fopen($filePath, "r");
        $fileContent = fread($file, filesize($filePath));
        fclose($file);
        return $fileContent;
    }
}