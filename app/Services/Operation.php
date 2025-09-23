<?php

namespace App\Services;

class Operation
{
    private $option;
    private $number;
    private $result;

    public function __construct($option, $number, $result)
    {
        $this->option = $option;
        $this->number = $number;
        $this->result = $result;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function setOption($option)
    {
        $this->option = $option;
    }
    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }
    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }
}
