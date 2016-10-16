<?php

namespace App\Classes\Gateways;
use App\Classes\Transaction;
use App\Classes\Card;

interface Gateway {
	public function name();
	public function processcreditcard(Card $card, Transaction $transaction);
}