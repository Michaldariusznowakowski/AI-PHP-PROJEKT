<?php 
require_once 'php/Model/interface.php';
require_once 'php/Model/Database/Database.php';
class AdminPanel implements functions_for_model
{
    public function getViewParams($post)
    {
		session_start();
	
		$login = $post["login"];
		$haslo = $post["haslo"];
		
		
		$var = new Database();
		$conn = $var->dbConnection();
		
		
		
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
		
		
		if($hasloFromDatabase ==$hash || isset($_SESSION['login'])) {
			
			$_SESSION['login']=$login;
			
			if(isset($post['dodaj_pracownika'])){
				
				$tytul=$post['tytul'];
				$imie=$post['imie'];
				$nazwisko=$post['nazwisko'];
				
				$sql="INSERT INTO pracownicy SET Tytul='$tytul', Imie='$imie', Nazwisko='$nazwisko'";
				$conn->query($sql);
				
				
			}
			if(isset($post['usun_pracownika'])){
				
				$idpracownik=$post['idPracownicy'];
				
				$sql="DELETE FROM pracownicy WHERE idPracownicy='$idpracownik'";
				$conn->query($sql);
				
			}
			if(isset($post['dodaj_budynek'])){
				
				$NumerBudynku=$post['NumerBudynku'];
				$AdresBudynku=$post['AdresBudynku'];
				$OpisDodatkowy=$post['OpisDodatkowy'];
				$SzerokoscGeo=$post['SzerokoscGeo'];
				$DlugoscGeo=$post['DlugoscGeo'];
				
				
				$sql="INSERT INTO budynki SET NumerBudynku=$NumerBudynku, AdresBudynku='$AdresBudynku', OpisDodatkowy='$OpisDodatkowy', SzerokoscGeo=$SzerokoscGeo, DlugoscGeo=$DlugoscGeo";
				$conn->query($sql);
				
				
			}
			if(isset($post['usun_budynek'])){
				
				$idbudynek=$post['idBudynki'];
				
				$sql="DELETE FROM budynki WHERE idBudynki='$idbudynek'";
				$conn->query($sql);
				
			}
			if(isset($post['dodaj_pietro'])){
				
				$NumerPietra=$post['NumerPietra'];
				$Budynki_idBudynki=$post['Budynki_idBudynki'];
				
				
				$sql="INSERT INTO pietra SET NumerPietra=$NumerPietra, Budynki_idBudynki=$Budynki_idBudynki, PhotoUrl='empty'";
				$conn->query($sql);
				
				
			}
			if(isset($post['usun_pietro'])){
				
				$idPietra=$post['idPietra'];
				
				$sql="DELETE FROM pietra WHERE idPietra='$idPietra'";
				$conn->query($sql);
				
			}
			if(isset($post['dodaj_pokoj'])){
				
				$NumerPokoju=$post['NumerPokoju'];
				$TypPokoju=$post['TypPokoju'];
				$Pietra_idPietra=$post['Pietra_idPietra'];
				
				$sql="INSERT INTO pokoje SET NumerPokoju='$NumerPokoju', TypPokoju=$TypPokoju, Pietra_idPietra=Pietra_idPietra";
				$conn->query($sql);
				
				
			}
			if(isset($post['usun_pokoj'])){
				
				$idPokoje=$post['idPokoje'];
				
				$sql="DELETE FROM pokoje WHERE idPokoje='$idPokoje'";
				$conn->query($sql);
				
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
