<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formato
 *
 * @author Cristhian
 */
class Formato extends ActiveRecord
{
    protected function initialize()
    {
        $this->has_many('muestra');
        $this->has_many('tempformatotipoensayo');
        $this->belongs_to('cliente');
        $this->belongs_to('tomadormuestra');
        $this->belongs_to('empresatomadormuestra');
    }
}
