<?php
require_once("person.php");
require_once("room.php");
class floor{
    private int $number;
    private $listOfRooms = array();


    /**
     * @param int $number
     * @param mixed $ListOfRooms
     * @param person $roomOwner
     */
    public function __construct(int $number, ...$rooms) {
    	$this->number = $number;
        for ($roomIterator = 0; $roomIterator < count($rooms); ++$roomIterator)
        {
            array_push($this->listOfRooms, $rooms[$roomIterator]);
        }
    }

	/**
	 * @return int
	 */
	public function getNumber(): int {
		return $this->number;
	}
	
	/**
	 * @return mixed
	 */
	public function getListOfRooms() {
		return $this->listOfRooms;
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
	 * @param mixed $listOfRooms 
	 * @return self
	 */
	public function setListOfRooms($listOfRooms): self {
		$this->listOfRooms = $listOfRooms;
		return $this;
	}

    public function __toString()
    {
        $result = "floor number " . $this->number . "\n";
        $result .= "rooms: \n";
        for ($roomIterator = 0; $roomIterator < count($this->listOfRooms); ++$roomIterator)
        {
            $roomOwner = $this->listOfRooms[$roomIterator]->getRoomOwner();
            if(is_null($roomOwner))
            {
                $result .= "owner: NONE";
            }
            else
            {
                $result .= "owner: " . $roomOwner->getName() . " " . $roomOwner->getSurname();
            }
            $result .= " number: " . $this->listOfRooms[$roomIterator]->getNumber() . " in room: " . count($this->listOfRooms[$roomIterator]->getPersonsInRoom()) . " persons\n";
        } 
        return $result;
    }
}