<?php 

namespace App\Classes;

class Card {
	public $cardnumber;
	public $cardtype;
	public $cvv;
	public $firstname;
	public $lastname;
	public $month;
	public $year;
	public $holdername;

	public function __construct($cardnumber, $cardtype, $cvv, $holdername, $month, $year){

		$this->cardnumber = $cardnumber;
		$this->cardtype = $cardtype;
		$this->cvv = $cvv;
		$this->month = $month;
		$this->year = $year;
		$this->holdername = $holdername;
	}

	public function getHolderName(){
		$names = explode(" ", $this->holdername);
		$this->firstname = $names[0];
		$this->lastname = $names[count($names) - 1];
		return $this;
	}

}