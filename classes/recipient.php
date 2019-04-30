<?php

class Recipient
{
    public $namecustomer;
    public $street;
    public $city;
    public $postcode;
    public $country;
    public $countrycode;
    public $email;
    public $telephone;

    function __construct($namecust, $street, $city, $postcode, $country, $email, $telephone) {
        $this->namecustomer = $namecust;
        $this->street = $street;
        $this->city = $city;
        $this->postcode = $postcode;
        $this->country = $country;
        $countrycode = array();
        preg_match('/\[(.*?)\]/', $country, $countrycode);
        $this->countrycode = $countrycode[1];
        $this->email = $email;
        $this->telephone = $telephone;
    }
}
