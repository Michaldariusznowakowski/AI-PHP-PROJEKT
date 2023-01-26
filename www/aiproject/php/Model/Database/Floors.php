<?php
require_once(__DIR__.'\Database.php');

class Floors{
    private ?int $floorID = null;
    private ?int $floorNumber = null;
    private ?int $buildingID = null;
    private ?string $photoUrl = null;

    public function getFloorID(): ?int{
        return $this->floorID;
    }

    public function setFloorID(?int $floorID) : Floors{
        $this->floorID = $floorID;
        return $this;
    }

    public function getFloorNumber(): ?int{
        return $this->floorNumber;
    }

    public function setFloorNumber(?int $floorNumber) : Floors{
        $this->floorNumber = $floorNumber;
        return $this;
    }

    public function getBuildingID(): ?int{
        return $this->buildingID;
    }

    public function setBuildingID(?int $buildingID) : Floors{
        $this->buildingID = $buildingID;
        return $this;
    }

    public function getPhotoUrl(): ?string{
        return $this->photoUrl;
    }

    public function setPhotoUrl(?string $photoUrl) : Floors{
        $this->photoUrl = $photoUrl;
        return $this;
    }

    public static function fromArray($array) : Floors
    {
        $post = new self();
        $post->fill($array);
        return $post;
    }

    public function fill($array) : Floors
    {
        if (isset($array['idPietra']) && ! $this->getFloorID()) {
            $this->setFloorID($array['idPietra']);
        }
        if (isset($array['NumerPietra'])) {
            $this->setFloorNumber($array['NumerPietra']);
        }
        if (isset($array['Budynki_idBudynki'])) {
            $this->setBuildingID($array['Budynki_idBudynki']);
        }
        if (isset($array['PhotoUrl'])) {
            $this->setPhotoUrl($array['PhotoUrl']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pietra';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        print_r($statement);
        $posts = [];
        $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function find($floorID): ?Floors
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pietra WHERE idPietra = :idPietra';
        $statement = $pdo->prepare($sql);
        $statement->execute(['idPietra' => $floorID]);
        $postArray = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $post = Floors::fromArray($postArray);
        return $post;
    }

    public function save(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        if (! $this->getFloorID()) {
            $sql = "INSERT INTO pietra (NumerPietra, Budynki_idBudynki, PhotoUrl) VALUES (:NumerPietra, :Budynki_idBudynki, :PhotoUrl)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'NumerPietra' => $this->getFloorNumber(),
                'Budynki_idBudynki' => $this->getBuildingID(),
                'PhotoUrl' => $this->getPhotoUrl(),
            ]);

            $this->setFloorID($pdo->lastInsertId());
        } else {
            $sql = "UPDATE pietra SET NumerPietra = :NumerPietra, Budynki_idBudynki = :Budynki_idBudynki, PhotoUrl = :PhotoUrl WHERE idPietra = :idPietra";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':idPietra' => $this->getFloorID(),
                ':NumerPietra' => $this->getFloorNumber(),
                ':Budynki_idBudynki' => $this->getBuildingID(),
                ':PhotoUrl' => $this->getPhotoUrl(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = "DELETE FROM pietra WHERE idPietra = :idPietra";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':idPietra' => $this->getFloorID(),
        ]);

        $this->setFloorID(null);
        $this->setFloorNumber(null);
        $this->setBuildingID(null);
        $this->setPhotoUrl(null);
    }
}
