<?php 
class Database {
    private $host = "localhost";
    private $db_name = "dondedb";
    private $username = "root";
    private $password = "";
    public $conn;
    # orm database
    public function dbConnection()
    {
        $this->conn = null;
        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }
        catch(PDOException $exception)
        {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}

class Budynki{
    private ?int $idBudynki = null;
    private ?int $numerBudynku = null;
    private ?string $adresBudynku = null;
    private ?string $opisDodatkowy = null;
    private ?float $szerokoscGeo = null;
    private ?float $dlugoscGeo = null;

    public function getIdBudynki(): ?int{
        return $this->idBudynki;
    }

    public function setIdBudynki(?int $idBudynki) : Budynki{
        $this->idBudynki = $idBudynki;
        return $this;
    }

    public function getNumerBudynku(): ?int{
        return $this->numerBudynku;
    }

    public function setNumerBudynku(?int $numerBudynku) : Budynki{
        $this->numerBudynku = $numerBudynku;
        return $this;
    }

    public function getAdresBudynku(): ?string{
        return $this->adresBudynku;
    }

    public function setAdresBudynku(?string $adresBudynku) : Budynki {
        $this->adresBudynku = $adresBudynku;
        return $this;
    }

    public function getOpisDodatkowy(): ?string{
        return $this->opisDodatkowy;
    }

    public function setOpisDodatkowy(?string $opisDodatkowy) : Budynki {
        $this->opisDodatkowy = $opisDodatkowy;
        return $this;
    }

    public function getSzerokoscGeo(): ?float{
        return $this->szerokoscGeo;
    }

    public function setSzerokoscGeo(?float $szerokoscGeo) : Budynki {
        $this->szerokoscGeo = $szerokoscGeo;
        return $this;
    }

    public function getDlugoscGeo(): ?float{
        return $this->dlugoscGeo;
    }

    public function setDlugoscGeo(?float $dlugoscGeo) : Budynki {
        $this->dlugoscGeo = $dlugoscGeo;
        return $this;
    }

    public static function fromArray($array) : Budynki
    {
        $post = new self();
        $post->fill($array);
        return $post;
    }

    public function fill($array) : Budynki
    {
        if (isset($array['idBudynki']) && ! $this->getIdBudynki()) {
            $this->setIdBudynki($array['idBudynki']);
        }
        if (isset($array['NumerBudynku'])) {
            $this->setNumerBudynku($array['NumerBudynku']);
        }
        if (isset($array['AdresBudynku'])) {
            $this->setAdresBudynku($array['AdresBudynku']);
        }
        if (isset($array['OpisDodatkowy'])) {
            $this->setOpisDodatkowy($array['OpisDodatkowy']);
        }
        if (isset($array['SzerokoscGeo'])) {
            $this->setSzerokoscGeo($array['SzerokoscGeo']);
        }
        if (isset($array['DlugoscGeo'])) {
            $this->setDlugoscGeo($array['DlugoscGeo']);
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
        print_r($statement);
        $posts = [];
        $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($postsArray as $postArray) {
            $posts[] = self::fromArray($postArray);
        }

        return $posts;
    }

    public static function find($idBudynki): ?Budynki
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        $sql = 'SELECT * FROM budynki WHERE idBudynki = :idBudynki';
        $statement = $pdo->prepare($sql);
        $statement->execute(['idBudynki' => $idBudynki]);
        $postArray = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $postArray) {
            return null;
        }
        $post = Budynki::fromArray($postArray);
        return $post;
    }

    public function save(): void
    {
        $pdo = new Database();
        $pdo = $pdo->dbConnection();
        if (! $this->getIdBudynki()) {
            $sql = "INSERT INTO budynki (NumerBudynku, AdresBudynku, OpisDodatkowy, SzerokoscGeo, DlugoscGeo) VALUES (:NumerBudynku, :AdresBudynku, :OpisDodatkowy, :SzerokoscGeo, :DlugoscGeo)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'NumerBudynku' => $this->getNumerBudynku(),
                'AdresBudynku' => $this->getAdresBudynku(),
                'OpisDodatkowy' => $this->getOpisDodatkowy(),
                'SzerokoscGeo' => $this->getSzerokoscGeo(),
                'DlugoscGeo' => $this->getDlugoscGeo(),
            ]);

            $this->setIdBudynki($pdo->lastInsertId());
        } else {
            $sql = "UPDATE budynki SET NumerBudynku = :NumerBudynku, AdresBudynku = :AdresBudynku, OpisDodatkowy = :OpisDodatkowy, SzerokoscGeo = :SzerokoscGeo, DlugoscGeo = :DlugoscGeo WHERE idBudynki = :idBudynki";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':idBudynki' => $this->getIdBudynki(),
                ':NumerBudynku' => $this->getNumerBudynku(),
                ':AdresBudynku' => $this->getAdresBudynku(),
                ':OpisDodatkowy' => $this->getOpisDodatkowy(),
                ':SzerokoscGeo' => $this->getSzerokoscGeo(),
                ':DlugoscGeo' => $this->getDlugoscGeo(),
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
            ':idBudynki' => $this->getIdBudynki(),
        ]);

        $this->setIdBudynki(null);
        $this->setNumerBudynku(null);
        $this->setAdresBudynku(null);
        $this->setOpisDodatkowy(null);
        $this->setSzerokoscGeo(null);
        $this->setDlugoscGeo(null);
    }

}

// $a = new Budynki();
// $a->setNumerBudynku(4);
// $a->setAdresBudynku('Aba');
// $a->setOpisDodatkowy('Budynek 4');
// $a->setSzerokoscGeo(1);
// $a->setDlugoscGeo(1);
// $a->save();
// var_dump(Budynki::find(2));