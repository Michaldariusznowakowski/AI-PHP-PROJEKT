<?php 
require_once 'php/Model/interface.php';
class Search implements functions_for_model
{
    public function getViewParams($post)
    {
        # How to return values used in View
        # Input : array("a" => "one", "b" => "two", "c" => "three")
        # Extract(Input) : $a = "one" , $b = "two" , $c = "three"
        $output = array("status" => "OK");
        $output["pageName"] = "Search";
        return $output;
    }
}