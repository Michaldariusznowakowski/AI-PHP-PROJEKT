<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Database/Database.php';
class AdminPanel implements functions_for_model
{
    public function getViewParams($post)
    {
		session_start();
	
		$login = $_POST["login"];
		$haslo = $_POST["haslo"];

		
		$conn = Database::dbConnection();
		$sql="SELECT * FROM users WHERE login='$login'";
		
		$stmt = $conn->query($sql);
		$row = $stmt->fetch();		
		$hasloFromDatabase=$row['haslo'];
		
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
        $output["pageName"] = "AdminPanel";
        return $output;
    }
}
