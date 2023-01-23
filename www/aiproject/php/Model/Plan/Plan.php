<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Scrapper/Scrapper.php';
class Plan implements functions_for_model
{
    public function getViewParams($post)
    {
        $schedule = Scrapper::getSchedule(
            "Barcz",
            "Anna",
            "2023-01-27",
            "2023-01-31");
        # How to return values used in View
        # Input : array("a" => "one", "b" => "two", "c" => "three")
        # Extract(Input) : $a = "one" , $b = "two" , $c = "three"
        
        $output = array("HTML_BULDING_NUMBER" => $post['numerBudynku'],
                        "HTML_SCHEDULE" => $schedule);
        return $output;
    }
}