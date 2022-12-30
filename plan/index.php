<head>
  <link rel="stylesheet" href="styles/style.css">
</head>
<?php

require_once 'config.php';
require_once 'classes/Plan.php';


$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);

$plan = new Plan($pdo);


$buildingId = 1;//tutaj bedziemy pobierać $_GET['building_id']


$building = $plan->getBuilding($buildingId);


echo "Budynek: ".$building['name']."<br>";


$floors = $plan->getFloors($buildingId);

foreach ($floors as $floor) {
	
	echo "<div class='floor'>Piętro: ".$floor['number']."</div>";

	$rooms = $plan->getRooms($floor['id']);

	foreach ($rooms as $room) {

		
		echo "<div class='room'>";
		echo "<a href='#' class='room-number'>".$room['number']."</a>";

		
		if ($room['type'] == 'gabinet') {
			
			
			$worker = $plan->getWorker($room['id']);

			
			echo "<div class='worker-info hidden'>";
			echo "<ul>";
			echo "<li>".$worker['title']." ".$worker['first_name']." ".$worker['last_name']."</li>";
			echo "</ul>";
			echo "</div>";
			
		} else if ($room['type'] == 'sala_wykladowa') {
			
		  echo "To jest sala wykładowa<br>";
		  
		}
		echo "</div>";
		
	}
}
?>
<script src="js/script.js"></script>
