<?php
require_once("person.php");
class room{
    private int $number;
    private $personsInRoom = array();
    private ?person $roomOwner;

	/**
	 * @return int
	 */
	public function getNumber() {
		return $this->number;
	}
	
	/**
	 * @param int $number 
	 * @return self
	 */
	public function setNumber(int $number): self {
		$this->number = $number;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPersonsInRoom() {
		return $this->personsInRoom;
	}

    public function __toString()
    {
        $result = "room number: " . $this->number . "\n";

        if(count($this->personsInRoom) > 0)
        {
            $result .= "list of people inside: \n";

            for ($PersonInRoomIterator = 0; $PersonInRoomIterator < count($this->personsInRoom); ++$PersonInRoomIterator)
            {
                $result .= $this->personsInRoom[$PersonInRoomIterator] . "\n";
            }
        }
        return $result;
    }
	
	/**
	 * @param mixed $personsInRoom 
	 * @return self
	 */
	public function setPersonsInRoom(...$a_person): self {
        for ($PersonIterator = 0; $PersonIterator < count($a_person); ++$PersonIterator)
        {
            array_push($this->personsInRoom, $a_person[$PersonIterator]);
        }
		return $this;
	}

	/**
	 * @return person
	 */
	public function getRoomOwner(): ?person {
		return $this->roomOwner;
	}

	/**
	 * @param person $roomOwner 
	 * @return self
	 */
	public function setRoomOwner(person $roomOwner): self {
		$this->roomOwner = $roomOwner;
		return $this;
	}

    public function __construct(int $a_number,person $a_roomOwner = null){
    	$this->number = $a_number;
        $this->roomOwner = $a_roomOwner;
    }
}