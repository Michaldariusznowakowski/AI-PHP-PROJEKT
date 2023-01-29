<?php
require_once(__DIR__.'\Database.php');

class Employees{
    private ?int $employeeID = null;
    private ?string $academicTitle = null;
    private ?string $name = null;
    private ?string $surname = null;

    public function getEmployeeID(): ?int{
        return $this->employeeID;
    }

    public function setEmployeeID(?int $employeeID): Employees{
        $this->employeeID = $employeeID;
        return $this;
    }

    public function getAcademicTitle(): ?string{
        return $this->academicTitle;
    }

    public function setAcademicTitle(?string $academicTitle): Employees{
        $this->academicTitle = $academicTitle;
        return $this;
    }

    public function getName(): ?string{
        return $this->name;
    }

    public function setName(?string $name): Employees{
        $this->name = $name;
        return $this;
    }

    public function getSurname(): ?string{
        return $this->surname;
    }

    public function setSurname(?string $surname): Employees{
        $this->surname = $surname;
        return $this;
    }

    public static function fromArray($array) : Employees
    {
        $post = new self();
        $post->fill($array);
        return $post;
    }

    public function fill($array) : Employees
    {
        if (isset($array['idPracownicy']) && ! $this->getEmployeeID()) {
            $this->setEmployeeID($array['idPracownicy']);
        }
        if (isset($array['Tytul'])) {
            $this->setAcademicTitle($array['Tytul']);
        }
        if (isset($array['Imie'])) {
            $this->setName($array['Imie']);
        }
        if (isset($array['Nazwisko'])) {
            $this->setSurname($array['Nazwisko']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pracownicy';
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

    public static function find($employeeID): ?Employees
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM pracownicy WHERE idPracownicy = :idPracownicy';
        $statement = $pdo->prepare($sql);
        $statement->execute(['idPracownicy' => $employeeID]);
        $postArray = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $post = Employees::fromArray($postArray);
        return $post;
    }

    public function save(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        if (! $this->getEmployeeID()) {
            $sql = "INSERT INTO pracownicy (Tytul, Imie, Nazwisko) VALUES (:Tytul, :Imie, :Nazwisko)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'Tytul' => $this->getAcademicTitle(),
                'Imie' => $this->getName(),
                'Nazwisko' => $this->getSurname(),
            ]);

            $this->setEmployeeID($pdo->lastInsertId());
        } else {
            $sql = "UPDATE pracownicy SET Tytul = :Tytul, Imie = :Imie, Nazwisko = :Nazwisko WHERE idPracownicy = :idPracownicy";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':idPracownicy' => $this->getEmployeeID(),
                ':Tytul' => $this->getAcademicTitle(),
                ':Imie' => $this->getName(),
                ':Nazwisko' => $this->getSurname(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = "DELETE FROM pracownicy WHERE idPracownicy = :idPracownicy";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':idPracownicy' => $this->getEmployeeID(),
        ]);

        $this->getEmployeeID(null);
        $this->setAcademicTitle(null);
        $this->setName(null);
        $this->setSurname(null);
    }

}
