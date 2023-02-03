<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Database/Database.php';
require_once 'php/Model/Database/Employees.php';
require_once 'php/Model/Database/Buildings.php';
require_once 'php/Model/Database/Floors.php';
require_once 'php/Model/Database/Rooms.php';
class AdminPanel implements functions_for_model
{
    public function getViewParams($post)
    {
		session_start();
		
		$var = new Database();
		$conn = $var->dbConnection();
		
		if(isset($post["login"])){
			
			$login = $post["login"];
			$haslo = $post["haslo"];
			
			
			$conn->exec("CREATE TABLE IF NOT EXISTS users (
				id INT PRIMARY KEY,
				login TEXT NOT NULL,
				haslo TEXT NOT NULL
			);");
			$conn->exec("INSERT IGNORE INTO users (id, login, haslo) VALUES (1, 'student', 'c8decb2f562cbe295637c905870be7a615c456db2aaa9372066a0d740aaf7123a78e56d91c4177048dc756067ab05a0dc74d33b15004ef4170b892e9ab38a0f6');");
			


			$sql="SELECT * FROM users WHERE login='$login'";
			$stmt = $conn->query($sql);
			$row = $stmt->fetch();		
			$hasloFromDatabase=$row['haslo'];
			
			
			$sol = md5("mnxfcgbuirtd");
			$sol2 = sha1("esrf537Ggc");
			$hash = hash('sha512', $haslo . $sol . $sol2);
		}else{
		
			$hasloFromDatabase=1;
			$hash=0;
		
		}
		
		if($hasloFromDatabase ==$hash || isset($_SESSION['login'])) {
			
			
			
			if(!isset($_SESSION['login'])){
				$_SESSION['login']=$login;
			}
			if(isset($post['dodaj_pracownika'])){
				
				$varPracownik = new Employees();	
				
				$tytul=$post['tytul'];
				$imie=$post['imie'];
				$nazwisko=$post['nazwisko'];
				
				$varPracownik->setAcademicTitle($tytul);
				$varPracownik->setName($imie);
				$varPracownik->setSurname($nazwisko);
				$varPracownik->save();
				
				
			}
			if(isset($post['usun_pracownika'])){
				
				$idpracownik=$post['idPracownik'];
				
				$varPracownik = new Employees();
				$varPracownik->setEmployeeID($idpracownik);
				$varPracownik->delete();
				
				
			}
			if(isset($post['dodaj_budynek'])){
				
				
				$varBudynek = new Buildings();
				
				$NumerBudynku=$post['NumerBudynku'];
				$AdresBudynku=$post['AdresBudynku'];
				$OpisDodatkowy=$post['OpisDodatkowy'];
				$SzerokoscGeo=$post['SzerokoscGeo'];
				$DlugoscGeo=$post['DlugoscGeo'];
				
				$varBudynek->setBuildingNumber($NumerBudynku);
				$varBudynek->setBuildingAddress($AdresBudynku);
				$varBudynek->setAdditionalDesc($OpisDodatkowy);
				$varBudynek->setLatitude($SzerokoscGeo);
				$varBudynek->setLongitude($DlugoscGeo);
				
				$varBudynek->save();
				
				
				
			}
			if(isset($post['usun_budynek'])){
				
				$idbudynek=$post['idBudynki'];
				
				$varBudynek = new Buildings();
				$varBudynek->setBuildingID($idbudynek);
				$varBudynek->delete();
				
			}
			if(isset($post['dodaj_pietro'])){
				
				$varPietro = new Floors();
				
				$NumerPietra=$post['NumerPietra'];
				$Budynki_idBudynki=$post['Budynki_idBudynki'];
				
				$varPietro->setFloorNumber($NumerPietra);
				$varPietro->setBuildingID($Budynki_idBudynki);
				
				$varPietro->setPhotoUrl('empty');
				$varPietro->save();
				
				
			}
			if(isset($post['usun_pietro'])){
				
				$idPietra=$post['idPietra'];
				
				$varPietro = new Floors();
				$varPietro->setFloorID($idPietra);
				$varPietro->delete();
				
			}
			if(isset($post['dodaj_pokoj'])){
				
				$varPokoj = new Rooms();
				
				$NumerPokoju=$post['NumerPokoju'];
				$TypPokoju=$post['TypPokoju'];
				$Pietra_idPietra=$post['Pietra_idPietra'];
				
				$varPokoj->setRoomNumber($NumerPokoju);
				$varPokoj->setRoomType($TypPokoju);
				$varPokoj->setFloorID($Pietra_idPietra);
				
				$varPokoj->save();
				
			}
			if(isset($post['usun_pokoj'])){
				
				$varPokoj = new Rooms();
				
				$idPokoje=$post['idPokoje'];
				
				$varPokoj->setRoomID($idPokoje);
				$varPokoj->delete();
				
			}
			$output = array(
			"pageName" => "AdminPanel",
			"status" => "OK",
			"HTML_PRACOWNICY" => $this->getPracownicy($conn),
			"HTML_BUDYNKI" => $this->getBudynki($conn),
			"HTML_PIETRA" => $this->getPietra($conn),
			"HTML_POKOJE" => $this->getPokoje($conn)
			);
			
			
			
		}else{
			
			$output = array("status" => "NOT OK");
			$output["pageName"] = "AdminLogin";
			
		}
		
		
		
        # How to return values used in View
        # Input : array("a" => "one", "b" => "two", "c" => "three")
        # Extract(Input) : $a = "one" , $b = "two" , $c = "three"
        
        return $output;
    }
	private function getPracownicy($conn){
		$pracownicy = array();
        $sql="SELECT * FROM pracownicy";
		$stmt = $conn->query($sql);
		while($row = $stmt->fetch()){
			
			array_push($pracownicy, $row);
		}
        return $pracownicy;
    }
	private function getBudynki($conn){
		$budynki = array();
        $sql="SELECT * FROM budynki";
		$stmt = $conn->query($sql);
		while($row = $stmt->fetch()){
			
			array_push($budynki, $row);
		}
        return $budynki;
    }
	private function getPietra($conn){
		$pietra = array();
        $sql="SELECT * FROM pietra";
		$stmt = $conn->query($sql);
		while($row = $stmt->fetch()){
			
			array_push($pietra, $row);
		}
        return $pietra;
    }
	private function getPokoje($conn){
		$pokoje = array();
        $sql="SELECT * FROM pokoje";
		$stmt = $conn->query($sql);
		while($row = $stmt->fetch()){
			
			array_push($pokoje, $row);
		}
        return $pokoje;
    }
}
