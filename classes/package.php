<?php

class Package
{
    public $ref_number;
    public $recipient;
    public $cash_delivery;
    public $cash_delivery_currency;
    public $weight;
    public $fee;

    public $delivery_price_without_VAT;
    public $delivery_price_with_VAT;
    public $cash_delivery_fee;
    public $price_other_services;
    public $sum;

    function __construct($ref_number, $recipient, $cash_delivery, $cash_delivery_currency, $weight, $fee) {
        $this->ref_number = $ref_number;
        $this->recipient = $recipient;
        $this->cash_delivery = $cash_delivery;
        $this->cash_delivery_currency = $cash_delivery_currency;
        $this->weight = $weight;
        $this->fee = $fee;
    }

    function calculateShipment() {
        switch ($this->recipient->countrycode) {
            case 'SK':
                if ($this->weight >= 0 && $this->weight <= 3) {
                    $this->delivery_price_without_VAT = 2.47;
                } else if ($this->weight > 3 && $this->weight <= 5) {
                    $this->delivery_price_without_VAT = 2.53;
                } else if ($this->weight > 5 && $this->weight <= 10) {
                    $this->delivery_price_without_VAT = 2.63;
                } else if ($this->weight > 10 && $this->weight <= 15) {
                    $this->delivery_price_without_VAT = 2.96;
                } else if ($this->weight > 15 && $this->weight <= 20) {
                    $this->delivery_price_without_VAT = 3.49;
                } else if ($this->weight > 20 && $this->weight <= 25) {
                    $this->delivery_price_without_VAT = 4.57;
                } else if ($this->weight > 25 && $this->weight <= 30) {
                    $this->delivery_price_without_VAT = 5.11;
                } else if ($this->weight > 30 && $this->weight <= 40) {
                    $this->delivery_price_without_VAT = 6.24;
                } else if ($this->weight > 40 && $this->weight <= 50) {
                    $this->delivery_price_without_VAT = 7.31;
                } else if ($this->weight > 50 && $this->weight <= 60) {
                    $this->delivery_price_without_VAT = 9.57;
                } else if ($this->weight > 60 && $this->weight <= 70) {
                    $this->delivery_price_without_VAT = 11.93;
                } else {
                    $this->delivery_price_without_VAT = 0;
                }
                if ($this->weight <= 70) {
                    $this->delivery_price_with_VAT = round($this->delivery_price_without_VAT + $this->delivery_price_without_VAT*0.2, 2,PHP_ROUND_HALF_UP);
                }

                if ($this->cash_delivery != "") {
                    $this->cash_delivery_fee = 0.60;
                }
                
                break;
                
            case 'AT':
                if ($this->weight >= 0 && $this->weight <= 3) {
                    $this->delivery_price_without_VAT = 6.20;
                } else if ($this->weight > 3 && $this->weight <= 5) {
                    $this->delivery_price_without_VAT = 6.70;
                } else if ($this->weight > 5 && $this->weight <= 10) {
                    $this->delivery_price_without_VAT = 7.20;
                } else if ($this->weight > 10 && $this->weight <= 15) {
                    $this->delivery_price_without_VAT = 8.20;
                } else if ($this->weight > 15 && $this->weight <= 20) {
                    $this->delivery_price_without_VAT = 9.20;
                } else if ($this->weight > 20 && $this->weight <= 25) {
                    $this->delivery_price_without_VAT = 11.20;
                } else if ($this->weight > 25 && $this->weight <= 30) {
                    $this->delivery_price_without_VAT = 12.50;
                } else if ($this->weight > 30 && $this->weight <= 40) {
                    $this->delivery_price_without_VAT = 15.80;
                } else if ($this->weight > 40 && $this->weight <= 50) {
                    $this->delivery_price_without_VAT = 18.50;
                } else {
                    $this->delivery_price_without_VAT = 9.25;
                }

                if ($this->cash_delivery != "") {
                    if ($this->cash_delivery <= 1000) {
                        $this->cash_delivery_fee = 4.60;
                    } else {
                        $this->cash_delivery_fee = round($this->cash_delivery*0.016,2,PHP_ROUND_HALF_UP);
                    }
                }
                
                break;
            
            case 'CZ':
            case 'HU':
                if ($this->weight >= 0 && $this->weight <= 5) {
                    $this->delivery_price_without_VAT = 4.35;
                } else if ($this->weight > 5 && $this->weight <= 10) {
                    $this->delivery_price_without_VAT = 4.90;
                } else if ($this->weight > 10 && $this->weight <= 15) {
                    $this->delivery_price_without_VAT = 6.00;
                } else if ($this->weight > 15 && $this->weight <= 20) {
                    $this->delivery_price_without_VAT = 7.50;
                } else if ($this->weight > 20 && $this->weight <= 25) {
                    $this->delivery_price_without_VAT = 8.50;
                } else if ($this->weight > 25 && $this->weight <= 30) {
                    $this->delivery_price_without_VAT = 10.10;
                } else if ($this->weight > 30 && $this->weight <= 40) {
                    $this->delivery_price_without_VAT = 13.60;
                } else if ($this->weight > 40 && $this->weight <= 50) {
                    $this->delivery_price_without_VAT = 16.60;
                } else {
                    $this->delivery_price_without_VAT = 8.80;
                }

                if ($this->cash_delivery != "") {
                    if ($this->cash_delivery <= 500) {
                        $this->cash_delivery_fee = 1.60;
                    } else if ($this->cash_delivery > 500 && $this->cash_delivery <= 1000) {
                        $this->cash_delivery_fee = 3.60;
                    } else {
                        $this->cash_delivery_fee = round($this->cash_delivery*0.0105,2,PHP_ROUND_HALF_UP);
                    }
                }
                
                break;

            default:
                # code...
                break;
        }
        
        if ($this->fee == "ZM")
            $this->price_other_services = 3.49;
        else if ($this->fee == "TsN")
            $this->price_other_services = 3.49;

        $withoutVAT = $this->price_other_services + $this->delivery_price_without_VAT;

        $this->delivery_price_with_VAT = round($withoutVAT + $withoutVAT*0.2, 2,PHP_ROUND_HALF_UP);

        $this->sum = $this->delivery_price_with_VAT + $this->cash_delivery_fee + $this->cash_delivery;
    }
}
