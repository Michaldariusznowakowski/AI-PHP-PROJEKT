<?php
require_once(__DIR__.'\Database.php');

class EmployeesInRooms{
    private ?int $employeeID = null;
    private ?int $roomID = null;

    public function getEmployeeID(): ?int{
        return $this->employeeID;
    }

    public function setEmployeeID(?int $employeeID) : EmployeesInRooms{
        $this->employeeID = $employeeID;
        return $this;
    }

    public function getRoomID(): ?int{
        return $this->roomID;
    }

    public function setRoomID(?int $roomID) : EmployeesInRooms{
        $this->roomID = $roomID;
        return $this;
    }

    public static function fromArray($array) : EmployeesInRooms
    {
        $post = new self();
        $post->fill($array);
        return $post;
    }

    public function fill($array) : EmployeesInRooms
    {
        if (isset($array['Pracownicy_idPracownicy'])) {
            $this->setEmployeeID($array['Pracownicy_idPracownicy']);
        }
        if (isset($array['Pokoje_idPokoje'])) {
            $this->setRoomID($array['Pokoje_idPokoje']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pracownicy_w_pokoje';
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $posts = [];
        $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function findByEmployees($employeeID): ?array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pracownicy_w_pokoje WHERE Pracownicy_idPracownicy = :Pracownicy_idPracownicy';
        $statement = $pdo->prepare($sql);
        $statement->execute(['Pracownicy_idPracownicy' => $employeeID]);
        $posts = [];
        $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function findByRooms($roomID): ?array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pracownicy_w_pokoje WHERE Pokoje_idPokoje = :Pokoje_idPokoje';
        $statement = $pdo->prepare($sql);
        $statement->execute(['Pokoje_idPokoje' => $roomID]);
        $posts = [];
        $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public function save() :void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = "INSERT INTO pracownicy_w_pokoje (Pracownicy_idPracownicy, Pokoje_idPokoje) VALUES (:Pracownicy_idPracownicy, :Pokoje_idPokoje)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'Pracownicy_idPracownicy' => $this->getEmployeeID(),
            'Pokoje_idPokoje' => $this->getRoomID(),
        ]);
    }

    public function delete(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = "DELETE FROM pracownicy_w_pokoje WHERE Pracownicy_idPracownicy = :Pracownicy_idPracownicy AND Pokoje_idPokoje = :Pokoje_idPokoje";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':Pracownicy_idPracownicy' => $this->getEmployeeID(),
            ':Pokoje_idPokoje' => $this->getRoomID(),
        ]);

        $this->setEmployeeID(null);
        $this->setRoomID(null);
    }

}

// $a = new EmployeesInRooms();
// $a->setEmployeeID(96);
// $a->setRoomID(1);
// $a->delete();