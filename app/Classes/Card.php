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

	public function __construct($cardnumber, $cardtype, $cvv, $holdername, $month, $year){

		$this->cardnumber = $cardnumber;
		$this->cardtype = $cardtype;
		$this->cvv = $cvv;
		$this->firstname = explode(" ", $holdername)[0];
		$this->lastname =explode(" ", $holdername)[1];
		$this->month = $month;
		$this->year = $year;

	}

}