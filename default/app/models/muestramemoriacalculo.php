<?php

/**
* 
*/
class Muestramemoriacalculo extends ActiveRecord
{
    protected function initialize()
    {
        $this->belongs_to('muestra');
    }
}