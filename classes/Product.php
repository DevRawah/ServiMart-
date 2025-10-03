<?php

class Product extends  Service
{

    public static function all()
    {
        return [
            ['name' => 'Phon', 'price' => 50],
            ['name' => 'Keyboard', 'price' => 100],
            ['name' => 'Mouse', 'price' => 50]
        ];
    }
}
