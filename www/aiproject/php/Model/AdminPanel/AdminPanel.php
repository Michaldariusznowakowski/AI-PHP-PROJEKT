<?php 
require_once 'php/Model/interface.php';
class AdminPanel implements functions_for_model
{
    public function getViewParams($post)
    {
		
	
		$login = $_POST["login"];
		$haslo = $_POST["haslo"];
		
		$sql="SELECT * FROM users WHERE login='$login'";
		
		$hasloFromDatabase='e833656cfb0e083c09ecc705b5a5b0d7a1faa28008e7f5739f5d96dee2b56af575fe4ddf08cf527a14fb9345bb649d143a9d6cdd2da738e1ed28d97ec63cfd44';
		
		
		$sol = md5("mnxfcgbuirtd");
		$sol2 = sha1("esrf537Ggc");
		$hash = hash('sha512', $haslo . $sol . $sol2);
		
		
		
		if($hasloFromDatabase ==$hash) {
			
			$_SESSION['login']=$login;
			
			$output = array("status" => "OK");
			
		}else if($_SESSION['login']){
			
			$output = array("status" => "OK");
			
		}else{
			
			$output = array("status" => "NOT OK");
			
		}
		
		
		
        # How to return values used in View
        # Input : array("a" => "one", "b" => "two", "c" => "three")
        # Extract(Input) : $a = "one" , $b = "two" , $c = "three"
        
        return $output;
    }
}
