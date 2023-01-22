<?php
require_once("floor.php");

// lokacja dla znacznika na mapie
class location{
    public float $xLocation;
    public float $yLocation;
	//NEW
	public string $street;
	public string $BuildingNumber;
	public string $PostalCode;
	public string $City;
	//ENDNEW
}

// kwadrat do oznaczenia na mapie
class rectangle{
    // do zmiany na same lokacje rogow budynkow ( budynki sa po skosie i nie mam pomyslu na wyliczenie naroznikow z tych danych)
    public float $width;
    public float $height;

    public location $Center;
    
}

class building{
    private string $m_name;
    private $m_listOfFloors = array();
    private location $m_location;

    private rectangle $m_clickArea;

    /**
     * @param string $m_name
     * @param mixed $m_listOfFloors
     * @param location $m_location
     * @param rectangle $clickArea
     */
    public function __construct(string $a_name, float $a_xLocation, float $a_yLocation, float $a_ClickAreaWidth, float $a_ClickAreaHeight, string $a_street, string $a_BuildingNumber, string $a_PostalCode, string $a_City, floor ...$a_listOfFloors) {
        $this->m_name = $a_name;
    	$this->m_listOfFloors = $a_listOfFloors;
        $this->m_location = new location;
        $this->m_clickArea = new rectangle;

        //location of building
    	$this->m_location->xLocation = $a_xLocation;
    	$this->m_location->yLocation = $a_yLocation;
		$this->m_location->street = $a_street;
		$this->m_location->BuildingNumber = $a_BuildingNumber;
		$this->m_location->PostalCode = $a_PostalCode;
		$this->m_location->City = $a_City;
        // clickArea settup

        $this->m_clickArea->Center = $this->m_location;
        $this->m_clickArea->height = $a_ClickAreaHeight;
        $this->m_clickArea->width = $a_ClickAreaWidth;
    }

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->m_name;
	}

	public function getStreet(): string {
		return $this->m_location->street;
	}

	// public function getName(): string {
	// 	return $this->m_name;
	// }

	// public function getName(): string {
	// 	return $this->m_name;
	// }

	// public function getName(): string {
	// 	return $this->m_name;
	// }
	
	/**
	 * @return mixed
	 */
	public function getListOfFloors() {
		return $this->m_listOfFloors;
	}
	
	/**
	 * @return location
	 */
	public function getLocation(): location {
		return $this->m_location;
	}
	
	/**
	 * @return rectangle
	 */
	public function getClickArea(): rectangle {
		return $this->m_clickArea;
	}
}