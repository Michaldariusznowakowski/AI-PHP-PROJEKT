<?php
require_once(__DIR__.'\Database.php');

class Rooms{
    private ?int $roomID = null;
    private ?string $roomNumber = null;
    private ?int $roomType = null;
    private ?int $floorID = null;
    private ?float $x = null;
    private ?float $y = null;
    private ?float $x2 = null;
    private ?float $y2 = null;

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

    public function getX(): ?float{
        return $this->x;
    }

    public function setX(?float $x) : Rooms{
        $this->x = $x;
        return $this;
    }

    public function getY(): ?float{
        return $this->y;
    }

    public function setY(?float $y) : Rooms{
        $this->y = $y;
        return $this;
    }

    public function getX2(): ?float{
        return $this->x2;
    }

    public function setX2(?float $x2) : Rooms{
        $this->x2 = $x2;
        return $this;
    }

    public function getY2(): ?float{
        return $this->y2;
    }

    public function setY2(?float $y2) : Rooms{
        $this->y2 = $y2;
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
        if (isset($array['X'])) {
            $this->setX($array['X']);
        }
        if (isset($array['Y'])) {
            $this->setY($array['Y']);
        }
        if (isset($array['X2'])) {
            $this->setX2($array['X2']);
        }
        if (isset($array['Y2'])) {
            $this->setY2($array['Y2']);
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
            $sql = "INSERT INTO pokoje (NumerPokoju, TypPokoju, Pietra_idPietra, X, Y, X2, Y2) VALUES (:NumerPokoju, :TypPokoju, :Pietra_idPietra, :X, :Y, :X2, :Y2)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'NumerPokoju' => $this->getRoomNumber(),
                'TypPokoju' => $this->getRoomType(),
                'Pietra_idPietra' => $this->getFloorID(),
                'X' => $this->getX(),
                'Y' => $this->getY(),
                'X2' => $this->getX2(),
                'Y2' => $this->getY2(),
            ]);

            $this->setRoomID($pdo->lastInsertId());
        } else {
            $sql = "UPDATE pokoje SET NumerPokoju = :NumerPokoju, TypPokoju = :TypPokoju, Pietra_idPietra = :Pietra_idPietra, X = :X, Y = :Y, X2 = :X2, Y2 = :Y2 WHERE idPokoje = :idPokoje";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':idPokoje' => $this->getRoomID(),
                ':NumerPokoju' => $this->getRoomNumber(),
                ':TypPokoju' => $this->getRoomType(),
                ':Pietra_idPietra' => $this->getFloorID(),
                ':X' => $this->getX(),
                ':Y' => $this->getY(),
                ':X2' => $this->getX2(),
                ':Y2' => $this->getY2(),
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
        $this->setX(null);
        $this->setY(null);
        $this->setX2(null);
        $this->setY2(null);
    }
}
