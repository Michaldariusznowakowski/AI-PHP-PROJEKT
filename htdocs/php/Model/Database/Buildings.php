<?php 
require_once(__DIR__.'\Database.php');

class Buildings{
    private ?int $buildingID = null;
    private ?int $buildingNumber = null;
    private ?string $buildingAddress = null;
    private ?string $AdditionalDesc = null;
    private ?float $Latitude = null;
    private ?float $Longitude = null;

    public function getBuildingID(): ?int{
        return $this->buildingID;
    }

    public function setBuildingID(?int $buildingID) : Buildings{
        $this->buildingID = $buildingID;
        return $this;
    }

    public function getBuildingNumber(): ?int{
        return $this->buildingNumber;
    }

    public function setBuildingNumber(?int $buildingNumber) : Buildings{
        $this->buildingNumber = $buildingNumber;
        return $this;
    }

    public function getBuildingAddress(): ?string{
        return $this->buildingAddress;
    }

    public function setBuildingAddress(?string $buildingAddress) : Buildings {
        $this->buildingAddress = $buildingAddress;
        return $this;
    }

    public function getAdditionalDesc(): ?string{
        return $this->AdditionalDesc;
    }

    public function setAdditionalDesc(?string $AdditionalDesc) : Buildings {
        $this->AdditionalDesc = $AdditionalDesc;
        return $this;
    }

    public function getLatitude(): ?float{
        return $this->Latitude;
    }

    public function setLatitude(?float $Latitude) : Buildings {
        $this->Latitude = $Latitude;
        return $this;
    }

    public function getLongitude(): ?float{
        return $this->Longitude;
    }

    public function setLongitude(?float $Longitude) : Buildings {
        $this->Longitude = $Longitude;
        return $this;
    }

    public static function fromArray($array) : Buildings
    {
        $post = new self();
        $post->fill($array);
        return $post;
    }

    public function fill($array) : Buildings
    {
        if (isset($array['idBudynki']) && ! $this->getBuildingID()) {
            $this->setBuildingID($array['idBudynki']);
        }
        if (isset($array['NumerBudynku'])) {
            $this->setBuildingNumber($array['NumerBudynku']);
        }
        if (isset($array['AdresBudynku'])) {
            $this->setBuildingAddress($array['AdresBudynku']);
        }
        if (isset($array['OpisDodatkowy'])) {
            $this->setAdditionalDesc($array['OpisDodatkowy']);
        }
        if (isset($array['SzerokoscGeo'])) {
            $this->setLatitude($array['SzerokoscGeo']);
        }
        if (isset($array['DlugoscGeo'])) {
            $this->setLongitude($array['DlugoscGeo']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM budynki';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        //print_r($statement);
        $posts = [];
        $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function find($buildingID): ?Buildings
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM budynki WHERE idBudynki = :idBudynki';
        $statement = $pdo->prepare($sql);
        $statement->execute(['idBudynki' => $buildingID]);
        $postArray = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $post = Buildings::fromArray($postArray);
        return $post;
    }

    public function save(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        if (! $this->getBuildingID()) {
            $sql = "INSERT INTO budynki (NumerBudynku, AdresBudynku, OpisDodatkowy, SzerokoscGeo, DlugoscGeo) VALUES (:NumerBudynku, :AdresBudynku, :OpisDodatkowy, :SzerokoscGeo, :DlugoscGeo)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'NumerBudynku' => $this->getBuildingNumber(),
                'AdresBudynku' => $this->getBuildingAddress(),
                'OpisDodatkowy' => $this->getAdditionalDesc(),
                'SzerokoscGeo' => $this->getLatitude(),
                'DlugoscGeo' => $this->getLongitude(),
            ]);

            $this->setBuildingID($pdo->lastInsertId());
        } else {
            $sql = "UPDATE budynki SET NumerBudynku = :NumerBudynku, AdresBudynku = :AdresBudynku, OpisDodatkowy = :OpisDodatkowy, SzerokoscGeo = :SzerokoscGeo, DlugoscGeo = :DlugoscGeo WHERE idBudynki = :idBudynki";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':idBudynki' => $this->getBuildingID(),
                ':NumerBudynku' => $this->getBuildingNumber(),
                ':AdresBudynku' => $this->getBuildingAddress(),
                ':OpisDodatkowy' => $this->getAdditionalDesc(),
                ':SzerokoscGeo' => $this->getLatitude(),
                ':DlugoscGeo' => $this->getLongitude(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = "DELETE FROM budynki WHERE idBudynki = :idBudynki";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':idBudynki' => $this->getBuildingID(),
        ]);

        $this->setBuildingID(null);
        $this->setBuildingNumber(null);
        $this->setBuildingAddress(null);
        $this->setAdditionalDesc(null);
        $this->setLatitude(null);
        $this->setLongitude(null);
    }

}

// $a = new Budynki();
// $a->setBuildingID(4);
// $a->delete();
// var_dump(Budynki::find(2));