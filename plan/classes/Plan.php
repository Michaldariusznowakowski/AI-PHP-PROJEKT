<?php 

class Plan {

  private $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function getFloors($buildingId) {
    $stmt = $this->pdo->prepare('SELECT * FROM floors WHERE building_id = :building_id');
    $stmt->execute(['building_id' => $buildingId]);
    return $stmt->fetchAll();
  }

  public function getRooms($floorId) {
    $stmt = $this->pdo->prepare('SELECT * FROM rooms WHERE floor_id = :floor_id');
    $stmt->execute(['floor_id' => $floorId]);
    return $stmt->fetchAll();
  }


  public function getWorker($roomId) {
	$stmt = $this->pdo->prepare('SELECT * FROM workers WHERE room_id = :room_id');
	$stmt->execute(['room_id' => $roomId]);
	return $stmt->fetch();
  }


  public function getBuilding($buildingId) {
	$stmt = $this->pdo->prepare('SELECT * FROM buildings WHERE id = :id');
	$stmt->execute(['id' => $buildingId]);
	return $stmt->fetch();
  }
}