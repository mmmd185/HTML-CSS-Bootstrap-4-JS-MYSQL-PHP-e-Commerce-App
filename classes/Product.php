<?php

class Product extends Service {


    public static function all() { 


        return [
        
            ['name' => 'Mobile', 'price' => 500],
            ['name' => 'Mouse', 'price' => 300],
            ['name' => 'Keyboard', 'price' => 100]

        ];

    }


}


