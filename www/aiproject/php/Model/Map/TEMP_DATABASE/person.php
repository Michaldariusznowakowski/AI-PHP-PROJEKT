<?php

class person{
    private $name;
    private $surname;
    private $age;
    private $id; // taachers id should be lover that studends for easier use
    private $status;

    /**
     * @param mixed $name
     * @param mixed $surname
     * @param mixed $age
     * @param mixed $id
     * @param mixed $status
     */
    public function __construct($name, $surname, $age, $id, $status) {
    	$this->name = $name;
    	$this->surname = $surname;
    	$this->age = $age;
    	$this->id = $id;
    	$this->status = $status;
    }

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param mixed $name 
	 * @return self
	 */
	public function setName($name): self {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getSurname() {
		return $this->surname;
	}
	
	/**
	 * @param mixed $surname 
	 * @return self
	 */
	public function setSurname($surname): self {
		$this->surname = $surname;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getAge() {
		return $this->age;
	}
	
	/**
	 * @param mixed $age 
	 * @return self
	 */
	public function setAge($age): self {
		$this->age = $age;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id 
	 * @return self
	 */
	public function setId($id): self {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * @param mixed $status 
	 * @return self
	 */
	public function setStatus($status): self {
		$this->status = $status;
		return $this;
	}

    public function __toString()
    {
        return $this->name . " " . $this->surname . " " . $this->age . " status:" . $this->status . " id:" . $this->id;
    }
}