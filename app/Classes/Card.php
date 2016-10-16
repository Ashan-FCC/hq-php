<?php 

namespace App\Classes;

class Card {
	public $cardnumber;
	public $cardtype;
	public $cvv;
	public $holdername;
	public $month;
	public $year;

	public function __construct($cardnumber, $cardtype, $cvv, $holdername, $month, $year){

		$this->cardnumber = $cardnumber;
		$this->cardtype = $cardtype;
		$this->cvv = $cvv;
		$this->firstname
		$this->lastname 
		$this->month = $month;
		$this->year = $year;

	}

}