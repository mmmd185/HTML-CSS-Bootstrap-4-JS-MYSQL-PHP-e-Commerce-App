<?php

class Service {


    public $available = false;
    public $taxRate = 0;

    public function __construct()
    {
        $this->available = true;
    }

    /*public function __destruct()
    {
        echo "The class '" . __CLASS__ . "' has finished!";
    }*/

    public static function all() {

        return [
            
            ['name' => 'Consultation', 'price' => 500, 'days' => ['Sun', 'Mon']],
            ['name' => 'Training', 'price' => 300, 'days' => ['Tues', 'Wed']],
            ['name' => 'Programming', 'price' => 100, 'days' => ['Thur', 'Fri']]

        ];

    }


    public function totalPrice($price) {


        if($this->taxRate > 0) {

            return $price + ($price * $this->taxRate);
            
        }


        return $price;


    }

    
}