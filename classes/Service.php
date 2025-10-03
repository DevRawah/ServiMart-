<?php
class Service
{
    public $available = false;
    public $taxRate = 0;

    public function  __construct()
    {
        //echo "this class '"  . __CLASS__ ."'has started";
        $this->available = true;
        //$this->price=50;
    }

    public function __destruct()
    {
        //   echo "this class '"  . __CLASS__ ."'was destructed";
    }
    public static  function all()
    {
        return [
            ['name' => 'Design', 'price' => 100, 'days' => ['Mon', 'Sun']],
            ['name' => 'Programming', 'price' => 300, 'days' => ['Tues', 'Wed']],
            ['name' => 'Hacking', 'price' => 500, 'days' => ['Thu', 'Fri']]

        ];
    }
    public function totalprice($price)
    {
        if ($this->taxRate > 0) {
            return $price + ($price * $this->taxRate);
        }
        return $price;
    }
}
