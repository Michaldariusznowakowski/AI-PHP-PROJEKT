<?php
require_once(__DIR__.'\Database.php');

class Rooms{
    private ?int $roomID = null;
    private ?string $roomNumber = null;
    private ?int $roomType = null;
    private ?int $floorID = null;

    public function getRoomID(): ?int{
        return $this->roomID;
    }

    public function setRoomID(?int $roomID) : Rooms{
        $this->roomID = $roomID;
        return $this;
    }

    public function getRoomNumber(): ?string{
        return $this->roomNumber;
    }

    public function setRoomNumber(?string $roomNumber) : Rooms{
        $this->roomNumber = $roomNumber;
        return $this;
    }

    public function getRoomType(): ?int{
        return $this->roomType;
    }

    public function setRoomType(?int $roomType) : Rooms{
        $this->roomType = $roomType;
        return $this;
    }

    public function getFloorID(): ?int{
        return $this->floorID;
    }

    public function setFloorID(?int $floorID) : Rooms{
        $this->floorID = $floorID;
        return $this;
    }

    public static function fromArray($array) : Rooms
    {
        $post = new self();
        $post->fill($array);
        return $post;
    }

    public function fill($array) : Rooms
    {
        if (isset($array['idPokoje']) && ! $this->getRoomID()) {
            $this->setRoomID($array['idPokoje']);
        }
        if (isset($array['NumerPokoju'])) {
            $this->setRoomNumber($array['NumerPokoju']);
        }
        if (isset($array['TypPokoju'])) {
            $this->setRoomType($array['TypPokoju']);
        }
        if (isset($array['Pietra_idPietra'])) {
            $this->setFloorID($array['Pietra_idPietra']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pokoje';
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

    public static function find($roomID): ?Rooms
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pokoje WHERE idPokoje = :idPokoje';
        $statement = $pdo->prepare($sql);
        $statement->execute(['idPokoje' => $roomID]);
        $postArray = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $post = Rooms::fromArray($postArray);
        return $post;
    }

    public function save(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        if (! $this->getRoomID()) {
            $sql = "INSERT INTO pokoje (NumerPokoju, TypPokoju, Pietra_idPietra) VALUES (:NumerPokoju, :TypPokoju, :Pietra_idPietra)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'NumerPokoju' => $this->getRoomNumber(),
                'TypPokoju' => $this->getRoomType(),
                'Pietra_idPietra' => $this->getFloorID(),
            ]);

            $this->setRoomID($pdo->lastInsertId());
        } else {
            $sql = "UPDATE pokoje SET NumerPokoju = :NumerPokoju, TypPokoju = :TypPokoju, Pietra_idPietra = :Pietra_idPietra WHERE idPokoje = :idPokoje";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':idPokoje' => $this->getRoomID(),
                ':NumerPokoju' => $this->getRoomNumber(),
                ':TypPokoju' => $this->getRoomType(),
                ':Pietra_idPietra' => $this->getFloorID(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = "DELETE FROM pokoje WHERE idPokoje = :idPokoje";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':idPokoje' => $this->getRoomID(),
        ]);

        $this->setRoomID(null);
        $this->setRoomNumber(null);
        $this->setRoomType(null);
        $this->setFloorID(null);
    }
}
